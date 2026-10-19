<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    // ------------------------------------------------------------------
    // STATE
    // ------------------------------------------------------------------
    var isManualChange = false;   // true setelah user mengubah dropdown sendiri
    var isInitializing = false;   // true selama proses auto-select data edit

    // Lebar kode per level: D1-D5 = 1 digit, D6-D15 = 2 digit (total 25 digit)
    // ASUMSI: sesuaikan jika struktur kode Anda berbeda.
    function kodeWidth(level) {
        return level <= 5 ? 1 : 2;
    }

    function zeroKode(level) {
        return '0'.repeat(kodeWidth(level));
    }

    // ------------------------------------------------------------------
    // 1. NILAI TERSIMPAN (D1-D15) DARI PHP
    // ------------------------------------------------------------------
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

    // ------------------------------------------------------------------
    // HELPER
    // ------------------------------------------------------------------
    function resetSubDropdowns(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id')
                .html('<option value="">-- Pilih D' + i + ' --</option>')
                .prop('disabled', true);
        }
    }

    function resetLabels() {
        for (var i = 6; i <= 15; i++) {
            $('#label_d' + i).html('Parameter D' + i).addClass('text-secondary').removeClass('text-primary');
        }
    }

    // Buat <option> dengan aman (tanda kutip di keterangan tidak merusak HTML)
    function makeOption(value, kode, keterangan, text, selected) {
        var $o = $('<option>')
            .val(value)
            .attr('data-kode', kode)
            .attr('data-keterangan', keterangan || '')
            .text(text);
        if (selected) $o.prop('selected', true);
        return $o;
    }

    // Hanya MEMBACA dropdown -> string kode. Tidak ada side effect.
    function buildKode() {
        var fullCode = '';
        for (var i = 1; i <= 15; i++) {
            var kode = $('#d' + i + '_id option:selected').attr('data-kode');
            fullCode += (kode !== undefined && kode !== '' && kode !== null)
                ? String(kode)
                : zeroKode(i);
        }
        return fullCode;
    }

    <?php include('partial_form_tambah_barang_js_checkAturanDigit.php'); ?>

    // ------------------------------------------------------------------
    // 2. GENERATE KODE BARANG (+ pemicu checkAturanDigit)
    //    onDone (opsional): dipanggil setelah D6-D15 selesai diisi.
    // ------------------------------------------------------------------
    function generateKodeBarangOnly(onDone) {
        var fullCode = buildKode();
        $('#kode_barang').val(fullCode);

        // Selama inisialisasi edit, jangan picu checkAturanDigit
        // kecuali dipanggil eksplisit dengan callback (Tahap 2).
        if (isInitializing && typeof onDone !== 'function') {
            return fullCode;
        }

        if (typeof checkAturanDigit === 'function') {
            checkAturanDigit(fullCode, onDone);
        } else if (typeof onDone === 'function') {
            onDone();
        }

        return fullCode;
    }

    // ------------------------------------------------------------------
    // 3. UPDATE NAMA & DESKRIPSI (hanya saat user mengubah manual)
    // ------------------------------------------------------------------
    function updateNamaDanDeskripsi() {
        var namaBarangParts = [];
        var deskripsiParts = [];

        for (var i = 1; i <= 15; i++) {
            var ket = $('#d' + i + '_id option:selected').attr('data-keterangan');
            if (ket !== undefined && ket !== '' && ket !== null) {
                if (i <= 5) namaBarangParts.push(ket);
                else deskripsiParts.push(ket);
            }
        }

        $('#nama_barang').val(namaBarangParts.join(' - '));
        $('#deskripsi').val(deskripsiParts.join(', '));
    }

    function updateKodeBarang() {
        generateKodeBarangOnly();
        if (isManualChange) {
            updateNamaDanDeskripsi();
        }
    }

    function autoFillZeroes(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id')
                .empty()
                .append(makeOption('', zeroKode(i), '', '00', true))
                .prop('disabled', false);
        }
        updateKodeBarang();
    }

    // ------------------------------------------------------------------
    // 4. FETCH SATU LEVEL (hanya rantai D1 -> D5)
    //    D6-D15 diisi oleh checkAturanDigit()
    // ------------------------------------------------------------------
    function fetchAndSetLevel(currentLevel, parentId, targetValue) {
        return new Promise(function (resolve) {
            var nextLevel = currentLevel + 1;
            var $next = $('#d' + nextLevel + '_id');

            if (nextLevel > 5) { resolve(); return; }

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
                success: function (data) {
                    if (data && data.length > 0) {
                        $next.empty().append($('<option>').val('').text('-- Pilih D' + nextLevel + ' --'));
                        $.each(data, function (i, item) {
                            $next.append(makeOption(
                                item.id, item.kode, item.keterangan,
                                item.kode + ' - ' + item.keterangan
                            ));
                        });
                        $next.prop('disabled', false);
                        if (targetValue) $next.val(targetValue);
                    } else if (targetValue) {
                        $next.val(targetValue);
                    } else {
                        $next.empty()
                             .append(makeOption('', zeroKode(nextLevel), '', '00', true))
                             .prop('disabled', false);
                    }

                    generateKodeBarangOnly();   // di-skip otomatis saat isInitializing
                    resolve();
                },
                error: function (xhr) {
                    console.error('Error get_options.php D' + nextLevel + ':', xhr.responseText);
                    if (targetValue) $next.val(targetValue);
                    generateKodeBarangOnly();
                    resolve();
                }
            });
        });
    }

    // ------------------------------------------------------------------
    // 5. EVENT: USER MENGUBAH DROPDOWN
    // ------------------------------------------------------------------
    $('.select-level').change(function () {
        if (isInitializing) return;   // abaikan event dari proses auto-select

        isManualChange = true;

        var currentLevel = parseInt($(this).attr('data-level'), 10);
        var nextLevel = currentLevel + 1;
        var selectedId = $(this).val();

        if (currentLevel < 5) {
            resetSubDropdowns(nextLevel);
            updateKodeBarang();

            if (selectedId) {
                fetchAndSetLevel(currentLevel, selectedId, null);
            } else {
                autoFillZeroes(nextLevel);
            }
        } else {
            // D5 berubah -> checkAturanDigit mengisi ulang D6-D15.
            // D6-D15 berubah -> cukup update kode.
            updateKodeBarang();
        }
    });

    // ------------------------------------------------------------------
    // 6. AUTO-SELECT SAAT EDIT
    // ------------------------------------------------------------------
    async function initEditSequence() {
        console.log('Memulai Render Data Edit...', savedValues);
        isManualChange = false;

        if (!savedValues.d1) {
            console.warn('savedValues.d1 kosong/tidak terdeteksi dari PHP!');
            return;
        }

        isInitializing = true;
        try {
            // TAHAP 1: D1-D5 (berjenjang, wajib berurutan)
            $('#d1_id').val(savedValues.d1);

            for (let i = 1; i <= 4; i++) {
                let currentVal = $('#d' + i + '_id').val();
                if (!currentVal) break;
                await fetchAndSetLevel(i, currentVal, savedValues['d' + (i + 1)]);
            }

            // TAHAP 2: D6-D15, tunggu checkAturanDigit selesai SEKALI saja
            await new Promise(function (resolve) {
                generateKodeBarangOnly(function () {
                    for (let d = 6; d <= 15; d++) {
                        if (savedValues['d' + d]) {
                            $('#d' + d + '_id').val(savedValues['d' + d]);
                        }
                    }

                    // DEBUG (hapus jika sudah beres)
                    for (let d = 6; d <= 15; d++) {
                        var $s = $('#d' + d + '_id');
                        console.log('D' + d,
                            'saved=', savedValues['d' + d],
                            'opsi=', $s.children().length,
                            'terpilih=', $s.val());
                    }

                    // Hanya set kode, JANGAN panggil checkAturanDigit lagi
                    $('#kode_barang').val(buildKode());
                    resolve();
                });
            });
        } finally {
            isInitializing = false;
        }
    }

    setTimeout(initEditSequence, 300);

    <?php include('partial_form_tambah_barang_js_ajaxSimpanOpsi.php'); ?>

});
</script>