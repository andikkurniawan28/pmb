<?php include('header.php'); ?>

<?php
// Proses Form Submit
if (isset($_POST['submit'])) {
    $kelompok_utama_id      = !empty($_POST['kelompok_utama_id']) ? mysqli_real_escape_string($conn, $_POST['kelompok_utama_id']) : NULL;
    $sub_kelompok_utama_id  = !empty($_POST['sub_kelompok_utama_id']) ? mysqli_real_escape_string($conn, $_POST['sub_kelompok_utama_id']) : NULL;
    $kategori_id            = !empty($_POST['kategori_id']) ? mysqli_real_escape_string($conn, $_POST['kategori_id']) : NULL;
    $sub_kategori_id        = !empty($_POST['sub_kategori_id']) ? mysqli_real_escape_string($conn, $_POST['sub_kategori_id']) : NULL;
    $turunan_sub_kategori_id= !empty($_POST['turunan_sub_kategori_id']) ? mysqli_real_escape_string($conn, $_POST['turunan_sub_kategori_id']) : NULL;
    
    $kode_5_digit           = mysqli_real_escape_string($conn, $_POST['kode_5_digit']);
    $nama_barang            = mysqli_real_escape_string($conn, $_POST['nama_barang']);

    // Penanganan NULL untuk query SQL jika kolom FK memperbolehkan NULL, jika NOT NULL pastikan menggunakan ID default / penanganan khusus
    $val_d1 = $kelompok_utama_id ? "'$kelompok_utama_id'" : "NULL";
    $val_d2 = $sub_kelompok_utama_id ? "'$sub_kelompok_utama_id'" : "NULL";
    $val_d3 = $kategori_id ? "'$kategori_id'" : "NULL";
    $val_d4 = $sub_kategori_id ? "'$sub_kategori_id'" : "NULL";
    $val_d5 = $turunan_sub_kategori_id ? "'$turunan_sub_kategori_id'" : "NULL";

    $query_insert = "INSERT INTO barang (
                        kelompok_utama_id, 
                        sub_kelompok_utama_id, 
                        kategori_id, 
                        sub_kategori_id, 
                        turunan_sub_kategori_id, 
                        kode_5_digit, 
                        nama_barang
                    ) VALUES (
                        $val_d1, 
                        $val_d2, 
                        $val_d3, 
                        $val_d4, 
                        $val_d5, 
                        '$kode_5_digit', 
                        '$nama_barang'
                    )";

    if (mysqli_query($conn, $query_insert)) {
        echo "<script>alert('Data barang berhasil ditambahkan!'); window.location='barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil Data Kelompok Utama (D1)
$query_d1 = "SELECT * FROM kelompok_utama ORDER BY kode ASC";
$result_d1 = mysqli_query($conn, $query_d1);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Barang</h6>
        </div>
        <div class="card-body">
            <form action="simpan_barang.php" method="POST">
                
                <!-- Select D1 -->
                <div class="form-group">
                    <label for="kelompok_utama_id">Kelompok Utama (D1) <span class="text-danger">*</span></label>
                    <select class="form-control" name="kelompok_utama_id" id="kelompok_utama_id" required>
                        <option value="">-- Pilih Kelompok Utama (D1) --</option>
                        <?php while ($d1 = mysqli_fetch_assoc($result_d1)) : ?>
                            <option value="<?= $d1['id']; ?>" data-kode="<?= $d1['kode']; ?>">
                                <?= $d1['kode']; ?> - <?= isset($d1['keterangan']) ? $d1['keterangan'] : 'Kelompok Utama'; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Select D2 -->
                <div class="form-group">
                    <label for="sub_kelompok_utama_id">Sub Kelompok Utama (D2)</label>
                    <select class="form-control" name="sub_kelompok_utama_id" id="sub_kelompok_utama_id" disabled>
                        <option value="">-- Pilih Sub Kelompok Utama (D2) --</option>
                    </select>
                </div>

                <!-- Select D3 -->
                <div class="form-group">
                    <label for="kategori_id">Kategori (D3)</label>
                    <select class="form-control" name="kategori_id" id="kategori_id" disabled>
                        <option value="">-- Pilih Kategori (D3) --</option>
                    </select>
                </div>

                <!-- Select D4 -->
                <div class="form-group">
                    <label for="sub_kategori_id">Sub Kategori (D4)</label>
                    <select class="form-control" name="sub_kategori_id" id="sub_kategori_id" disabled>
                        <option value="">-- Pilih Sub Kategori (D4) --</option>
                    </select>
                </div>

                <!-- Select D5 -->
                <div class="form-group">
                    <label for="turunan_sub_kategori_id">Turunan Sub Kategori (D5)</label>
                    <select class="form-control" name="turunan_sub_kategori_id" id="turunan_sub_kategori_id" disabled>
                        <option value="">-- Pilih Turunan Sub Kategori (D5) --</option>
                    </select>
                </div>

                <!-- Kode 5 Digit -->
                <div class="form-group">
                    <label for="kode_5_digit">Kode 5 Digit</label>
                    <input type="text" class="form-control" name="kode_5_digit" id="kode_5_digit" readonly required placeholder="Otomatis terisi dari D1-D5">
                </div>

                <!-- Nama Barang -->
                <div class="form-group">
                    <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="nama_barang" id="nama_barang" required placeholder="Masukkan Nama Barang">
                </div>

                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Barang</button>
                <a href="barang.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

</div>

<!-- JavaScript Dropdown Berantai dengan Auto-Zero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    function resetDropdown(elementId, placeholder) {
        $(elementId).html('<option value="">' + placeholder + '</option>').prop('disabled', true);
    }

    function updateKode5Digit() {
        var d1 = $('#kelompok_utama_id option:selected').data('kode') !== undefined ? $('#kelompok_utama_id option:selected').data('kode') : '';
        var d2 = $('#sub_kelompok_utama_id option:selected').data('kode') !== undefined ? $('#sub_kelompok_utama_id option:selected').data('kode') : '';
        var d3 = $('#kategori_id option:selected').data('kode') !== undefined ? $('#kategori_id option:selected').data('kode') : '';
        var d4 = $('#sub_kategori_id option:selected').data('kode') !== undefined ? $('#sub_kategori_id option:selected').data('kode') : '';
        var d5 = $('#turunan_sub_kategori_id option:selected').data('kode') !== undefined ? $('#turunan_sub_kategori_id option:selected').data('kode') : '';

        // Konversi ke string untuk menangani nilai integer 0
        d1 = String(d1);
        d2 = String(d2);
        d3 = String(d3);
        d4 = String(d4);
        d5 = String(d5);

        if (d1 !== '' && d2 !== '' && d3 !== '' && d4 !== '' && d5 !== '') {
            $('#kode_5_digit').val(d1 + d2 + d3 + d4 + d5);
        } else {
            $('#kode_5_digit').val('');
        }
    }

    // Fungsi rekursif/berantai untuk mengisi angka 0 jika child tidak ditemukan
    function autoFillZeroes(fromLevel) {
        var levels = ['d2', 'd3', 'd4', 'd5'];
        var selectIds = {
            'd2': '#sub_kelompok_utama_id',
            'd3': '#kategori_id',
            'd4': '#sub_kategori_id',
            'd5': '#turunan_sub_kategori_id'
        };

        var startIndex = levels.indexOf(fromLevel);
        if (startIndex !== -1) {
            for (var i = startIndex; i < levels.length; i++) {
                var targetId = selectIds[levels[i]];
                $(targetId).html('<option value="" data-kode="0">0 - (Tidak Ada / Default)</option>').prop('disabled', false);
                $(targetId).val('');
            }
        }
        updateKode5Digit();
    }

    // D1 -> Load D2
    $('#kelompok_utama_id').change(function() {
        var id = $(this).val();
        resetDropdown('#sub_kelompok_utama_id', '-- Pilih Sub Kelompok Utama (D2) --');
        resetDropdown('#kategori_id', '-- Pilih Kategori (D3) --');
        resetDropdown('#sub_kategori_id', '-- Pilih Sub Kategori (D4) --');
        resetDropdown('#turunan_sub_kategori_id', '-- Pilih Turunan Sub Kategori (D5) --');
        updateKode5Digit();

        if (id) {
            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: { level: 'd2', parent_id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        var html = '<option value="">-- Pilih Sub Kelompok Utama (D2) --</option>';
                        $.each(data, function(i, item) {
                            html += '<option value="' + item.id + '" data-kode="' + item.kode + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                        });
                        $('#sub_kelompok_utama_id').html(html).prop('disabled', false);
                    } else {
                        // Tidak punya child, otomatis set 0 ke D2 hingga D5
                        autoFillZeroes('d2');
                    }
                }
            });
        }
    });

    // D2 -> Load D3
    $('#sub_kelompok_utama_id').change(function() {
        var id = $(this).val();
        resetDropdown('#kategori_id', '-- Pilih Kategori (D3) --');
        resetDropdown('#sub_kategori_id', '-- Pilih Sub Kategori (D4) --');
        resetDropdown('#turunan_sub_kategori_id', '-- Pilih Turunan Sub Kategori (D5) --');
        updateKode5Digit();

        if (id) {
            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: { level: 'd3', parent_id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        var html = '<option value="">-- Pilih Kategori (D3) --</option>';
                        $.each(data, function(i, item) {
                            html += '<option value="' + item.id + '" data-kode="' + item.kode + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                        });
                        $('#kategori_id').html(html).prop('disabled', false);
                    } else {
                        autoFillZeroes('d3');
                    }
                }
            });
        } else if ($('#sub_kelompok_utama_id option:selected').data('kode') == 0) {
            autoFillZeroes('d3');
        }
    });

    // D3 -> Load D4
    $('#kategori_id').change(function() {
        var id = $(this).val();
        resetDropdown('#sub_kategori_id', '-- Pilih Sub Kategori (D4) --');
        resetDropdown('#turunan_sub_kategori_id', '-- Pilih Turunan Sub Kategori (D5) --');
        updateKode5Digit();

        if (id) {
            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: { level: 'd4', parent_id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        var html = '<option value="">-- Pilih Sub Kategori (D4) --</option>';
                        $.each(data, function(i, item) {
                            html += '<option value="' + item.id + '" data-kode="' + item.kode + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                        });
                        $('#sub_kategori_id').html(html).prop('disabled', false);
                    } else {
                        autoFillZeroes('d4');
                    }
                }
            });
        } else if ($('#kategori_id option:selected').data('kode') == 0) {
            autoFillZeroes('d4');
        }
    });

    // D4 -> Load D5
    $('#sub_kategori_id').change(function() {
        var id = $(this).val();
        resetDropdown('#turunan_sub_kategori_id', '-- Pilih Turunan Sub Kategori (D5) --');
        updateKode5Digit();

        if (id) {
            $.ajax({
                url: 'get_options.php',
                type: 'POST',
                data: { level: 'd5', parent_id: id },
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        var html = '<option value="">-- Pilih Turunan Sub Kategori (D5) --</option>';
                        $.each(data, function(i, item) {
                            html += '<option value="' + item.id + '" data-kode="' + item.kode + '" data-keterangan="' + item.keterangan + '">' + item.kode + ' - ' + item.keterangan + '</option>';
                        });
                        $('#turunan_sub_kategori_id').html(html).prop('disabled', false);
                    } else {
                        autoFillZeroes('d5');
                    }
                }
            });
        } else if ($('#sub_kategori_id option:selected').data('kode') == 0) {
            autoFillZeroes('d5');
        }
    });

    // D5 -> Update Kode 5 Digit
    $('#turunan_sub_kategori_id').change(function() {
        updateKode5Digit();
        // var ket = $('#turunan_sub_kategori_id option:selected').data('keterangan');
        // if (ket && $('#nama_barang').val() === '') {
        //     $('#nama_barang').val(ket);
        // }
    });

});
</script>

<?php include('footer.php'); ?>