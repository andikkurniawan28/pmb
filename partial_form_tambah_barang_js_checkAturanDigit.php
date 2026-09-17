// Deklarasi variabel global untuk menyimpan prefix aturan yang cocok (contoh: "11100")
var activeMatchedKode = '';

// 3. Check Aturan Digit & Populate Options D6 - D15
function checkAturanDigit(kodeBarang) {
    var prefix5Digit = kodeBarang.substring(0, 5);

    if (prefix5Digit.length > 0) {
        $.ajax({
            url: 'get_aturan_digit.php',
            type: 'POST',
            data: { 
                kode_5_digit: prefix5Digit 
            },
            dataType: 'json',
            success: function (response) {
                var $container = $('#info_aturan_container');
                var $badge     = $('#badge_status_aturan');
                var $title     = $('#title_status_aturan');
                var $content   = $('#info_aturan_content');

                $container.removeClass('d-none alert-success alert-warning alert-info');

                if (response.found) {
                    // Simpan matched_kode ke variabel global
                    activeMatchedKode = response.matched_kode;

                    $container.addClass('alert-success');
                    $badge.removeClass('badge-warning badge-danger').addClass('badge-success').html('<i class="fas fa-check-circle"></i> DITEMUKAN');
                    $title.text('Label Spesifikasi untuk Kode (' + response.matched_kode + ')');

                    // Validasi teks keterangan agar tidak mencetak JSON mentah {"keterangan":""}
                    var teksKeterangan = response.keterangan || response.nama_kelompok;
                    if (!teksKeterangan || teksKeterangan.trim() === '' || teksKeterangan === '{"keterangan":""}') {
                        teksKeterangan = 'Kategori barang terdaftar (tanpa catatan khusus).';
                    }

                    $content.html('<strong>Deskripsi Label:</strong> ' + teksKeterangan);

                    // Update Label Parameter D6 - D15
                    if (response.raw_data) {
                        for (var i = 6; i <= 15; i++) {
                            var paramName = response.raw_data['param_d' + i];
                            if (paramName && paramName.trim() !== '') {
                                $('#label_d' + i).html(paramName + ' (D' + i + ')').removeClass('text-secondary').addClass('text-primary');
                            } else {
                                $('#label_d' + i).html('Parameter D' + i).addClass('text-secondary').removeClass('text-primary');
                            }
                        }
                    }

                    // Unlock & Populate Options D6 s/d D15
                    for (var i = 6; i <= 15; i++) {
                        var $select = $('#d' + i + '_id');
                        var selectedVal = $select.val(); 
                        var items = (response.options && response.options['d' + i]) ? response.options['d' + i] : [];

                        var currentOptionCount = $select.children('option').length;
                        var needRepopulate = (currentOptionCount <= 1) || ($select.data('loaded-prefix') !== response.matched_kode);

                        if (needRepopulate) {
                            var html = '<option value="">-- Pilih D' + i + ' --</option>';
                            
                            if (items.length > 0) {
                                $.each(items, function (idx, item) {
                                    const ket = item.keterangan || item.nilai;
                                    html += `<option value="${item.id}" data-kode="${item.kode}" data-keterangan="${ket}">${item.kode} - ${item.nilai}</option>`;
                                });
                            } else {
                                html += '<option value="0" data-kode="0" data-keterangan="">0 - (Default / Kosong)</option>';
                            }

                            $select.html(html);
                            $select.data('loaded-prefix', response.matched_kode);
                            
                            if (selectedVal) {
                                $select.val(selectedVal);
                            }
                        }

                        $select.prop('disabled', false);
                    }

                } else {
                    activeMatchedKode = '';
                    $container.addClass('alert-warning');
                    $badge.removeClass('badge-success badge-danger').addClass('badge-warning text-dark').html('<i class="fas fa-exclamation-triangle"></i> TIDAK DITEMUKAN');
                    $title.text('Tidak Ada Label Spesifikasi Terdaftar');
                    $content.html('<span class="text-muted">Kode ini tidak memiliki label spesifikasi di database.</span>');
                    
                    resetLabels();
                }
            },
            error: function () {
                activeMatchedKode = '';
                resetLabels();
            }
        });
    } else {
        activeMatchedKode = '';
        $('#info_aturan_container').addClass('d-none');
        resetLabels();
    }
}