<?php
include('koneksi.php');

if (isset($_POST['simpan'])) {
    // Tangkap digit dari form POST secara ketat tanpa nilai default
    $digit = isset($_POST['digit']) ? (int)$_POST['digit'] : 0;

    // Validasi ketat: jika di luar rentang 6-15, hentikan proses dan tolak
    if ($digit < 6 || $digit > 15) {
        echo "<script>alert('Aksi ditolak: Parameter digit tidak valid!'); window.location.href='index.php';</script>";
        exit();
    }

    $table_name = "digit" . $digit;

    $d5    = mysqli_real_escape_string($conn, trim($_POST['d5']));
    $kode  = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $nilai = mysqli_real_escape_string($conn, trim($_POST['nilai']));

    if (!empty($kode) && !empty($nilai)) {
        $query_insert = "INSERT INTO $table_name (d5, kode, nilai) VALUES ('$d5', '$kode', '$nilai')";
        
        if (mysqli_query($conn, $query_insert)) {
            header("Location: digit_handler.php?digit=$digit&status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Kode dan Nilai tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: digit_handler.php");
    exit();
}
?>