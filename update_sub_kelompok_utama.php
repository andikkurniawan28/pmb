<?php
include('koneksi.php');

if (isset($_POST['update'])) {
    $id                 = mysqli_real_escape_string($conn, trim($_POST['id']));
    $kelompok_utama_id  = mysqli_real_escape_string($conn, trim($_POST['kelompok_utama_id']));
    $kode_sub           = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan         = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang        = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($id) && !empty($kelompok_utama_id) && !empty($kode_sub) && !empty($keterangan)) {

        // 1. Ambil kode dari tabel kelompok_utama (D1)
        $query_utama = "SELECT kode FROM kelompok_utama WHERE id = '$kelompok_utama_id' LIMIT 1";
        $res_utama   = mysqli_query($conn, $query_utama);
        $data_utama  = mysqli_fetch_assoc($res_utama);

        if (!$data_utama) {
            echo "<script>alert('Kelompok Utama tidak ditemukan!'); window.location.href='sub_kelompok_utama.php';</script>";
            exit();
        }

        $kode_utama = $data_utama['kode'];

        // 2. Buat string gabungan baru (Kode D1 + Kode D2)
        $gabungan = $kode_utama . $kode_sub;

        // 3. Cek keunikan gabungan (pastikan gabungan tidak sama dengan data lain KECUALI miliknya sendiri)
        $query_check = "SELECT id FROM sub_kelompok_utama WHERE gabungan = '$gabungan' AND id != '$id' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan oleh data lain! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Update ke database
        $query_update = "UPDATE sub_kelompok_utama 
                         SET kelompok_utama_id = '$kelompok_utama_id', 
                             kode = '$kode_sub', 
                             gabungan = '$gabungan', 
                             keterangan = '$keterangan', 
                             nama_barang = '$nama_barang' 
                         WHERE id = '$id'";

        if (mysqli_query($conn, $query_update)) {
            header("Location: sub_kelompok_utama.php?status=update_success");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Data tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: sub_kelompok_utama.php");
    exit();
}
?>