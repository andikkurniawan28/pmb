// 7. AJAX Simpan Opsi Nilai Baru ke Tabel digit6 s/d digit15
$('.btn-add-digit').click(function () {
    var digitNum = $(this).data('digit');
    var inputVal = $('#input_new_d' + digitNum).val().trim();

    // 1. Prioritas Utama: Ambil matched_kode resmi yang terdeteksi dari database
    var d5Val = typeof activeMatchedKode !== 'undefined' ? activeMatchedKode : '';

    // 2. Fallback cerdas: Jika variabel global kosong, rakit kode dari D1 sampai D5 (tanpa paksaan 5 digit)
    if (!d5Val || d5Val === '') {
        var tempKode = '';
        for (var i = 1; i <= 5; i++) {
            var k = $('#d' + i + '_id option:selected').attr('data-kode');
            if (k !== undefined && k !== '' && k !== null) {
                tempKode += String(k);
            }
        }
        // Ambil bagian kode yang bukan angka 0 di belakangnya
        d5Val = tempKode.replace(/0+$/, '');
    }

    console.log("=== [DEBUG] SIMPAN DIGIT BARU ===");
    console.log("Digit Target : D" + digitNum);
    console.log("Input Nilai  :", inputVal);
    console.log("Prefix Kode  :", d5Val);

    // Validasi: Cukup pastikan d5Val ada isinya (minimal 1 digit)
    if (!d5Val || d5Val.trim() === '') {
        alert('Pilih kategori (D1, D2, dst) terlebih dahulu agar aturan digit terdeteksi!');
        return;
    }

    if (!inputVal) {
        alert('Masukkan nama/nilai opsi terlebih dahulu!');
        return;
    }

    var $btn = $(this);
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Simpan');

    $.ajax({
        url: 'simpan_digit_baru.php',
        type: 'POST',
        data: {
            digit_level: digitNum,
            nilai: inputVal,
            d5: d5Val // Mengirimkan matched_kode (misal: "1", "11", atau "111")
        },
        dataType: 'json',
        success: function (res) {
            $btn.prop('disabled', false).html('<i class="fas fa-plus"></i> Simpan');
            console.log("[RECEIVE] Respon PHP:", res);

            if (res && res.success) {
                var $select = $('#d' + digitNum + '_id');
                $select.prop('disabled', false);

                // Tambah option baru & buat terpilih (selected)
                var newOption = new Option(res.kode + ' - ' + res.nilai, res.id, true, true);
                $(newOption).attr('data-kode', res.kode);
                
                $select.append(newOption).val(res.id).trigger('change');
                $('#input_new_d' + digitNum).val('');

                // Refresh 15 digit kode barang
                if (typeof updateKodeBarang === 'function') {
                    updateKodeBarang();
                }
            } else {
                alert('Gagal menyimpan: ' + (res.message || 'Error tidak diketahui.'));
            }
        },
        error: function (xhr, status, error) {
            $btn.prop('disabled', false).html('<i class="fas fa-plus"></i> Simpan');
            console.error("=== Error Detail ===", xhr.responseText);
            alert('Gagal koneksi ke simpan_digit_baru.php! Cek F12 (Console).');
        }
    });
});