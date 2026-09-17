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
     * Selalu berjalan independen agar kode 15 digit selalu terbentuk.
     */
    function generateKodeBarangOnly() {
        var fullCode = '';

        for (var i = 1; i <= 15; i++) {
            var selectedOption = $('#d' + i + '_id option:selected');
            var selectedKode = selectedOption.data('kode');
            
            if (selectedKode !== undefined && selectedKode !== '' && selectedKode !== null) {
                fullCode += String(selectedKode);
            } else {
                fullCode += '0';
            }
        }

        // Set nilai ke input kode_barang
        $('#kode_barang').val(fullCode);

        // Jalankan pengecekan aturan digit untuk D6-D15 secara mandiri
        if (typeof checkAturanDigit === 'function') {
            checkAturanDigit(fullCode);
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
                .html('<option value="" data-kode="0" selected>0</option>')
                .prop('disabled', false);
        }
        updateKodeBarang();
    }

    // Fungsi fetch AJAX berbasis Promise untuk D1 sampai D15
    function fetchAndSetLevel(currentLevel, parentId, targetValue) {
        return new Promise(function(resolve) {
            var nextLevel = currentLevel + 1;

            if (currentLevel >= 15 || !parentId || parentId === '0') {
                if (parentId === '0') autoFillZeroes(nextLevel);
                resolve();
                return;
            }

            var requestParentId = parentId;
            if (nextLevel >= 6) {
                requestParentId = $('#d5_id').val() || savedValues.d5 || parentId;
            }

            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: {
                    level: 'd' + nextLevel,
                    parent_id: requestParentId,
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
                    } else if (targetValue && targetValue !== '0' && targetValue !== '') {
                        $('#d' + nextLevel + '_id').val(targetValue);
                    } else {
                        $('#d' + nextLevel + '_id').html('<option value="" data-kode="0" selected>0</option>').prop('disabled', false);
                    }

                    // Update kode barang & jalankan checkAturanDigit secara mandiri
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
        isManualChange = true; // Tandai bahwa user melakukan aksi manual

        var currentLevel = parseInt($(this).attr('data-level'));
        var nextLevel = currentLevel + 1;
        var selectedId = $(this).val();

        resetSubDropdowns(nextLevel);
        
        // Jalankan fungsi update lengkap (Kode + Nama + Deskripsi)
        updateKodeBarang();

        if (currentLevel < 15 && selectedId && selectedId !== '0') {
            fetchAndSetLevel(currentLevel, selectedId, null);
        } else if (selectedId === '0') {
            autoFillZeroes(nextLevel);
        }
    });

    // 2. Fungsi Utama Auto-Select D1 s/d D15 saat awal muat
    async function initEditSequence() {
        console.log("Memulai Render Data Edit...", savedValues);
        isManualChange = false; // Matikan penimpaan nama_barang/deskripsi saat loading awal

        if (savedValues.d1) {
            // Set D1
            $('#d1_id').val(savedValues.d1);
            generateKodeBarangOnly();

            // Loop hirarki D1 sampai D14
            for (let i = 1; i < 15; i++) {
                let currentVal = $('#d' + i + '_id').val();
                let nextTargetVal = savedValues['d' + (i + 1)];

                if (currentVal && currentVal !== '0') {
                    await fetchAndSetLevel(i, currentVal, nextTargetVal);
                } else if (nextTargetVal && nextTargetVal !== '0') {
                    await fetchAndSetLevel(i, savedValues['d' + i], nextTargetVal);
                } else {
                    break;
                }
            }

            // Restore nilai D6-D15 jika opsi sudah dirender
            for (let d = 6; d <= 15; d++) {
                if (savedValues['d' + d]) {
                    $('#d' + d + '_id').val(savedValues['d' + d]);
                }
            }

            // Panggilan akhir untuk memastikan kode terbentuk utuh & D6-D15 tampil
            generateKodeBarangOnly();
        } else {
            console.warn("savedValues.d1 kosong/tidak terdeteksi dari PHP!");
        }
    }

    // Jalankan sequence inisialisasi
    setTimeout(function() {
        initEditSequence();
    }, 300);

    <?php include('partial_form_tambah_barang_js_ajaxSimpanOpsi.php'); ?>

});
</script>