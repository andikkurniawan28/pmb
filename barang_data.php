<?php
// Ganti dengan file koneksi Anda (yang membuat variabel $conn),
// JANGAN include header.php karena akan mengeluarkan HTML.
require_once 'koneksi.php';

header('Content-Type: application/json; charset=utf-8');

// Kolom yang boleh dipakai untuk ORDER BY (whitelist, urutan sesuai kolom DataTables)
$kolomOrder = [
    0 => 'kode_barang',
    1 => 'nama_barang',
    2 => 'deskripsi',
    3 => 'catatan',
];

$draw   = (int)($_POST['draw'] ?? 0);
$start  = max(0, (int)($_POST['start'] ?? 0));
$length = (int)($_POST['length'] ?? 25);
$search = trim($_POST['search']['value'] ?? '');

// Urutan
$orderCol = (int)($_POST['order'][0]['column'] ?? 0);
$orderDir = (($_POST['order'][0]['dir'] ?? 'asc') === 'desc') ? 'DESC' : 'ASC';
$orderBy  = $kolomOrder[$orderCol] ?? 'kode_barang';

// Total semua data
$resTotal     = mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang");
$recordsTotal = (int)mysqli_fetch_assoc($resTotal)['total'];

// Filter pencarian
$where  = '';
$params = [];
$types  = '';

if ($search !== '') {
    $where = " WHERE kode_barang LIKE ? OR nama_barang LIKE ? OR deskripsi LIKE ? OR catatan LIKE ? ";
    $like  = '%' . $search . '%';
    $params = [$like, $like, $like, $like];
    $types  = 'ssss';
}

// Total setelah filter
if ($where !== '') {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM barang" . $where);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $recordsFiltered = (int)mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
    mysqli_stmt_close($stmt);
} else {
    $recordsFiltered = $recordsTotal;
}

// Ambil data halaman ini
$sql = "SELECT id, kode_barang, nama_barang, deskripsi, catatan
        FROM barang" . $where . " ORDER BY {$orderBy} {$orderDir}";

$dataParams = $params;
$dataTypes  = $types;

if ($length > 0) {               // length = -1 artinya "tampilkan semua"
    $sql .= " LIMIT ?, ?";
    $dataParams[] = $start;
    $dataParams[] = $length;
    $dataTypes   .= 'ii';
}

$stmt = mysqli_prepare($conn, $sql);
if ($dataTypes !== '') {
    mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = (int)$row['id'];

    $data[] = [
        'kode_barang' => '<strong>' . htmlspecialchars($row['kode_barang'] ?? '') . '</strong>',
        'nama_barang' => htmlspecialchars(mb_strimwidth($row['nama_barang'] ?? '', 0, 50, '...')),
        'deskripsi'   => htmlspecialchars(mb_strimwidth($row['deskripsi'] ?? '', 0, 50, '...')),
        'catatan'     => htmlspecialchars(mb_strimwidth($row['catatan'] ?? '', 0, 30, '...')),
        'aksi'        => '
            <a href="detail_barang.php?id=' . $id . '" class="btn btn-info btn-sm" title="Detail Barang" target="_blank">
                <i class="fas fa-eye"></i> Detail
            </a>
            <a href="edit_barang.php?id=' . $id . '" class="btn btn-warning btn-sm" title="Edit Barang" target="_blank">
                <i class="fas fa-edit"></i> Edit
            </a>'
    ];
}
mysqli_stmt_close($stmt);

echo json_encode([
    'draw'            => $draw,
    'recordsTotal'    => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data'            => $data,
], JSON_UNESCAPED_UNICODE);