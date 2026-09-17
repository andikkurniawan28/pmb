<?php include('header.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid mb-4">

    <!-- Navigasi Utama -->
    <div class="row">

        <!-- Menu Daftar Barang -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Daftar Barang</div>
                            <p class="text-muted small mt-2 mb-0">Lihat, cari, dan kelola seluruh data master barang yang tersimpan.</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr class="my-3">
                    <a href="barang.php" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-list"></i>
                        </span>
                        <span class="text">Buka Daftar Barang</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Menu Tambah Barang -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Tambah Barang</div>
                            <p class="text-muted small mt-2 mb-0">Formulir penambahan barang baru dengan hirarki dan spesifikasi digit.</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr class="my-3">
                    <a href="tambah_barang.php" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Barang Baru</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Menu Label Spesifikasi -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Label Spesifikasi</div>
                            <p class="text-muted small mt-2 mb-0">Lihat, kelola seluruh label spesifikasi.</p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr class="my-3">
                    <a href="aturan_digit.php" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-list"></i>
                        </span>
                        <span class="text">Buka Label Spesifikasi</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>