<?php
// Mencegah output karakter/warning liar sebelum JSON
ob_start();

include('koneksi.php');

// Clean buffer agar response murni JSON
ob_clean();
header('Content-Type: application/json');

// Ambil input dari JS (misal: "11100")
$kode_input = isset($_POST['kode_5_digit']) ? trim($_POST['kode_5_digit']) : '';

if (empty($kode_input)) {
    echo json_encode(['found' => false]);
    exit;
}

// Bersihkan trailing zero (misal "11100" -> "111")
$clean_prefix = rtrim($kode_input, '0');
if (empty($clean_prefix)) {
    $clean_prefix = $kode_input;
}

/* 
 * Query disesuaikan dengan kolom: kode_kategori
 */
$query  = "SELECT * FROM aturan_digit 
           WHERE kode_kategori = ? 
              OR kode_kategori = ? 
              OR ? LIKE CONCAT(kode_kategori, '%') 
           ORDER BY CHAR_LENGTH(kode_kategori) DESC 
           LIMIT 1";

$stmt   = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo json_encode(['found' => false, 'error' => mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sss", $kode_input, $clean_prefix, $clean_prefix);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Ambil kode_kategori yang cocok dari database (misal "111")
    $matched_kode = $row['kode_kategori']; 
    $options = [];

    // Query Opsi D6 s/d D15 menggunakan $matched_kode ("111")
    for ($i = 6; $i <= 15; $i++) {
        $table = "digit" . $i;
        $options["d{$i}"] = [];

        // Cari record digit6-15 yang d5 nya sesuai ("111")
        $q_opt = "SELECT id, kode, nilai FROM {$table} 
                  WHERE d5 = ? OR d5 = ? OR d5 = ? 
                  ORDER BY kode ASC";
                  
        $stmt_opt = mysqli_prepare($conn, $q_opt);
        if ($stmt_opt) {
            mysqli_stmt_bind_param($stmt_opt, "sss", $matched_kode, $clean_prefix, $kode_input);
            mysqli_stmt_execute($stmt_opt);
            $res_opt = mysqli_stmt_get_result($stmt_opt);
            while ($opt = mysqli_fetch_assoc($res_opt)) {
                $options["d{$i}"][] = $opt;
            }
            mysqli_stmt_close($stmt_opt);
        }
    }

    echo json_encode([
        'found'         => true,
        'matched_kode'  => $matched_kode,
        'nama_kelompok' => $row['nama_kelompok_excel'] ?? '',
        'keterangan'    => !empty($row['keterangan']) ? $row['keterangan'] : ($row['nama_kelompok_excel'] ?? 'Aturan digit berlaku.'),
        'aturan'        => [
            'D6'  => $row['param_d6']  ?? '',
            'D7'  => $row['param_d7']  ?? '',
            'D8'  => $row['param_d8']  ?? '',
            'D9'  => $row['param_d9']  ?? '',
            'D10' => $row['param_d10'] ?? '',
            'D11' => $row['param_d11'] ?? '',
            'D12' => $row['param_d12'] ?? '',
            'D13' => $row['param_d13'] ?? '',
            'D14' => $row['param_d14'] ?? '',
            'D15' => $row['param_d15'] ?? ''
        ],
        'raw_data'      => $row,
        'options'       => $options
    ]);

} else {
    echo json_encode(['found' => false]);
}

mysqli_stmt_close($stmt);
?>