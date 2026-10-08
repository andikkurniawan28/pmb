<?php
include('header.php');

// 1. Tangkap ID Barang dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<script>alert('ID Barang tidak valid!'); window.location.href='cari_barang.php';</script>";
    exit;
}

// 2. Query Detail Barang beserta Relasi D1-D5 & D6-D15 (Menggunakan d6.nilai dst)
$query = "SELECT b.*,
            d1.kode AS d1_kode, d1.keterangan AS d1_nama,
            d2.kode AS d2_kode, d2.keterangan AS d2_nama,
            d3.kode AS d3_kode, d3.keterangan AS d3_nama,
            d4.kode AS d4_kode, d4.keterangan AS d4_nama,
            d5.kode AS d5_kode, d5.keterangan AS d5_nama,
            d6.kode AS d6_kode, d6.nilai AS d6_nama,
            d7.kode AS d7_kode, d7.nilai AS d7_nama,
            d8.kode AS d8_kode, d8.nilai AS d8_nama,
            d9.kode AS d9_kode, d9.nilai AS d9_nama,
            d10.kode AS d10_kode, d10.nilai AS d10_nama,
            d11.kode AS d11_kode, d11.nilai AS d11_nama,
            d12.kode AS d12_kode, d12.nilai AS d12_nama,
            d13.kode AS d13_kode, d13.nilai AS d13_nama,
            d14.kode AS d14_kode, d14.nilai AS d14_nama,
            d15.kode AS d15_kode, d15.nilai AS d15_nama
          FROM barang b
          LEFT JOIN kelompok_utama d1 ON b.kelompok_utama_id = d1.id
          LEFT JOIN sub_kelompok_utama d2 ON b.sub_kelompok_utama_id = d2.id
          LEFT JOIN kategori d3 ON b.kategori_id = d3.id
          LEFT JOIN sub_kategori d4 ON b.sub_kategori_id = d4.id
          LEFT JOIN turunan_sub_kategori d5 ON b.turunan_sub_kategori_id = d5.id
          LEFT JOIN digit6 d6 ON b.digit6_id = d6.id
          LEFT JOIN digit7 d7 ON b.digit7_id = d7.id
          LEFT JOIN digit8 d8 ON b.digit8_id = d8.id
          LEFT JOIN digit9 d9 ON b.digit9_id = d9.id
          LEFT JOIN digit10 d10 ON b.digit10_id = d10.id
          LEFT JOIN digit11 d11 ON b.digit11_id = d11.id
          LEFT JOIN digit12 d12 ON b.digit12_id = d12.id
          LEFT JOIN digit13 d13 ON b.digit13_id = d13.id
          LEFT JOIN digit14 d14 ON b.digit14_id = d14.id
          LEFT JOIN digit15 d15 ON b.digit15_id = d15.id
          WHERE b.id = $id
          LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location.href='cari_barang.php';</script>";
    exit;
}

$barang = mysqli_fetch_assoc($result);

// 3. Ambil Aturan Judul Param D6-D15 (Matching Fleksibel antara kode_5_digit dan kode_kategori)
$raw_kode = trim($barang['kode_5_digit'] ?? '');
$clean_kode = mysqli_real_escape_string($conn, str_replace('.', '', $raw_kode));

$aturan = null;
if (!empty($clean_kode)) {
    // Pencocokan: SAMA PERSIS ATAU AWALAN (misal '31W' cocok dengan '31W00' atau '31W')
    $query_aturan = "SELECT * FROM aturan_digit 
                     WHERE REPLACE(kode_kategori, '.', '') = '$clean_kode'
                        OR REPLACE(kode_kategori, '.', '') LIKE '{$clean_kode}%'
                        OR '$clean_kode' LIKE CONCAT(REPLACE(kode_kategori, '.', ''), '%')
                     LIMIT 1";
    $res_aturan = mysqli_query($conn, $query_aturan);
    if ($res_aturan && mysqli_num_rows($res_aturan) > 0) {
        $aturan = mysqli_fetch_assoc($res_aturan);
    }
}
?>

<div class="container-fluid mb-4">
    <!-- BREADCRUMB & NAVIGASI -->
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h4 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-box-open mr-2 text-primary"></i>Detail Barang
        </h1>
        <div>
            <a href="edit_barang.php?id=<?= $barang['id']; ?>" class="btn btn-sm btn-warning shadow-sm px-3 mr-1">
                <i class="fas fa-edit mr-1"></i> Edit Data
            </a>
            <a href="cari_barang.php" class="btn btn-sm btn-secondary shadow-sm px-3">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Pencarian
            </a>
        </div>
    </div>

    <div class="row">
        <!-- KOLOM KIRI: Informasi Utama & Detail Spesifikasi -->
        <div class="col-lg-7">
            <!-- Informasi Identitas Barang -->
            <div class="card shadow-sm mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-1"></i> Informasi Utama Barang
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td width="35%" class="text-muted font-weight-bold">Kode Barang Baru</td>
                            <td width="5%">:</td>
                            <td>
                                <span class="badge badge-primary px-2 py-1 font-weight-bold" style="font-size: 1rem;">
                                    <?= htmlspecialchars($barang['kode_barang'] ?? '-'); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Nama Barang Baru</td>
                            <td>:</td>
                            <td class="font-weight-bold text-dark" style="font-size: 1.05rem;">
                                <?= htmlspecialchars($barang['nama_barang'] ?? '-'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Satuan</td>
                            <td>:</td>
                            <td>
                                <span class="badge badge-info px-2 py-1">
                                    <?= htmlspecialchars($barang['satuan'] ?? 'Tidak Diatur'); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Deskripsi</td>
                            <td>:</td>
                            <td class="text-dark">
                                <?= nl2br(htmlspecialchars($barang['deskripsi'] ?? '-')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Catatan</td>
                            <td>:</td>
                            <td class="text-muted">
                                <?= !empty($barang['catatan']) ? nl2br(htmlspecialchars($barang['catatan'])) : '<em>Tidak ada catatan.</em>'; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- PARAMETER SPESIFIKASI DINAMIS (Berdasarkan aturan_digit) -->
            <div class="card shadow-sm mb-4 border-left-info">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-sliders-h mr-1"></i> Parameter Spesifikasi
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="45%">Parameter Spesifikasi</th>
                                <th width="15%" class="text-center">Kode</th>
                                <th width="40%">Nilai Spesifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_digit_data = false;

                            for ($i = 6; $i <= 15; $i++) :
                                $param_name = $aturan["param_d{$i}"] ?? null;
                                
                                // Hanya proses digit yang param_d*-nya terdefinisi di aturan_digit
                                if (!empty($param_name)) :
                                    $has_digit_data = true;
                                    $digit_kode = $barang["d{$i}_kode"] ?? null;
                                    $digit_nama = $barang["d{$i}_nama"] ?? null;
                            ?>
                                <tr>
                                    <td class="font-weight-bold text-dark"><?= htmlspecialchars($param_name); ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($digit_kode)) : ?>
                                            <span class="badge badge-outline-secondary border px-2"><?= htmlspecialchars($digit_kode); ?></span>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars(!empty($digit_nama) ? $digit_nama : '-'); ?></td>
                                </tr>
                            <?php 
                                endif;
                            endfor; 

                            if (!$has_digit_data) :
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">
                                        <em>Tidak ada parameter spesifikasi yang diatur untuk kategori barang ini.</em>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Legacy Data (Data Barang Lama) -->
            <?php if (!empty($barang['kode_barang_lama']) || !empty($barang['nama_barang_lama']) || !empty($barang['deskripsi_barang_lama'])): ?>
            <div class="card shadow-sm mb-4 border-left-secondary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-history mr-1"></i> Data Referensi Barang Lama
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td width="35%" class="text-muted font-weight-bold">Kode Barang Lama</td>
                            <td width="5%">:</td>
                            <td><code><?= htmlspecialchars($barang['kode_barang_lama'] ?? '-'); ?></code></td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Nama Barang Lama</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($barang['nama_barang_lama'] ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-bold">Deskripsi Lama</td>
                            <td>:</td>
                            <td><?= htmlspecialchars($barang['deskripsi_barang_lama'] ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- KOLOM KANAN: Famili D1-D5 & Metadata -->
        <div class="col-lg-5">
            <!-- Famili & Klasifikasi (D1 - D5) -->
            <div class="card shadow-sm mb-4 border-left-success">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-sitemap mr-1"></i> Hierarki Klasifikasi (D1 - D5)
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">D1: Kelompok Utama</small>
                                <span><?= htmlspecialchars($barang['d1_nama'] ?? '-'); ?></span>
                            </div>
                            <span class="badge badge-success"><?= htmlspecialchars($barang['d1_kode'] ?? '-'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">D2: Sub Kelompok</small>
                                <span><?= htmlspecialchars($barang['d2_nama'] ?? '-'); ?></span>
                            </div>
                            <span class="badge badge-success"><?= htmlspecialchars($barang['d2_kode'] ?? '-'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">D3: Kategori</small>
                                <span><?= htmlspecialchars($barang['d3_nama'] ?? '-'); ?></span>
                            </div>
                            <span class="badge badge-success"><?= htmlspecialchars($barang['d3_kode'] ?? '-'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">D4: Sub Kategori</small>
                                <span><?= htmlspecialchars($barang['d4_nama'] ?? '-'); ?></span>
                            </div>
                            <span class="badge badge-success"><?= htmlspecialchars($barang['d4_kode'] ?? '-'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">D5: Turunan Sub Kategori</small>
                                <span><?= htmlspecialchars($barang['d5_nama'] ?? '-'); ?></span>
                            </div>
                            <span class="badge badge-success"><?= htmlspecialchars($barang['d5_kode'] ?? '-'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Metadata Sistem (Timestamps) -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-clock mr-1"></i> Metadata Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted d-block mb-1">
                        <strong>Dibuat Pada:</strong> <?= !empty($barang['created_at']) ? date('d F Y - H:i:s', strtotime($barang['created_at'])) : '-'; ?>
                    </small>
                    <small class="text-muted d-block">
                        <strong>Terakhir Diperbarui:</strong> <?= !empty($barang['updated_at']) ? date('d F Y - H:i:s', strtotime($barang['updated_at'])) : '-'; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>