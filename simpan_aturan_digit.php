<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $kode_kategori       = mysqli_real_escape_string($conn, trim($_POST['kode_kategori']));
    $nama_kelompok_excel = mysqli_real_escape_string($conn, trim($_POST['nama_kelompok_excel']));

    // Validasi panjang kode minimal 3 digit dan maksimal 5 digit
    $length = strlen($kode_kategori);
    if ($length < 3 || $length > 5) {
        echo "<script>
                alert('Kode Kategori harus diisi antara 3 hingga 5 digit!');
                window.history.back();
              </script>";
        exit();
    }

    $param_d6  = !empty($_POST['param_d6'])  ? mysqli_real_escape_string($conn, trim($_POST['param_d6']))  : NULL;
    $param_d7  = !empty($_POST['param_d7'])  ? mysqli_real_escape_string($conn, trim($_POST['param_d7']))  : NULL;
    $param_d8  = !empty($_POST['param_d8'])  ? mysqli_real_escape_string($conn, trim($_POST['param_d8']))  : NULL;
    $param_d9  = !empty($_POST['param_d9'])  ? mysqli_real_escape_string($conn, trim($_POST['param_d9']))  : NULL;
    $param_d10 = !empty($_POST['param_d10']) ? mysqli_real_escape_string($conn, trim($_POST['param_d10'])) : NULL;
    $param_d11 = !empty($_POST['param_d11']) ? mysqli_real_escape_string($conn, trim($_POST['param_d11'])) : NULL;
    $param_d12 = !empty($_POST['param_d12']) ? mysqli_real_escape_string($conn, trim($_POST['param_d12'])) : NULL;
    $param_d13 = !empty($_POST['param_d13']) ? mysqli_real_escape_string($conn, trim($_POST['param_d13'])) : NULL;
    $param_d14 = !empty($_POST['param_d14']) ? mysqli_real_escape_string($conn, trim($_POST['param_d14'])) : NULL;
    $param_d15 = !empty($_POST['param_d15']) ? mysqli_real_escape_string($conn, trim($_POST['param_d15'])) : NULL;

    if (!empty($kode_kategori) && !empty($nama_kelompok_excel)) {

        // Cek keunikan kode_kategori
        $query_check = "SELECT id FROM aturan_digit WHERE kode_kategori = '$kode_kategori' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Aturan Digit untuk Kode Kategori [$kode_kategori] sudah ada!');
                    window.history.back();
                  </script>";
            exit();
        }

        // Simpan ke database
        $query_insert = "INSERT INTO aturan_digit 
                            (kode_kategori, nama_kelompok_excel, param_d6, param_d7, param_d8, param_d9, param_d10, param_d11, param_d12, param_d13, param_d14, param_d15) 
                         VALUES 
                            ('$kode_kategori', '$nama_kelompok_excel', 
                             " . ($param_d6 ? "'$param_d6'" : "NULL") . ", 
                             " . ($param_d7 ? "'$param_d7'" : "NULL") . ", 
                             " . ($param_d8 ? "'$param_d8'" : "NULL") . ", 
                             " . ($param_d9 ? "'$param_d9'" : "NULL") . ", 
                             " . ($param_d10 ? "'$param_d10'" : "NULL") . ", 
                             " . ($param_d11 ? "'$param_d11'" : "NULL") . ", 
                             " . ($param_d12 ? "'$param_d12'" : "NULL") . ", 
                             " . ($param_d13 ? "'$param_d13'" : "NULL") . ", 
                             " . ($param_d14 ? "'$param_d14'" : "NULL") . ", 
                             " . ($param_d15 ? "'$param_d15'" : "NULL") . ")";

        if (mysqli_query($conn, $query_insert)) {
            header("Location: aturan_digit.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        header("Location: aturan_digit.php?status=empty");
        exit();
    }
}
?>