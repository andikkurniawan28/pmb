<?php 
include('header.php'); 
include('koneksi.php');

// Cek apakah parameter id tersedia di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='kelompok_utama.php';</script>";
    exit();
}

$id = mysqli_real_escape_string($conn, trim($_GET['id']));

// Ambil data berdasarkan id
$query = "SELECT * FROM kelompok_utama WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan di database
if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='kelompok_utama.php';</script>";
    exit();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Kelompok Utama</h1>

    <!-- Form Edit Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Data Kelompok Utama</h6>
        </div>
        <div class="card-body">
            <form action="update_kelompok_utama.php" method="POST">
                <!-- Kirim ID secara tersembunyi (hidden) untuk proses update -->
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label for="kode" class="font-weight-bold">Kode (D1)</label>
                    <!-- Kode dibuat readonly agar sistem otomatisasinya tidak berantakan, tampil sebagai informasi -->
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($row['kode']); ?>" readonly>
                    <small class="text-muted">Kode otomatis dihasilkan sistem dan tidak dapat diubah secara manual.</small>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="font-weight-bold">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= htmlspecialchars($row['keterangan']); ?>" placeholder="Masukkan keterangan..." required>
                </div>

                <div class="form-group">
                    <label for="nama_barang" class="font-weight-bold">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($row['nama_barang']); ?>" placeholder="Masukkan nama barang..." required>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Data
                    </button>
                    <a href="kelompok_utama.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal / Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>