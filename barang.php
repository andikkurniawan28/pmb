<?php include('header.php'); ?>

<?php 
    // Menggunakan LEFT JOIN agar data tetap muncul meskipun D4 & D5 bernilai NULL
    $query = "SELECT 
                b.*, 
                utama.kode AS kode_utama,
                sub_kel.kode AS kode_sub_kelompok,
                kat.kode AS kode_kategori,
                sub_kat.kode AS kode_sub_kategori,
                tsk.kode AS kode_turunan_sub_kategori
              FROM barang b
              LEFT JOIN kelompok_utama utama ON b.kelompok_utama_id = utama.id
              LEFT JOIN sub_kelompok_utama sub_kel ON b.sub_kelompok_utama_id = sub_kel.id
              LEFT JOIN kategori kat ON b.kategori_id = kat.id
              LEFT JOIN sub_kategori sub_kat ON b.sub_kategori_id = sub_kat.id
              LEFT JOIN turunan_sub_kategori tsk ON b.turunan_sub_kategori_id = tsk.id
              ORDER BY b.id DESC";
              
    $result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <a href="tambah_barang.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a><br><br>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <!-- <th>D1</th>
                            <th>D2</th>
                            <th>D3</th>
                            <th>D4</th>
                            <th>D5</th> -->
                            <!-- <th>Kode 5 Digit</th> -->
                            <th>Kode</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><strong><?= $row['kode_barang']; ?></strong></td>
                                <td><?= $row['nama_barang']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>