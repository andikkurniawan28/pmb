<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $sub_kategori_id = mysqli_real_escape_string($conn, trim($_POST['sub_kategori_id']));
    $kode_tsk        = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan      = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang     = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($sub_kategori_id) && !empty($kode_tsk) && !empty($keterangan)) {

        // 1. Ambil seluruh ID relasi di atasnya dan kode gabungan induk (D1 + D2 + D3 + D4)
        $query_sub_kat = "SELECT 
                            sub_kat.kelompok_utama_id,
                            sub_kat.sub_kelompok_utama_id,
                            sub_kat.kategori_id,
                            sub_kat.gabungan AS gabungan_sub_kat
                          FROM sub_kategori sub_kat
                          WHERE sub_kat.id = '$sub_kategori_id' LIMIT 1";
                          
        $res_sub_kat   = mysqli_query($conn, $query_sub_kat);
        $data_sub_kat  = mysqli_fetch_assoc($res_sub_kat);

        if (!$data_sub_kat) {
            echo "<script>alert('Sub Kategori tidak ditemukan!'); window.location.href='turunan_sub_kategori.php';</script>";
            exit();
        }

        $kelompok_utama_id     = $data_sub_kat['kelompok_utama_id'];
        $sub_kelompok_utama_id = $data_sub_kat['sub_kelompok_utama_id'];
        $kategori_id           = $data_sub_kat['kategori_id'];
        $gabungan_sub_kat      = $data_sub_kat['gabungan_sub_kat'];

        // 2. Buat string gabungan lengkap (D1 + D2 + D3 + D4 + D5)
        $gabungan = $gabungan_sub_kat . $kode_tsk;

        // 3. Cek keunikan kolom gabungan di database
        $query_check = "SELECT id FROM turunan_sub_kategori WHERE gabungan = '$gabungan' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Simpan ke database
        $query_insert = "INSERT INTO turunan_sub_kategori 
                            (kelompok_utama_id, sub_kelompok_utama_id, kategori_id, sub_kategori_id, kode, gabungan, keterangan, nama_barang) 
                         VALUES 
                            ('$kelompok_utama_id', '$sub_kelompok_utama_id', '$kategori_id', '$sub_kategori_id', '$kode_tsk', '$gabungan', '$keterangan', '$nama_barang')";

        if (mysqli_query($conn, $query_insert)) {
            header("Location: turunan_sub_kategori.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        header("Location: turunan_sub_kategori.php?status=empty");
        exit();
    }
}
?>