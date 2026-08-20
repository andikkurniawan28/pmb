<?php include('header.php'); ?>

<?php 
    $query = "SELECT 
                sub_kat.*, 
                utama.kode AS kode_utama,
                sub_kel.kode AS kode_sub_kelompok,
                kat.kode AS kode_kategori
              FROM sub_kategori sub_kat
              JOIN kategori kat ON sub_kat.kategori_id = kat.id
              JOIN sub_kelompok_utama sub_kel ON kat.sub_kelompok_utama_id = sub_kel.id
              JOIN kelompok_utama utama ON sub_kel.kelompok_utama_id = utama.id";
              
    $result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sub Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>D1</th>
                            <th>D2</th>
                            <th>D3</th>
                            <th>D4</th>
                            <th>Gabungan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $row['kode_utama']; ?></td>
                                <td><?= $row['kode_sub_kelompok']; ?></td>
                                <td><?= $row['kode_kategori']; ?></td>
                                <td><?= $row['kode']; ?></td>
                                <td><?= $row['gabungan']; ?></td>
                                <td><?= $row['keterangan']; ?></td>
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