<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $kategori_id        = mysqli_real_escape_string($conn, trim($_POST['kategori_id']));
    $kode_sub_kategori  = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan         = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang        = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($kategori_id) && !empty($kode_sub_kategori) && !empty($keterangan)) {

        // 1. Ambil ID relasi di atasnya dan gabungan induk (D1 + D2 + D3)
        $query_kat = "SELECT 
                        kat.kelompok_utama_id,
                        kat.sub_kelompok_utama_id,
                        kat.gabungan AS gabungan_kat
                      FROM kategori kat
                      WHERE kat.id = '$kategori_id' LIMIT 1";
                      
        $res_kat   = mysqli_query($conn, $query_kat);
        $data_kat  = mysqli_fetch_assoc($res_kat);

        if (!$data_kat) {
            echo "<script>alert('Kategori tidak ditemukan!'); window.location.href='sub_kategori.php';</script>";
            exit();
        }

        $kelompok_utama_id     = $data_kat['kelompok_utama_id'];
        $sub_kelompok_utama_id = $data_kat['sub_kelompok_utama_id'];
        $gabungan_kat          = $data_kat['gabungan_kat'];

        // 2. Buat string gabungan lengkap (D1 + D2 + D3 + D4)
        $gabungan = $gabungan_kat . $kode_sub_kategori;

        // 3. Cek keunikan kolom gabungan di database
        $query_check = "SELECT id FROM sub_kategori WHERE gabungan = '$gabungan' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Simpan ke database
        $query_insert = "INSERT INTO sub_kategori (kelompok_utama_id, sub_kelompok_utama_id, kategori_id, kode, gabungan, keterangan, nama_barang) 
                         VALUES ('$kelompok_utama_id', '$sub_kelompok_utama_id', '$kategori_id', '$kode_sub_kategori', '$gabungan', '$keterangan', '$nama_barang')";

        if (mysqli_query($conn, $query_insert)) {
            header("Location: sub_kategori.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        header("Location: sub_kategori.php?status=empty");
        exit();
    }
}
?>