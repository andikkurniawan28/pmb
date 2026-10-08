<?php include('header.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <a href="tambah_barang.php" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a><br><br>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabelBarang" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Spesifikasi</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>

<script>
$(document).ready(function () {
    $('#tabelBarang').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'barang_data.php',
            type: 'POST'
        },
        order: [[0, 'asc']],
        pageLength: 25,
        lengthMenu: [10, 25, 50, 100],
        columns: [
            { data: 'kode_barang' },
            { data: 'nama_barang' },
            { data: 'deskripsi' },
            { data: 'catatan' },
            { data: 'aksi', orderable: false, searchable: false }
        ]
    });
});
</script>