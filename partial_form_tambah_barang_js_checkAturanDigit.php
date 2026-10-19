// File ini di-include DI DALAM $(document).ready(...), jadi bisa memakai
// savedValues, isInitializing, resetLabels, dan makeOption dari file utama.

// Prefix aturan yang cocok (contoh: "11100")
var activeMatchedKode = '';

// Penanda request terbaru. Respons dari request yang sudah digantikan diabaikan.
var checkSeq = 0;

// Cek aturan digit & isi dropdown D6-D15.
// onDone (opsional): dipanggil SETELAH dropdown selesai diisi
// (ketemu aturan, tidak ketemu, error, maupun respons basi).
function checkAturanDigit(kodeBarang, onDone) {
    var prefix5Digit = kodeBarang.substring(0, 5);
    var mySeq = ++checkSeq;

    function finish() {
        if (typeof onDone === 'function') onDone();
    }

    if (prefix5Digit.length === 0) {
        activeMatchedKode = '';
        $('#info_aturan_container').addClass('d-none');
        resetLabels();
        finish();
        return;
    }

    $.ajax({
        url: 'get_aturan_digit.php',
        type: 'POST',
        data: { kode_5_digit: prefix5Digit },
        dataType: 'json',
        success: function (response) {

            // Respons basi: jangan sentuh DOM, tapi tetap lepaskan penunggu.
            if (mySeq !== checkSeq) {
                finish();
                return;
            }

            var $container = $('#info_aturan_container');
            var $badge     = $('#badge_status_aturan');
            var $title     = $('#title_status_aturan');
            var $content   = $('#info_aturan_content');

            $container.removeClass('d-none alert-success alert-warning alert-info');

            if (response.found) {
                activeMatchedKode = response.matched_kode;

                $container.addClass('alert-success');
                $badge.removeClass('badge-warning badge-danger')
                      .addClass('badge-success')
                      .html('<i class="fas fa-check-circle"></i> DITEMUKAN');
                $title.text('Label Spesifikasi untuk Kode (' + response.matched_kode + ')');

                // Hindari mencetak JSON mentah {"keterangan":""}
                var teksKeterangan = response.keterangan || response.nama_kelompok;
                if (!teksKeterangan || teksKeterangan.trim() === '' || teksKeterangan === '{"keterangan":""}') {
                    teksKeterangan = 'Kategori barang terdaftar (tanpa catatan khusus).';
                }
                $content.html('<strong>Deskripsi Label:</strong> ').append($('<span>').text(teksKeterangan));

                // Label parameter D6-D15
                if (response.raw_data) {
                    for (var l = 6; l <= 15; l++) {
                        var paramName = response.raw_data['param_d' + l];
                        if (paramName && paramName.trim() !== '') {
                            $('#label_d' + l).text(paramName + ' (D' + l + ')')
                                             .removeClass('text-secondary').addClass('text-primary');
                        } else {
                            $('#label_d' + l).text('Parameter D' + l)
                                             .addClass('text-secondary').removeClass('text-primary');
                        }
                    }
                }

                // Unlock & isi opsi D6-D15
                for (var i = 6; i <= 15; i++) {
                    var $select = $('#d' + i + '_id');
                    var saved   = (typeof savedValues !== 'undefined') ? savedValues['d' + i] : '';

                    // Pilihan yang harus dipertahankan:
                    // pilihan saat ini; kalau kosong dan sedang inisialisasi edit -> nilai tersimpan
                    var selectedVal = $select.val() || (isInitializing ? saved : '');

                    var items = (response.options && response.options['d' + i]) ? response.options['d' + i] : [];

                    var currentOptionCount = $select.children('option').length;
                    var needRepopulate = (currentOptionCount <= 1) ||
                                         ($select.data('loaded-prefix') !== response.matched_kode);

                    if (needRepopulate) {
                        $select.empty().append($('<option>').val('').text('-- Pilih D' + i + ' --'));

                        if (items.length > 0) {
                            $.each(items, function (idx, item) {
                                var ket = item.keterangan || item.nilai;
                                $select.append(makeOption(
                                    item.id, item.kode, ket,
                                    item.kode + ' - ' + item.nilai
                                ));
                            });
                        } else {
                            $select.append(makeOption('0', '00', '', '00 - (Default / Kosong)'));
                        }

                        $select.data('loaded-prefix', response.matched_kode);
                        if (selectedVal) $select.val(selectedVal);

                    } else if (isInitializing && saved) {
                        // Tidak dibangun ulang, tapi pastikan nilai tersimpan terpasang
                        $select.val(saved);
                    }

                    $select.prop('disabled', false);
                }

            } else {
                activeMatchedKode = '';
                $container.addClass('alert-warning');
                $badge.removeClass('badge-success badge-danger')
                      .addClass('badge-warning text-dark')
                      .html('<i class="fas fa-exclamation-triangle"></i> TIDAK DITEMUKAN');
                $title.text('Tidak Ada Label Spesifikasi Terdaftar');
                $content.html('<span class="text-muted">Kode ini tidak memiliki label spesifikasi di database.</span>');
                resetLabels();
            }

            finish();
        },
        error: function () {
            if (mySeq === checkSeq) {
                activeMatchedKode = '';
                resetLabels();
            }
            // Tetap panggil onDone supaya proses yang menunggu tidak macet
            finish();
        }
    });
}