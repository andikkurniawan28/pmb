<?php include('header.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid mb-4">


        <?php
        /**
         * Card menu PMB (SB Admin 2)
         * Taruh file ini di folder yang sama dengan index.php, lalu panggil:
         *   <?php include 'menu_cards.php'; ?>
         * di dalam <div class="container-fluid"> pada halaman home.
         */

        // Fungsi render satu card (tampilan sama dengan card "Daftar Barang")
        function render_menu_card(array $m): void
        {
            $warna = $m['warna'] ?? 'primary';
        ?>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-<?= $warna; ?> shadow h-100 py-2">
                    <div class="card-body d-flex flex-column">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= htmlspecialchars($m['judul']); ?></div>
                                <p class="text-muted small mt-2 mb-0"><?= htmlspecialchars($m['deskripsi']); ?></p>
                            </div>
                            <div class="col-auto">
                                <i class="fas <?= $m['ikon']; ?> fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="mt-auto">
                            <a href="<?= $m['url']; ?>" class="btn btn-<?= $warna; ?> btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas <?= $m['ikon_tombol'] ?? 'fa-arrow-right'; ?>"></i>
                                </span>
                                <span class="text"><?= htmlspecialchars($m['tombol']); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }

        // ---------------------------------------------------------------
        // 1. Menu Barang
        // ---------------------------------------------------------------
        $menu_barang = [
            [
                'judul'       => 'Daftar Barang',
                'deskripsi'   => 'Lihat, cari, dan kelola seluruh data master barang yang tersimpan.',
                'ikon'        => 'fa-boxes',
                'ikon_tombol' => 'fa-list',
                'url'         => 'barang.php',
                'tombol'      => 'Buka Daftar Barang',
                'warna'       => 'primary',
            ],
            [
                'judul'       => 'Tambah Barang',
                'deskripsi'   => 'Input barang baru lengkap dengan kode dan klasifikasi D1 sampai D15.',
                'ikon'        => 'fa-box-open',
                'ikon_tombol' => 'fa-plus',
                'url'         => 'tambah_barang.php',
                'tombol'      => 'Tambah Barang Baru',
                'warna'       => 'success',
            ],
            [
                'judul'       => 'Cari Barang',
                'deskripsi'   => 'Temukan barang dengan cepat berdasarkan nama, kode, atau kategori.',
                'ikon'        => 'fa-search',
                'ikon_tombol' => 'fa-search',
                'url'         => 'cari_barang.php',
                'tombol'      => 'Mulai Pencarian',
                'warna'       => 'info',
            ],
        ];

        // ---------------------------------------------------------------
        // 2. Menu Master (D1 - D5 + Label Spesifikasi)
        // ---------------------------------------------------------------
        $menu_master = [
            [
                'judul'     => 'D1 Kelompok Utama',
                'deskripsi' => 'Kelola data kelompok utama sebagai tingkat klasifikasi paling atas.',
                'ikon'      => 'fa-layer-group',
                'url'       => 'kelompok_utama.php',
                'tombol'    => 'Kelola D1',
                'warna'     => 'primary',
            ],
            [
                'judul'     => 'D2 Sub Kelompok Utama',
                'deskripsi' => 'Kelola pembagian sub kelompok di bawah kelompok utama.',
                'ikon'      => 'fa-sitemap',
                'url'       => 'sub_kelompok_utama.php',
                'tombol'    => 'Kelola D2',
                'warna'     => 'success',
            ],
            [
                'judul'     => 'D3 Kategori',
                'deskripsi' => 'Kelola kategori barang pada tingkat ketiga klasifikasi.',
                'ikon'      => 'fa-tags',
                'url'       => 'kategori.php',
                'tombol'    => 'Kelola D3',
                'warna'     => 'info',
            ],
            [
                'judul'     => 'D4 Sub Kategori',
                'deskripsi' => 'Kelola sub kategori untuk pengelompokan barang yang lebih detail.',
                'ikon'      => 'fa-tag',
                'url'       => 'sub_kategori.php',
                'tombol'    => 'Kelola D4',
                'warna'     => 'warning',
            ],
            [
                'judul'     => 'D5 Turunan Sub Kategori',
                'deskripsi' => 'Kelola turunan sub kategori sebagai penjabaran lanjutan D4.',
                'ikon'      => 'fa-code-branch',
                'url'       => 'turunan_sub_kategori.php',
                'tombol'    => 'Kelola D5',
                'warna'     => 'danger',
            ],
            [
                'judul'     => 'Label Spesifikasi',
                'deskripsi' => 'Atur aturan digit dan label spesifikasi untuk setiap level digit.',
                'ikon'      => 'fa-clipboard-list',
                'url'       => 'aturan_digit.php',
                'tombol'    => 'Atur Label',
                'warna'     => 'secondary',
            ],
        ];

        // ---------------------------------------------------------------
        // 3. Menu Digit D6 - D15 (dibuat otomatis lewat loop)
        // ---------------------------------------------------------------
        $warna_digit = ['primary', 'success', 'info', 'warning', 'danger'];
        $menu_digit  = [];
        for ($i = 6; $i <= 15; $i++) {
            $menu_digit[] = [
                'judul'     => "D{$i} Digit {$i}",
                'deskripsi' => "Kelola data spesifikasi pada digit ke-{$i} dari kode barang.",
                'ikon'      => 'fa-hashtag',
                'url'       => "digit_handler.php?digit={$i}",
                'tombol'    => "Kelola D{$i}",
                'warna'     => $warna_digit[($i - 6) % count($warna_digit)],
            ];
        }
        ?>

        <!-- ================= Menu Barang ================= -->
        <!-- <h5 class="text-gray-800 font-weight-bold mb-3 mt-2">
            <i class="fas fa-box mr-1"></i> Barang
        </h5> -->
        <div class="row">
            <?php foreach ($menu_barang as $m) render_menu_card($m); ?>
        </div>

        <!-- ================= Menu Master D1 - D5 ================= -->
        <!-- <h5 class="text-gray-800 font-weight-bold mb-3 mt-2">
            <i class="fas fa-folder mr-1"></i> Master
        </h5> -->
        <div class="row">
            <?php foreach ($menu_master as $m) render_menu_card($m); ?>
        </div>

        <div class="row">
            <?php foreach ($menu_digit as $m) render_menu_card($m); ?>
        </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>