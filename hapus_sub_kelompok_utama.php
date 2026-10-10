<?php
include('koneksi.php');

// Cek apakah parameter id tersedia di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, trim($_GET['id']));

    // Query hapus data berdasarkan id
    $query_delete = "DELETE FROM sub_kelompok_utama WHERE id = '$id'";

    if (mysqli_query($conn, $query_delete)) {
        header("Location: sub_kelompok_utama.php?status=delete_success");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: sub_kelompok_utama.php");
    exit();
}
?>