<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // Flag untuk menandai apakah user sedang berinteraksi manual atau sistem sedang loading awal
    var isManualChange = false;

    // 1. Tangkap Data Saved ID D1-D15 sesuai nama kolom tabel `barang`
    const savedValues = {
        d1:  "<?= $barang['kelompok_utama_id'] ?? '' ?>",
        d2:  "<?= $barang['sub_kelompok_utama_id'] ?? '' ?>",
        d3:  "<?= $barang['kategori_id'] ?? '' ?>",
        d4:  "<?= $barang['sub_kategori_id'] ?? '' ?>",
        d5:  "<?= $barang['turunan_sub_kategori_id'] ?? '' ?>",
        d6:  "<?= $barang['digit6_id'] ?? '' ?>",
        d7:  "<?= $barang['digit7_id'] ?? '' ?>",
        d8:  "<?= $barang['digit8_id'] ?? '' ?>",
        d9:  "<?= $barang['digit9_id'] ?? '' ?>",
        d10: "<?= $barang['digit10_id'] ?? '' ?>",
        d11: "<?= $barang['digit11_id'] ?? '' ?>",
        d12: "<?= $barang['digit12_id'] ?? '' ?>",
        d13: "<?= $barang['digit13_id'] ?? '' ?>",
        d14: "<?= $barang['digit14_id'] ?? '' ?>",
        d15: "<?= $barang['digit15_id'] ?? '' ?>"
    };

    function resetSubDropdowns(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id').html('<option value="">-- Pilih D' + i + ' --</option>').prop('disabled', true);
        }
    }

    function resetLabels() {
        for (var i = 6; i <= 15; i++) {
            $('#label_d' + i).html('Parameter D' + i).addClass('text-secondary').removeClass('text-primary');
        }
    }

    <?php include('partial_form_tambah_barang_js_checkAturanDigit.php'); ?>

    /**
     * 1. FUNGSI MANDIRI: HANYA UNTUK GENERATE & UPDATE KODE BARANG
     * Selalu berjalan independen agar kode 25 digit selalu terbentuk.
     *
     * Parameter "onDone" (opsional): dipanggil SETELAH checkAturanDigit selesai
     * mengisi dropdown D6-D15. Dipakai saat kita perlu menunggu dropdown
     * benar-benar terisi sebelum memasang nilai tersimpan (lihat initEditSequence).
     */
    function generateKodeBarangOnly(onDone) {
        var fullCode = '';

        for (var i = 1; i <= 15; i++) {
            var selectedOption = $('#d' + i + '_id option:selected');
            var selectedKode = selectedOption.data('kode');
            
            if (selectedKode !== undefined && selectedKode !== '' && selectedKode !== null) {
                fullCode += String(selectedKode);
            } else {
                fullCode += '00';
            }
        }

        // Set nilai ke input kode_barang
        $('#kode_barang').val(fullCode);

        // Jalankan pengecekan aturan digit untuk D6-D15 (ini yang mengisi dropdown D6-D15)
        if (typeof checkAturanDigit === 'function') {
            checkAturanDigit(fullCode, onDone);
        } else if (typeof onDone === 'function') {
            // Jaga-jaga kalau checkAturanDigit tidak ada, tetap lanjutkan alur
            onDone();
        }

        return fullCode;
    }

    /**
     * 2. FUNGSI MANDIRI: UNTUK UPDATE NAMA & DESKRIPSI BARANG
     * Hanya berjalan jika dipicu oleh perubahan manual user di dropdown.
     */
    function updateNamaDanDeskripsi() {
        var namaBarangParts = [];
        var deskripsiParts = [];

        for (var i = 1; i <= 15; i++) {
            var selectedOption = $('#d' + i + '_id option:selected');
            var selectedKeterangan = selectedOption.data('keterangan');

            if (selectedKeterangan !== undefined && selectedKeterangan !== '' && selectedKeterangan !== null) {
                if (i <= 5) {
                    namaBarangParts.push(selectedKeterangan);
                } else {
                    deskripsiParts.push(selectedKeterangan);
                }
            }
        }

        var fullNamaBarang = namaBarangParts.join(' - ');
        var fullDeskripsi = deskripsiParts.join(', ');

        $('#nama_barang').val(fullNamaBarang);
        $('#deskripsi').val(fullDeskripsi);
    }

    /**
     * FUNGSI GABUNGAN UTAMA
     */
    function updateKodeBarang() {
        // Generate kode barang & pemicu aturan digit selalu berjalan
        generateKodeBarangOnly();

        // Nama barang & deskripsi HANYA diubah jika user secara manual mengganti dropdown
        if (isManualChange) {
            updateNamaDanDeskripsi();
        }
    }

    function autoFillZeroes(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id')
                .html('<option value="" data-kode="00" selected>00</option>')
                .prop('disabled', false);
        }
        updateKodeBarang();
    }

    /**
     * FUNGSI MANDIRI: FETCH & SET SATU LEVEL DROPDOWN
     * CATATAN PENTING: fungsi ini HANYA dipakai untuk rantai D1 -> D5.
     * D6-D15 TIDAK memakai fungsi ini lagi -- dropdown D6-D15 diisi oleh
     * checkAturanDigit() (lihat file partial_form_tambah_barang_js_checkAturanDigit.php),
     * karena isi dropdownnya ditentukan oleh tabel aturan_digit, bukan relasi ID biasa.
     */
    function fetchAndSetLevel(currentLevel, parentId, targetValue) {
        return new Promise(function(resolve) {
            var nextLevel = currentLevel + 1;

            if (nextLevel > 5) {
                // Di luar cakupan fungsi ini (D6 ke atas ditangani checkAturanDigit)
                resolve();
                return;
            }

            if (!parentId) {
                autoFillZeroes(nextLevel);
                resolve();
                return;
            }

            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: {
                    level: 'd' + nextLevel,
                    parent_id: parentId,
                    digit_number: nextLevel
                },
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        var html = '<option value="">-- Pilih D' + nextLevel + ' --</option>';
                        $.each(data, function(i, item) {
                            html += `<option value="${item.id}" data-kode="${item.kode}" data-keterangan="${item.keterangan}">${item.kode} - ${item.keterangan}</option>`;
                        });
                        $('#d' + nextLevel + '_id').html(html).prop('disabled', false);

                        if (targetValue) {
                            $('#d' + nextLevel + '_id').val(targetValue);
                        }
                    } else if (targetValue) {
                        $('#d' + nextLevel + '_id').val(targetValue);
                    } else {
                        $('#d' + nextLevel + '_id').html('<option value="" data-kode="00" selected>00</option>').prop('disabled', false);
                    }

                    generateKodeBarangOnly();
                    resolve();
                },
                error: function(xhr) {
                    console.error("Error get_options.php D" + nextLevel + ":", xhr.responseText);
                    if (targetValue) {
                        $('#d' + nextLevel + '_id').val(targetValue);
                    }
                    generateKodeBarangOnly();
                    resolve();
                }
            });
        });
    }

    // Event Manual Change oleh Pengguna (User Mengubah Dropdown)
    $('.select-level').change(function () {
        isManualChange = true;

        var currentLevel = parseInt($(this).attr('data-level'));
        var nextLevel = currentLevel + 1;
        var selectedId = $(this).val();

        if (currentLevel < 5) {
            // Hanya D1-D4 yang perlu reset & fetch rantai berikutnya (sampai D5)
            resetSubDropdowns(nextLevel);
            updateKodeBarang();

            if (selectedId) {
                fetchAndSetLevel(currentLevel, selectedId, null);
            } else {
                autoFillZeroes(nextLevel);
            }
        } else {
            // D5 berubah -> D6-D15 otomatis diisi ulang oleh checkAturanDigit
            // lewat pemanggilan updateKodeBarang() -> generateKodeBarangOnly() di bawah ini.
            // D6-D15 berubah -> cukup update kode barang, tidak perlu fetch apapun.
            updateKodeBarang();
        }
    });

    /**
     * FUNGSI UTAMA AUTO-SELECT SAAT EDIT
     *
     * Tahap 1: D1-D5 -> rantai berjenjang (child bergantung ID parent langsung)
     * Tahap 2: D6-D15 -> HARUS MENUNGGU dropdown-nya selesai diisi oleh checkAturanDigit
     *          (dipanggil lewat generateKodeBarangOnly), baru nilai tersimpan dipasang.
     *          Ini titik yang sebelumnya bikin D6-D15 gagal ter-select: nilai dipasang
     *          SEBELUM dropdown selesai diisi pilihan.
     */
    async function initEditSequence() {
        console.log("Memulai Render Data Edit...", savedValues);
        isManualChange = false;

        if (!savedValues.d1) {
            console.warn("savedValues.d1 kosong/tidak terdeteksi dari PHP!");
            return;
        }

        // ---- TAHAP 1: D1 - D5 (rantai berjenjang, wajib berurutan) ----
        $('#d1_id').val(savedValues.d1);

        for (let i = 1; i <= 4; i++) {
            let currentVal = $('#d' + i + '_id').val();
            let nextTargetVal = savedValues['d' + (i + 1)];

            if (!currentVal) break; // rantai D1-D5 putus, tidak bisa lanjut ke level berikut

            await fetchAndSetLevel(i, currentVal, nextTargetVal);
        }

        // ---- TAHAP 2: D6 - D15 (menunggu checkAturanDigit selesai mengisi dropdown) ----
        await new Promise(function (resolve) {
            generateKodeBarangOnly(function () {
                // Titik ini dijalankan SETELAH dropdown D6-D15 sudah terisi pilihan.
                // Sekarang baru aman memasang nilai tersimpan.
                for (let d = 6; d <= 15; d++) {
                    if (savedValues['d' + d]) {
                        $('#d' + d + '_id').val(savedValues['d' + d]);
                    }
                }

                // Susun ulang kode_barang final dengan D6-D15 yang sudah terpasang
                generateKodeBarangOnly();
                resolve();
            });
        });
    }

    // Jalankan sequence inisialisasi
    setTimeout(function() {
        initEditSequence();
    }, 300);

    <?php include('partial_form_tambah_barang_js_ajaxSimpanOpsi.php'); ?>

});
</script>