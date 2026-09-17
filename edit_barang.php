<?php 
include('header.php');

// 1. Validasi Parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID Barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit();
}

$id_barang = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Query Record Barang yang Akan Diedit
$query_barang  = "SELECT * FROM barang WHERE id = '$id_barang' LIMIT 1";
$result_barang = mysqli_query($conn, $query_barang);

if (mysqli_num_rows($result_barang) == 0) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='barang.php';</script>";
    exit();
}

$barang = mysqli_fetch_assoc($result_barang);

// 3. Query Pendukung Utama (D1)
$query_d1  = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_d1 = mysqli_query($conn, $query_d1);
?>

<div class="container-fluid mb-4">
    <div class="card shadow-sm mb-3">
        <div class="card-header py-3 px-4 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Edit Barang</h6>
        </div>
        <div class="card-body p-4">
            <!-- Form Mengarah ke update_barang.php -->
            <form action="update_barang.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($barang['id']); ?>">

                <!-- Tetap Gunakan Partial Form Tambah -->
                <?php include('partial_form_edit_barang_kode_barang.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <?php include('partial_form_tambah_barang_hierarki_utama.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <?php include('partial_form_tambah_barang_spesifikasi.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <div class="mt-3 pt-1">
                    <button type="submit" name="update" class="btn btn-primary px-3 mr-1">
                        <i class="fas fa-save mr-1"></i> Update Barang
                    </button>
                    <a href="barang.php" class="btn btn-secondary px-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Auto Load Sequence Edit -->
<?php include('partial_form_edit_barang_js.php'); ?>

<?php include('footer.php'); ?>