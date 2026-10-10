<?php 
include('header.php'); 
include('koneksi.php');

// 1. Tentukan digit aktif dari URL (default ke 6 jika tidak ada/invalid), batasi hanya angka 6 sampai 15
$digit = isset($_GET['digit']) ? (int)$_GET['digit'] : 0;

// Validasi apakah digit berada di rentang 6 sampai 15
if ($digit < 6 || $digit > 15) {
    echo "<script>alert('Parameter digit tidak valid!'); window.location.href='index.php';</script>";
    exit();
}

// Nama tabel langsung dibuat dinamis sesuai nilai digit yang aktif
$table_name = "digit" . $digit;

$id = mysqli_real_escape_string($conn, trim($_GET['id']));
$query = "SELECT * FROM $table_name WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='digit_handler.php?digit=$digit';</script>";
    exit();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Data Digit <?= $digit; ?> (Tabel: <?= $table_name; ?>)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Data</h6>
        </div>
        <div class="card-body">
            <form action="update_digit.php" method="POST">
                <input type="hidden" name="digit" value="<?= $digit; ?>">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="form-group">
                    <label class="font-weight-bold">D5</label>
                    <input type="text" class="form-control" name="d5" value="<?= htmlspecialchars($row['d5']); ?>" placeholder="Masukkan nilai D5...">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kode</label>
                    <input type="text" class="form-control" name="kode" value="<?= htmlspecialchars($row['kode']); ?>" placeholder="Masukkan kode..." required>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nilai</label>
                    <textarea class="form-control" name="nilai" rows="3" placeholder="Masukkan nilai..." required><?= htmlspecialchars($row['nilai']); ?></textarea>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Perubahan
                    </button>
                    <a href="digit_handler.php?digit=<?= $digit; ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>