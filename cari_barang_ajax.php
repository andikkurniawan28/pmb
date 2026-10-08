<?php
include('koneksi.php'); // Sesuaikan file koneksi database Anda

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// 1. ENDPOINT DROPDOWN BERTINGKAT (D2 - D5)
if ($action === 'fetch_dropdown') {
    $level = intval($_GET['level'] ?? 0);
    $parent_id = intval($_GET['parent_id'] ?? 0);

    $data = [];
    if ($parent_id > 0) {
        switch ($level) {
            case 2:
                $query = "SELECT id, kode, keterangan FROM sub_kelompok_utama WHERE kelompok_utama_id = $parent_id ORDER BY kode ASC";
                break;
            case 3:
                $query = "SELECT id, kode, keterangan FROM kategori WHERE sub_kelompok_utama_id = $parent_id ORDER BY kode ASC";
                break;
            case 4:
                $query = "SELECT id, kode, keterangan FROM sub_kategori WHERE kategori_id = $parent_id ORDER BY kode ASC";
                break;
            case 5:
                $query = "SELECT id, kode, keterangan FROM turunan_sub_kategori WHERE sub_kategori_id = $parent_id ORDER BY kode ASC";
                break;
            default:
                $query = "";
        }

        if (!empty($query)) {
            $result = mysqli_query($conn, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
        }
    }

    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

// 2. ENDPOINT PENCARIAN BARANG & TABEL HASIL
if ($action === 'search') {
    $keyword = trim($_GET['keyword'] ?? '');
    $d1_id   = intval($_GET['d1_id'] ?? 0);
    $d2_id   = intval($_GET['d2_id'] ?? 0);
    $d3_id   = intval($_GET['d3_id'] ?? 0);
    $d4_id   = intval($_GET['d4_id'] ?? 0);
    $d5_id   = intval($_GET['d5_id'] ?? 0);

    $where = ["1=1"];

    // Filter Global Search (Kode Barang, Nama Barang, Deskripsi, Kode/Nama Lama, Satuan)
    if (!empty($keyword)) {
        $search = mysqli_real_escape_string($conn, $keyword);
        $where[] = "(
            b.kode_barang LIKE '%$search%' OR 
            b.nama_barang LIKE '%$search%' OR 
            b.deskripsi LIKE '%$search%' OR 
            b.kode_barang_lama LIKE '%$search%' OR 
            b.nama_barang_lama LIKE '%$search%' OR 
            b.satuan LIKE '%$search%'
        )";
    }

    // Filter Famili D1 - D5
    if ($d1_id > 0) $where[] = "b.kelompok_utama_id = $d1_id";
    if ($d2_id > 0) $where[] = "b.sub_kelompok_utama_id = $d2_id";
    if ($d3_id > 0) $where[] = "b.kategori_id = $d3_id";
    if ($d4_id > 0) $where[] = "b.sub_kategori_id = $d4_id";
    if ($d5_id > 0) $where[] = "b.turunan_sub_kategori_id = $d5_id";

    $where_clause = implode(' AND ', $where);

    $query = "SELECT b.*, 
                     d1.kode AS kode_d1, 
                     d1.keterangan AS ket_d1
              FROM barang b
              LEFT JOIN kelompok_utama d1 ON b.kelompok_utama_id = d1.id
              WHERE $where_clause
              ORDER BY b.kode_barang ASC
              LIMIT 1000";

    $result = mysqli_query($conn, $query);
    $data = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Action tidak valid']);