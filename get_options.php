<?php
include('koneksi.php'); // Sesuaikan file koneksi database Anda

$level        = isset($_POST['level']) ? $_POST['level'] : '';
$parent_id    = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
$digit_number = isset($_POST['digit_number']) ? intval($_POST['digit_number']) : 0;

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
    } elseif ($digit_number >= 6 && $digit_number <= 15) {
        // D6-D15: masing-masing punya tabel sendiri (digit6 ... digit15),
        // semua berelasi ke kolom `d5`, dan kolom keterangannya bernama `nilai`.

        // Whitelist nama tabel supaya $digit_number tidak pernah dipakai
        // untuk membentuk nama tabel sembarangan (aman dari SQL injection).
        $allowed_tables = [];
        for ($i = 6; $i <= 15; $i++) {
            $allowed_tables[$i] = 'digit' . $i;
        }
        $table = $allowed_tables[$digit_number];

        $query = "SELECT id, kode, nilai AS keterangan 
                  FROM `$table` 
                  WHERE d5 = '$parent_id' 
                  ORDER BY kode ASC";
    }

    if (isset($query)) {
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            error_log('get_options.php SQL error: ' . mysqli_error($conn) . ' | Query: ' . $query);
        }
    }
}

header('Content-Type: application/json');
echo json_encode($data);