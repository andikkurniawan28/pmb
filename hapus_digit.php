<?php
include('koneksi.php');

// 1. Tentukan digit aktif dari URL (default ke 6 jika tidak ada/invalid), batasi hanya angka 6 sampai 15
$digit = isset($_GET['digit']) ? (int)$_GET['digit'] : 0;

// Validasi apakah digit berada di rentang 6 sampai 15
if ($digit < 6 || $digit > 15) {
    echo "<script>alert('Parameter digit tidak valid!'); window.location.href='index.php';</script>";
    exit();
}

// Nama tabel langsung dibuat dinamis sesuai nilai digit yang aktif
$table_name = "digit" . $digit;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, trim($_GET['id']));

    $query_delete = "DELETE FROM $table_name WHERE id = '$id'";

    if (mysqli_query($conn, $query_delete)) {
        header("Location: digit_handler.php?digit=$digit&status=delete_success");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: digit_handler.php?digit=$digit");
    exit();
}
?>