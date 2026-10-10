<?php 
include('header.php'); 
include('koneksi.php');

// Cek apakah parameter id tersedia di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='sub_kelompok_utama.php';</script>";
    exit();
}

$id = mysqli_real_escape_string($conn, trim($_GET['id']));

// Ambil data sub kelompok berdasarkan id
$query = "SELECT * FROM sub_kelompok_utama WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='sub_kelompok_utama.php';</script>";
    exit();
}

// Ambil daftar kelompok utama untuk pilihan dropdown
$query_utama = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_utama = mysqli_query($conn, $query_utama);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Sub Kelompok Utama</h1>

    <!-- Form Edit Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Data Sub Kelompok Utama</h6>
        </div>
        <div class="card-body">
            <form action="update_sub_kelompok_utama.php" method="POST">
                <!-- Kirim ID secara tersembunyi (hidden) untuk proses update -->
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label for="kelompok_utama_id" class="font-weight-bold">Pilih Kelompok Utama</label>
                    <select name="kelompok_utama_id" id="kelompok_utama_id" class="form-control" required>
                        <option value="">-- Pilih Kelompok Utama --</option>
                        <?php while ($utama = mysqli_fetch_assoc($result_utama)) : ?>
                            <option value="<?= $utama['id']; ?>" <?= ($row['kelompok_utama_id'] == $utama['id']) ? 'selected' : ''; ?>>
                                [<?= $utama['kode']; ?>] - <?= $utama['keterangan']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kode" class="font-weight-bold">Kode Sub (D2)</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($row['kode']); ?>" placeholder="Contoh: A, 1, dll..." required>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="font-weight-bold">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= htmlspecialchars($row['keterangan']); ?>" placeholder="Masukkan keterangan..." required>
                </div>

                <div class="form-group">
                    <label for="nama_barang" class="font-weight-bold">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($row['nama_barang']); ?>" placeholder="Masukkan nama barang...">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Data
                    </button>
                    <a href="sub_kelompok_utama.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal / Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>