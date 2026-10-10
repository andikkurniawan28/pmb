<?php 
include('header.php'); 
include('koneksi.php');

// Cek apakah parameter id tersedia di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='turunan_sub_kategori.php';</script>";
    exit();
}

$id = mysqli_real_escape_string($conn, trim($_GET['id']));

// Ambil data turunan_sub_kategori berdasarkan id
$query = "SELECT * FROM turunan_sub_kategori WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$row) {
    echo "<script>alert('Data turunan sub kategori tidak ditemukan!'); window.location.href='turunan_sub_kategori.php';</script>";
    exit();
}

// Ambil daftar sub_kategori beserta informasi gabungan induknya untuk dropdown
$query_sub_kat = "SELECT sub_kat.id, sub_kat.gabungan, sub_kat.keterangan AS ket_sub_kat 
                  FROM sub_kategori sub_kat 
                  ORDER BY sub_kat.gabungan ASC";
$result_sub_kat = mysqli_query($conn, $query_sub_kat);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Turunan Sub Kategori</h1>

    <!-- Form Edit Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Data Turunan Sub Kategori</h6>
        </div>
        <div class="card-body">
            <form action="update_turunan_sub_kategori.php" method="POST">
                <!-- Kirim ID secara tersembunyi (hidden) untuk proses update -->
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label for="sub_kategori_id" class="font-weight-bold">Pilih Sub Kategori (Induk)</label>
                    <select name="sub_kategori_id" id="sub_kategori_id" class="form-control" required>
                        <option value="">-- Pilih Sub Kategori --</option>
                        <?php while ($sk = mysqli_fetch_assoc($result_sub_kat)) : ?>
                            <option value="<?= $sk['id']; ?>" <?= ($row['sub_kategori_id'] == $sk['id']) ? 'selected' : ''; ?>>
                                [<?= $sk['gabungan']; ?>] - <?= $sk['ket_sub_kat']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kode" class="font-weight-bold">Kode Turunan Sub Kategori (D5)</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($row['kode']); ?>" placeholder="Contoh: 01, A, dll..." required>
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
                    <a href="turunan_sub_kategori.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal / Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>