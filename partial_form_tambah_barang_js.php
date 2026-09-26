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

    function updateKodeBarang() {
        var fullCode = '';
        var namaBarangParts = [];
        var deskripsiParts = [];

        for (var i = 1; i <= 15; i++) {
            var selectedOption = $('#d' + i + '_id option:selected');
            var selectedKode = selectedOption.data('kode');
            var selectedKeterangan = selectedOption.data('keterangan');
            
            // 1. Olah Kode Barang (15 Digit)
            if (selectedKode !== undefined && selectedKode !== '' && selectedKode !== null) {
                fullCode += String(selectedKode);
            } else {
                fullCode += '00';
            }

            // 2. Olah Keterangan
            if (selectedKeterangan !== undefined && selectedKeterangan !== '' && selectedKeterangan !== null) {
                if (i <= 5) {
                    // Digit 1 - 5 masuk ke Nama Barang
                    namaBarangParts.push(selectedKeterangan);
                } else {
                    // Digit 6 - 15 masuk ke Deskripsi
                    deskripsiParts.push(selectedKeterangan);
                }
            }
        }

        // Format masing-masing teks dengan separator yang ditentukan
        var fullNamaBarang = namaBarangParts.join(' - ');
        var fullDeskripsi = deskripsiParts.join(', ');

        // Set nilai ke input/textarea masing-masing
        $('#kode_barang').val(fullCode);
        $('#nama_barang').val(fullNamaBarang);
        $('#deskripsi').val(fullDeskripsi);

        checkAturanDigit(fullCode);
    }

    // 5. Auto Fill Nol jika Turunan Kosong
    function autoFillZeroes(fromLevel) {
        for (var i = fromLevel; i <= 15; i++) {
            $('#d' + i + '_id')
                .html('<option value="" data-kode="00" selected>00</option>')
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
            if (selectedId && selectedId !== '00') {
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
                                // html += '<option value="' + item.id + '" data-kode="' + item.kode + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                                html += `<option value="${item.id}" data-kode="${item.kode}" data-keterangan="${item.keterangan}">${item.kode} - ${item.keterangan}</option>`;
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
            } else if (selectedId === '00') {
                autoFillZeroes(nextLevel);
            }
        }
    });

    <?php include('partial_form_tambah_barang_js_ajaxSimpanOpsi.php'); ?>

});
</script>