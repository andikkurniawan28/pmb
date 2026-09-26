<?php
header('Content-Type: application/json');
ob_clean();

// Sesuaikan dengan file koneksi database Anda
include('koneksi.php');

$digit_level = isset($_POST['digit_level']) ? (int)$_POST['digit_level'] : 0;
$nilai       = isset($_POST['nilai']) ? trim($_POST['nilai']) : '';
$d5_kode     = isset($_POST['d5']) ? trim($_POST['d5']) : '';

// Validasi Input
if ($digit_level < 6 || $digit_level > 15 || empty($nilai) || empty($d5_kode)) {
    echo json_encode([
        'success' => false,
        'message' => 'Parameter tidak lengkap! (Digit Level, Nilai, dan Prefix D5 wajib diisi)'
    ]);
    exit;
}

$table_name = "digit" . $digit_level;

// 1. Cari KODE Terakhir di tabel digitX berdasarkan d5
$sql_check = "SELECT kode FROM {$table_name} WHERE d5 = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("s", $d5_kode);
$stmt->execute();
$result = $stmt->get_result();

$next_kode = '';

/*if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_kode = strtoupper(trim($row['kode']));

    // 2. Logika Auto Increment (1-9, lalu A-Z)
    if (is_numeric($last_kode)) {
        $num = (int)$last_kode;
        if ($num < 9) {
            $next_kode = (string)($num + 1);
        } else {
            $next_kode = 'A'; // Setelah 9 pindah ke A
        }
    } else {
        $char_code = ord($last_kode);
        if ($char_code >= 65 && $char_code < 90) { // A s/d Y
            $next_kode = chr($char_code + 1);
        } else {
            // Sudah sampai Z (Penuh)
            echo json_encode([
                'success' => false,
                'message' => 'Kapasitas kode untuk opsi ini sudah penuh! (Maksimal 1-9 dan A-Z)'
            ]);
            exit;
        }
    }
} else {
    // Jika belum ada data sama sekali untuk d5 ini, mulai dari 1
    $next_kode = '1';
}*/

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_kode = strtoupper(trim($row['kode']));

    // 2. Logika Auto Increment 2 Digit Basis 36 (0-9 lalu A-Z per digit)
    $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // 36 karakter
    $base    = strlen($charset); // 36
    $max_num = ($base * $base) - 1; // ZZ = 1295

    // Konversi kode terakhir (2 digit basis-36) -> desimal
    $current_num = 0;
    $valid = true;
    for ($i = 0; $i < strlen($last_kode); $i++) {
        $pos = strpos($charset, $last_kode[$i]);
        if ($pos === false) {
            $valid = false;
            break;
        }
        $current_num = ($current_num * $base) + $pos;
    }

    if (!$valid) {
        echo json_encode([
            'success' => false,
            'message' => 'Format kode terakhir tidak valid: ' . $last_kode
        ]);
        exit;
    }

    if ($current_num >= $max_num) {
        // Sudah sampai ZZ (Penuh)
        echo json_encode([
            'success' => false,
            'message' => 'Kapasitas kode untuk opsi ini sudah penuh! (Maksimal 00-ZZ)'
        ]);
        exit;
    }

    $next_num = $current_num + 1;

    // Konversi kembali desimal -> 2 digit basis-36 (zero-padded)
    $next_kode = '';
    $n = $next_num;
    for ($i = 0; $i < 2; $i++) {
        $next_kode = $charset[$n % $base] . $next_kode;
        $n = intdiv($n, $base);
    }
} else {
    // Jika belum ada data sama sekali untuk d5 ini, mulai dari 01
    $next_kode = '01';
}

// 3. Simpan Data Baru ke Database
$sql_insert = "INSERT INTO {$table_name} (d5, kode, nilai) VALUES (?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sss", $d5_kode, $next_kode, $nilai);

if ($stmt_insert->execute()) {
    $new_id = $stmt_insert->insert_id;
    echo json_encode([
        'success' => true,
        'id'      => $new_id,
        'kode'    => $next_kode,
        'nilai'   => $nilai,
        'message' => 'Data berhasil disimpan.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan data ke database: ' . $conn->error
    ]);
}

$stmt->close();
$stmt_insert->close();
$conn->close();