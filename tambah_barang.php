<?php 
include('header.php');
$query_d1  = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_d1 = mysqli_query($conn, $query_d1);
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
        </div>
        <div class="card-body">
            <form action="simpan_barang.php" method="POST">
                <?php include('partial_form_tambah_barang_kode_barang.php'); ?>
                <hr class="my-4" style="border-top: 2px solid #4e73df;">
                <?php include('partial_form_tambah_barang_hierarki_utama.php'); ?>
                <hr class="my-4" style="border-top: 2px solid #4e73df;">
                <?php include('partial_form_tambah_barang_spesifikasi.php'); ?>
                <hr class="my-4" style="border-top: 2px solid #4e73df;">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Barang</button>
                <a href="barang.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php include('partial_form_tambah_barang_js.php'); ?>

<?php include('footer.php'); ?>