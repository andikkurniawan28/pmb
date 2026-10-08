<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $sub_kelompok_utama_id  = mysqli_real_escape_string($conn, trim($_POST['sub_kelompok_utama_id']));
    $kode_kategori          = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan             = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang            = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($sub_kelompok_utama_id) && !empty($kode_kategori) && !empty($keterangan)) {

        // 1. Ambil kelompok_utama_id dan kode gabungan induk (D1 + D2)
        $query_sub = "SELECT 
                        sub.kelompok_utama_id,
                        sub.gabungan AS gabungan_sub
                      FROM sub_kelompok_utama sub
                      WHERE sub.id = '$sub_kelompok_utama_id' LIMIT 1";
                      
        $res_sub   = mysqli_query($conn, $query_sub);
        $data_sub  = mysqli_fetch_assoc($res_sub);

        if (!$data_sub) {
            echo "<script>alert('Sub Kelompok Utama tidak ditemukan!'); window.location.href='kategori.php';</script>";
            exit();
        }

        $kelompok_utama_id = $data_sub['kelompok_utama_id'];
        $gabungan_sub      = $data_sub['gabungan_sub'];

        // 2. Buat string gabungan lengkap (D1 + D2 + D3)
        $gabungan = $gabungan_sub . $kode_kategori;

        // 3. Cek keunikan kolom gabungan di database
        $query_check = "SELECT id FROM kategori WHERE gabungan = '$gabungan' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Simpan data ke tabel kategori sesuai struktur database
        $query_insert = "INSERT INTO kategori (kelompok_utama_id, sub_kelompok_utama_id, kode, gabungan, keterangan, nama_barang) 
                         VALUES ('$kelompok_utama_id', '$sub_kelompok_utama_id', '$kode_kategori', '$gabungan', '$keterangan', '$nama_barang')";

        if (mysqli_query($conn, $query_insert)) {
            header("Location: kategori.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        header("Location: kategori.php?status=empty");
        exit();
    }
}
?>