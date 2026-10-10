<?php
include('koneksi.php');

if (isset($_POST['update'])) {
    // Tangkap digit dari form POST secara ketat tanpa nilai default
    $digit = isset($_POST['digit']) ? (int)$_POST['digit'] : 0;

    // Validasi ketat: jika di luar rentang 6-15, hentikan proses dan tolak
    if ($digit < 6 || $digit > 15) {
        echo "<script>alert('Aksi ditolak: Parameter digit tidak valid!'); window.location.href='index.php';</script>";
        exit();
    }

    $table_name = "digit" . $digit;

    $id     = mysqli_real_escape_string($conn, trim($_POST['id']));
    $d5     = mysqli_real_escape_string($conn, trim($_POST['d5']));
    $kode   = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $nilai  = mysqli_real_escape_string($conn, trim($_POST['nilai']));

    if (!empty($id) && !empty($kode) && !empty($nilai)) {
        $query_update = "UPDATE $table_name SET d5 = '$d5', kode = '$kode', nilai = '$nilai' WHERE id = '$id'";
        
        if (mysqli_query($conn, $query_update)) {
            header("Location: digit_handler.php?digit=$digit&status=update_success");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Data tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: digit_handler.php");
    exit();
}
?>