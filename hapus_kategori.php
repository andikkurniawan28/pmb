<?php
include('koneksi.php');

// Cek apakah parameter id tersedia di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, trim($_GET['id']));

    // Query hapus data kategori berdasarkan id
    $query_delete = "DELETE FROM kategori WHERE id = '$id'";

    if (mysqli_query($conn, $query_delete)) {
        header("Location: kategori.php?status=delete_success");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: kategori.php");
    exit();
}
?>