<?php 
include('header.php');
// Ambil data awal D1 (Kelompok Utama)
$query_d1  = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_d1 = mysqli_query($conn,$query_d1);
?>

<div class="container-fluid mb-4">
    <!-- CARD UTAMA PENCARIAN & FILTER -->
    <div class="card shadow-sm mb-3">
        <div class="card-header py-3 px-4 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-search mr-1"></i> Cari & Filter Barang
            </h6>
            <button type="button" id="btn_reset" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-undo mr-1"></i> Reset Filter
            </button>
        </div>
        <div class="card-body p-4">
            
            <!-- GLOBAL SEARCHBOX -->
            <div class="form-group mb-4">
                <label for="global_search" class="font-weight-bold text-dark mb-1">
                    <i class="fas fa-keyboard mr-1"></i> Nama, spesifikasi, kode
                </label>
                <div class="input-group">
                    <input type="text" id="global_search" class="form-control" placeholder="Ketik Nama Barang, Spesifikasi, atau Kode Barang..." autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="btn_search">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
                <small class="form-text text-muted">Pencarian akan mencocokkan kode barang, nama barang, dan deskripsi secara otomatis.</small>
            </div>

            <hr class="my-3" style="border-top: 1px solid #e3e6f0;">

            <!-- DROPDOWN FAMILI (D1 - D5) -->
            <h6 class="font-weight-bold text-primary mb-2 small">
                <i class="fas fa-sitemap mr-1"></i> Filter Famili (D1 - D5)
            </h6>
            <div class="row no-gutters mx-n1">
                <!-- D1 -->
                <div class="col-md px-1 mb-1">
                    <label for="d1_id" class="small font-weight-bold mb-0">D1: Kelompok Utama</label>
                    <select class="form-control form-control-sm select-level" data-level="1" name="kelompok_utama_id" id="d1_id">
                        <option value="">-- Semua D1 --</option>
                        <?php while ($d1 = mysqli_fetch_assoc($result_d1)) : ?>
                            <option value="<?= $d1['id']; ?>" data-kode="<?= $d1['kode']; ?>" data-keterangan="<?= htmlspecialchars($d1['keterangan'] ?? ''); ?>">
                                <?= $d1['kode']; ?> - <?= htmlspecialchars($d1['keterangan'] ?? 'Kelompok Utama'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- D2 -->
                <div class="col-md px-1 mb-1">
                    <label for="d2_id" class="small font-weight-bold mb-0">D2: Sub Kelompok</label>
                    <select class="form-control form-control-sm select-level" data-level="2" name="sub_kelompok_utama_id" id="d2_id" disabled>
                        <option value="">-- Semua D2 --</option>
                    </select>
                </div>

                <!-- D3 -->
                <div class="col-md px-1 mb-1">
                    <label for="d3_id" class="small font-weight-bold mb-0">D3: Kategori</label>
                    <select class="form-control form-control-sm select-level" data-level="3" name="kategori_id" id="d3_id" disabled>
                        <option value="">-- Semua D3 --</option>
                    </select>
                </div>

                <!-- D4 -->
                <div class="col-md px-1 mb-1">
                    <label for="d4_id" class="small font-weight-bold mb-0">D4: Sub Kategori</label>
                    <select class="form-control form-control-sm select-level" data-level="4" name="sub_kategori_id" id="d4_id" disabled>
                        <option value="">-- Semua D4 --</option>
                    </select>
                </div>

                <!-- D5 -->
                <div class="col-md px-1 mb-1">
                    <label for="d5_id" class="small font-weight-bold mb-0">D5: Turunan Sub Kategori</label>
                    <select class="form-control form-control-sm select-level" data-level="5" name="turunan_sub_kategori_id" id="d5_id" disabled>
                        <option value="">-- Semua D5 --</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <!-- CARD TABEL HASIL PENCARIAN -->
    <div class="card shadow-sm mb-3">
        <div class="card-header py-3 px-4 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-boxes mr-1"></i> Hasil Pencarian Barang</h6>
            <span id="total_records" class="badge badge-primary font-weight-normal px-2 py-1">0 Barang Ditemukan</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0" id="tabel_barang">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">Kode Barang</th>
                            <th width="25%">Nama Barang</th>
                            <th width="35%">Spesifikasi</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_barang">
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Silakan gunakan searchbox atau filter untuk mencari data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<!-- SCRIPT LOGIK PENCARIAN & CASCADING DROPDOWN -->
<script>
$(document).ready(function() {

    // 1. FUNCTION PENCARIAN (AJAX PANGGIL HASIL BARANG)
    function muatDataBarang() {
        let keyword = $('#global_search').val();
        let d1 = $('#d1_id').val();
        let d2 = $('#d2_id').val();
        let d3 = $('#d3_id').val();
        let d4 = $('#d4_id').val();
        let d5 = $('#d5_id').val();

        $('#tbody_barang').html(`
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="spinner-border text-primary spinner-border-sm mr-2" role="status"></div>
                    Memuat data barang...
                </td>
            </tr>
        `);

        $.ajax({
            url: 'cari_barang_ajax.php',
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'search',
                keyword: keyword,
                d1_id: d1,
                d2_id: d2,
                d3_id: d3,
                d4_id: d4,
                d5_id: d5
            },
            success: function(response) {
                if (response.status === 'success') {
                    let rows = '';
                    let data = response.data;

                    $('#total_records').text(data.length + ' Barang Ditemukan');

                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            rows += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td><span class="badge badge-light border text-dark">${item.kode_barang ?? '-'}</span></td>
                                    <td class="font-weight-bold text-dark">${item.nama_barang ?? '-'}</td>
                                    <td>${item.deskripsi ?? '-'}</td>
                                    <td class="text-center">
                                        <a href="detail_barang.php?id=${item.id}" class="btn btn-sm btn-info px-2 py-1" target="_blank">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                        <a href="edit_barang.php?id=${item.id}" class="btn btn-sm btn-warning px-2 py-1" target="_blank">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = `
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-search-minus fa-2x d-block mb-2 text-secondary"></i>
                                    Tidak ada data barang yang sesuai dengan kriteria pencarian.
                                </td>
                            </tr>
                        `;
                    }
                    $('#tbody_barang').html(rows);
                }
            },
            error: function() {
                $('#tbody_barang').html(`
                    <tr>
                        <td colspan="5" class="text-center text-danger py-4">
                            Gagal memuat data dari server. Silakan coba lagi.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // 2. EVENT TRIGGER DARI GLOBAL SEARCHBOX
    let searchTimer;
    $('#global_search').on('keyup', function() {
        clearTimeout(searchTimer);
        // Delay 300ms saat ngetik agar tidak berat di query
        searchTimer = setTimeout(function() {
            muatDataBarang();
        }, 300);
    });

    $('#btn_search').on('click', function() {
        muatDataBarang();
    });

    // 3. LOGIKA CASCADING DROPDOWN (D1 - D5)
    $('.select-level').on('change', function() {
        let level = parseInt($(this).data('level'));
        let parentId = $(this).val();

        // Reset child dropdowns yang berada di bawah level saat ini
        for (let i = level + 1; i <= 5; i++) {
            let selectChild = $(`#d${i}_id`);
            selectChild.html(`<option value="">-- Semua D${i} --</option>`);
            selectChild.prop('disabled', true);
        }

        // Jika parent terpilih, ambil data untuk level berikutnya via AJAX
        if (parentId && level < 5) {
            let nextLevel = level + 1;
            let selectNext = $(`#d${nextLevel}_id`);

            $.ajax({
                url: 'cari_barang_ajax.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'fetch_dropdown',
                    level: nextLevel,
                    parent_id: parentId
                },
                success: function(res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        let options = `<option value="">-- Semua D${nextLevel} --</option>`;
                        $.each(res.data, function(idx, item) {
                            options += `<option value="${item.id}">${item.kode} - ${item.keterangan}</option>`;
                        });
                        selectNext.html(options);
                        selectNext.prop('disabled', false);
                    }
                }
            });
        }

        // Perbarui data di tabel hasil setiap kali dropdown diubah
        muatDataBarang();
    });

    // 4. RESET FILTER
    $('#btn_reset').on('click', function() {
        $('#global_search').val('');
        $('#d1_id').val('').trigger('change');
        muatDataBarang();
    });

    // Load data awal saat halaman pertama kali dibuka
    muatDataBarang();
});
</script>