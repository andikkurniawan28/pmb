<?php 
include('header.php');
$query_d1  = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_d1 = mysqli_query($conn, $query_d1);
?>

<div class="container-fluid mb-4">
    <div class="card shadow-sm mb-3">
        <div class="card-header py-3 px-4 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Barang</h6>
        </div>
        <div class="card-body p-4">
            <form action="simpan_barang.php" method="POST">
                <?php include('partial_form_tambah_barang_kode_barang.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <?php include('partial_form_tambah_barang_hierarki_utama.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <?php include('partial_form_tambah_barang_spesifikasi.php'); ?>
                
                <hr class="my-3" style="border-top: 1px solid #e3e6f0;">
                
                <div class="mt-3 pt-1">
                    <button type="submit" name="submit" class="btn btn-primary px-3 mr-1"><i class="fas fa-save mr-1"></i> Simpan Barang</button>
                    <a href="barang.php" class="btn btn-secondary px-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('partial_form_tambah_barang_js.php'); ?>

<?php include('footer.php'); ?>