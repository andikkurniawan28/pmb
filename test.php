<?php

function olahData($conn,$array_barang, $limit,$digit)
{
    $norm = function ($v) { return strtoupper(trim((string)$v)); };

    $mapKelompokUtama       =$digit['mapKelompokUtama'];
    $mapSubKelompokUtama    =$digit['mapSubKelompokUtama'];
    $mapKategori            =$digit['mapKategori'];
    $mapSubKategori         =$digit['mapSubKategori'];
    $mapTurunanSubKategori  =$digit['mapTurunanSubKategori'];
    $mapDigit               =$digit['mapDigit'];

    $values     = [];
    $statMatch  = array_fill(6, 10, 0);$failSample = [];
    $seenKode   = [];$duplikat   = [];   

    // Array penampung sementara untuk menampung digit baru yang akan di-insert massal
    $newDigitsToInsert = []; 
    for ($i = 6; $i <= 15; $i++) {
        $newDigitsToInsert[$i] = [];
    }

    $dataDiProses = array_slice($array_barang, 0,$limit);

    foreach ($dataDiProses as $no =>$row) {
        $rawKodeBarang  = trim((string)($row[3] ?? ''));
        $parts          = array_map('trim', explode('-',$rawKodeBarang));
        $cleanKode      = strtoupper(preg_replace('/s+/', '', str_replace('-', '',$rawKodeBarang)));

        // --- CEK DUPLIKAT ---
        if (isset($seenKode[$cleanKode])) {$duplikat[] = "Baris data #" . ($no + 1)
                . " | kode='{$rawKodeBarang}' | nama='" . (string)($row[4] ?? '') . "'"
                . " | sama dengan baris #" . $seenKode[$cleanKode];
            continue;
        }
        $seenKode[$cleanKode] =$no + 1;

        // Escape string dilakukan sekali di sini
        $kodeBarangLama      = mysqli_real_escape_string($conn, (string)($row[0] ?? ''));
        $namaBarangLama      = mysqli_real_escape_string($conn, (string)($row[1] ?? ''));$deskripsiBarangLama = mysqli_real_escape_string($conn, (string)($row[2] ?? ''));
        $kodeBarangClean     = mysqli_real_escape_string($conn, $cleanKode);$namaBarang          = mysqli_real_escape_string($conn, (string)($row[4] ?? ''));
        $deskripsi           = mysqli_real_escape_string($conn, (string)($row[5] ?? ''));$catatan             = mysqli_real_escape_string($conn, (string)($row[26] ?? ''));

        // --- DIGIT 1 - 5 ---
        $lvl = (count($parts) >= 5) ? $parts : str_split(substr($cleanKode, 0, 5));

        $p0 = isset($lvl[0]) ? $norm($lvl[0]) : null;
        $p1 = isset($lvl[1]) ? $norm($lvl[1]) : null;
        $p2 = isset($lvl[2]) ? $norm($lvl[2]) : null;
        $p3 = isset($lvl[3]) ? $norm($lvl[3]) : null;
        $p4 = isset($lvl[4]) ? $norm($lvl[4]) : null;

        $kuData              = ($p0 !== null) ? ($mapKelompokUtama[$p0] ?? null) : null;
        $kelompokUtamaId     =$kuData['id'] ?? null;
        $code0               =$kuData['kode'] ?? '';

        $skuData             = ($kelompokUtamaId && $p1 !== null) ? ($mapSubKelompokUtama[$kelompokUtamaId][$p1] ?? null) : null;
        $subKelompokUtamaId  =$skuData['id'] ?? null;
        $code1               =$skuData['kode'] ?? '';

        $katData             = ($subKelompokUtamaId && $p2 !== null) ? ($mapKategori[$subKelompokUtamaId][$p2] ?? null) : null;
        $kategoriId          =$katData['id'] ?? null;
        $code2               =$katData['kode'] ?? '';

        $sKatData            = ($kategoriId && $p3 !== null) ? ($mapSubKategori[$kategoriId][$p3] ?? null) : null;
        $subKategoriId       =$sKatData['id'] ?? null;
        $code3               =$sKatData['kode'] ?? '';

        $tSKatData           = ($subKategoriId && $p4 !== null) ? ($mapTurunanSubKategori[$subKategoriId][$p4] ?? null) : null;
        $turunanSubKategoriId =$tSKatData['id'] ?? null;
        $code4               =$tSKatData['kode'] ?? '';

        $kode5DigitPlain     =$code0 . $code1 .$code2 . $code3 .$code4;
        $kode5DigitEscaped   = mysqli_real_escape_string($conn,$kode5DigitPlain);

        // --- DIGIT 6 - 15 ---
        $candidateKeys = [];$acc = '';
        for ($k = 0; $k < 5; $k++) {
            if (!isset($lvl[$k])) break;
            $acc .=$lvl[$k];$candidateKeys[] = $norm($acc);
        }

        for ($len = 5; $len >= 1; $len--) {$candidateKeys[] = substr($cleanKode, 0,$len);
        }

        if ($kode5DigitPlain !== '') {$candidateKeys[] = $norm($kode5DigitPlain);
        }

        $candidateKeys = array_values(array_unique(array_filter($candidateKeys, function ($v) {
            return $v !== '';
        })));

        $digitIds = [];
        $primaryKey =$candidateKeys[0] ?? $norm($kode5DigitPlain);

        for ($i = 6; $i <= 15; $i++) {
            $digitIds[$i] = "NULL";

            $arrayIdxKode  = 6 + (($i - 6) * 2);
            $arrayIdxNilai =$arrayIdxKode + 1;

            $valKode  = trim((string)($row[$arrayIdxKode] ?? ''));$valNilai = trim((string)($row[$arrayIdxNilai] ?? ''));

            if ($valKode === '' ||$valKode === '00') {
                continue;
            }

            $normKode  =$norm($valKode);$foundId   = null;

            // 1. Cari di map memori
            foreach ($candidateKeys as$key) {
                if (isset($mapDigit[$i][$key][$normKode])) {$foundId = (int)$mapDigit[$i][$key][$normKode];
                    $statMatch[$i]++;
                    break;
                }
            }

            // 2. Jika tidak ketemu di memori, masukkan ke penampung untuk di-insert massal nanti
            if ($foundId === null &&$kode5DigitPlain !== '') {
                // Tandai sementara sebagai string unik atau masukkan ke queue penampung
                $newDigitsToInsert[$i][$primaryKey][$normKode] = [
                    'd5'    => $kode5DigitPlain,
                    'kode'  => $valKode,
                    'nilai' => $valNilai
                ];
                // Agar tidak error saat kueri SQL dibentuk, untuk sementara di-set NULL dulu 
                // (nanti setelah bulk insert digit selesai, ID bisa di-resolve atau diproses)
            } else if ($foundId !== null) {$digitIds[$i] =$foundId;
            }

            if ($digitIds[$i] === "NULL" && $i === 6 && count($failSample) < 5) {$failSample[] = "kode='{$rawKodeBarang}' | kodePart digit6='{$valKode}'";
            }
        }

        $kuId    =$kelompokUtamaId ?? "NULL";
        $skuId   =$subKelompokUtamaId ?? "NULL";
        $katId   =$kategoriId ?? "NULL";
        $skatId  =$subKategoriId ?? "NULL";
        $tskatId =$turunanSubKategoriId ?? "NULL";

        $values[] = "("
            . "'$kodeBarangLama', '$namaBarangLama', '$deskripsiBarangLama', "
            . "'$kodeBarangClean', '$namaBarang', '$deskripsi', '$catatan', "
            . "'$kode5DigitEscaped',$kuId, $skuId,$katId, $skatId,$tskatId, "
            . "{$digitIds[6]}, {$digitIds[7]}, {$digitIds[8]}, {$digitIds[9]}, {$digitIds[10]}, "
            . "{$digitIds[11]}, {$digitIds[12]}, {$digitIds[13]}, {$digitIds[14]}, {$digitIds[15]}"
            . ")";
    }

    // [OPTIMASI KECCEPATAN] Eksekusi Bulk Insert untuk semua data digit baru sekaligus agar tidak query di dalam perulangan
    foreach ($newDigitsToInsert as $i =>$keysData) {
        foreach ($keysData as $primaryKey =>$codes) {
            if (empty($codes)) continue;
            
            $tableName = "digit{$i}";
            $chunkValues = [];
            foreach ($codes as$normKode => $d) {$escD5   = mysqli_real_escape_string($conn,$d['d5']);
                $escKode = mysqli_real_escape_string($conn, $d['kode']);$escNilai= mysqli_real_escape_string($conn,$d['nilai']);
                $chunkValues[] = "('{$escD5}', '{$escKode}', '{$escNilai}')";
            }

            if (!empty($chunkValues)) {
                // Insert massal per tabel digit
                $sqlBulk = "INSERT IGNORE INTO `{$tableName}` (d5, kode, nilai) VALUES " . implode(', ', $chunkValues);
                mysqli_query($conn,$sqlBulk);
                
                // Ambil ulang data ID yang baru saja dimasukkan agar langsung ter-mapping ke memori
                $resNew = mysqli_query($conn, "SELECT id, d5, kode FROM `{$tableName}`");
                if ($resNew) {
                    while ($rn = mysqli_fetch_assoc($resNew)) {$mapDigit[$i][$norm($rn['d5'])][$norm($rn['kode'])] = (int)$rn['id'];
                    }
                }
            }
        }
    }

    return [
        'values'       => $values,
        'duplikat'     => $duplikat,
        'dataDiProses' => $dataDiProses,
        'statMatch'    => $statMatch,
        'failSample'   => $failSample
    ];
}

function masukkanData($conn,$hasil_olahan)
{
    $values       =$hasil_olahan['values'];
    $duplikat     =$hasil_olahan['duplikat'];
    $dataDiProses =$hasil_olahan['dataDiProses'];
    $statMatch    =$hasil_olahan['statMatch'];
    $failSample   =$hasil_olahan['failSample'];

    if (!empty($values)) {$insertHead = "INSERT INTO `barang` (
                kode_barang_lama, nama_barang_lama, deskripsi_barang_lama,
                kode_barang, nama_barang, deskripsi, catatan, kode_5_digit,
                kelompok_utama_id, sub_kelompok_utama_id, kategori_id,
                sub_kategori_id, turunan_sub_kategori_id,
                digit6_id, digit7_id, digit8_id, digit9_id, digit10_id,
                digit11_id, digit12_id, digit13_id, digit14_id, digit15_id
            ) VALUES ";

        $berhasil  = 0;
        $errorLain = [];

        // [OPTIMASI KECCEPATAN] Kapasitas per batch dinaikkan menjadi 1000 baris agar proses INSERT ke database jauh lebih sedikit round-trip-nya
        foreach (array_chunk($values, 1000) as $n =>$chunk) {
            try {
                mysqli_query($conn, $insertHead . implode(', ', $chunk));
                $berhasil += mysqli_affected_rows($conn);
            } catch (mysqli_sql_exception $e) {
                $errorLain[] = "Batch #" . ($n + 1) . " (" . count($chunk) . " baris) gagal: " . $e->getMessage();
                continue; 
            }
        }

        echo "<b>Selesai!</b> {$berhasil} dari " . count($dataDiProses) . " baris masuk ke tabel <code>barang</code>.<br>";

        if (!empty($duplikat)) {
            echo "<b>" . count($duplikat) . " baris duplikat dilewati:</b><br>"
                 . implode("<br>", array_map('htmlspecialchars', array_slice($duplikat, 0, 50)))
                 . (count($duplikat) > 50 ? "<br>... dan " . (count($duplikat) - 50) . " lainnya" : "")
                 . "<br>";
        }

        if (!empty($errorLain)) {
            echo "<b>Error lain:</b><br>"
                 . implode("<br>", array_map('htmlspecialchars', $errorLain)) . "<br>";
        }

        echo "<b>Jumlah baris cocok per digit</b> (dari " . count($values) . " baris unik): ";
        foreach ($statMatch as $d =>$n) {
            echo "d{$d}={$n} ";
        }
        echo "<br>";

        if (!empty($failSample)) {
            echo "<b>Contoh gagal (digit 6):</b><br>" . implode("<br>", array_map('htmlspecialchars', $failSample)) . "<br>";
        }
    } else {
        echo "<b>Peringatan:</b> Tidak ada data yang di-insert karena array barang kosong.<br>";
    }

    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1;");
    return true;
}
