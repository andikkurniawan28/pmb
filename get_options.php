<?php
include('koneksi.php'); // Sesuaikan file koneksi database Anda

$level = isset($_POST['level']) ? $_POST['level'] : '';
$parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;

$data = [];

if ($parent_id > 0) {
    if ($level == 'd2') {
        $query = "SELECT id, kode, keterangan FROM sub_kelompok_utama WHERE kelompok_utama_id = $parent_id ORDER BY kode ASC";
    } elseif ($level == 'd3') {
        $query = "SELECT id, kode, keterangan FROM kategori WHERE sub_kelompok_utama_id = $parent_id ORDER BY kode ASC";
    } elseif ($level == 'd4') {
        $query = "SELECT id, kode, keterangan FROM sub_kategori WHERE kategori_id = $parent_id ORDER BY kode ASC";
    } elseif ($level == 'd5') {
        $query = "SELECT id, kode, keterangan FROM turunan_sub_kategori WHERE sub_kategori_id = $parent_id ORDER BY kode ASC";
    }

    if (isset($query)) {
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($data);