<?php
include('koneksi.php');

if (isset($_POST['update'])) {
    $id          = mysqli_real_escape_string($conn, trim($_POST['id']));
    $keterangan  = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($id) && !empty($keterangan)) {
        // Query untuk memperbarui data berdasarkan id
        $query_update = "UPDATE kelompok_utama SET keterangan = '$keterangan', nama_barang = '$nama_barang' WHERE id = '$id'";

        if (mysqli_query($conn, $query_update)) {
            header("Location: kelompok_utama.php?status=update_success");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Keterangan tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: kelompok_utama.php");
    exit();
}
?>