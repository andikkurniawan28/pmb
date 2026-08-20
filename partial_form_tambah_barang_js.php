<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // 1. Reset Sub-Dropdown ketika Parent Berubah
    function resetSubDropdowns(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id').html('<option value="">-- Pilih D' + i + ' --</option>').prop('disabled', true);
        }
    }

    // 2. Reset Label D6 - D15 ke Default
    function resetLabels() {
        for (var i = 6; i <= 15; i++) {
            $('#label_d' + i).html('Parameter D' + i).addClass('text-secondary').removeClass('text-primary');
        }
    }

    <?php include('partial_form_tambah_barang_js_checkAturanDigit.php'); ?>

    // 4. Hitung Kode Barang 15-Digit secara Real-Time (Pad 0 jika belum dipilih)
    function updateKodeBarang() {
        var fullCode = '';

        for (var i = 1; i <= 15; i++) {
            var selectedKode = $('#d' + i + '_id option:selected').data('kode');
            
            // Jika opsi dipilih dan memiliki data-kode, gunakan kode tersebut.
            // Jika belum dipilih / kosong / undefined, ganti otomatis dengan '0'.
            if (selectedKode !== undefined && selectedKode !== '' && selectedKode !== null) {
                fullCode += String(selectedKode);
            } else {
                fullCode += '0';
            }
        }

        $('#kode_barang').val(fullCode);
        checkAturanDigit(fullCode);
    }

    // 5. Auto Fill Nol jika Turunan Kosong
    function autoFillZeroes(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id')
                .html('<option value="" data-kode="0" selected>0</option>')
                .prop('disabled', false);
        }
        updateKodeBarang();
    }

    // 6. Event Dynamic Chaining Dropdown D1 s/d D15
    $('.select-level').change(function () {
        var currentLevel = parseInt($(this).attr('data-level'));
        var nextLevel = currentLevel + 1;
        var selectedId = $(this).val();

        resetSubDropdowns(nextLevel);
        updateKodeBarang();

        if (currentLevel < 15) {
            if (selectedId && selectedId !== '0') {
                $.ajax({
                    url: 'get_options.php',
                    type: 'POST',
                    data: {
                        level: 'd' + nextLevel,
                        parent_id: selectedId
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data && data.length > 0) {
                            var html = '<option value="">-- Pilih D' + nextLevel + ' --</option>';
                            $.each(data, function (i, item) {
                                html += '<option value="' + item.id + '" data-kode="' + item.kode + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                            });
                            $('#d' + nextLevel + '_id').html(html).prop('disabled', false);
                        } else {
                            autoFillZeroes(nextLevel);
                        }
                    },
                    error: function (xhr) {
                        console.error("Error get_options.php D" + nextLevel + ":", xhr.responseText);
                    }
                });
            } else if (selectedId === '0') {
                autoFillZeroes(nextLevel);
            }
        }
    });

    <?php include('partial_form_tambah_barang_js_ajaxSimpanOpsi.php'); ?>

});
</script>