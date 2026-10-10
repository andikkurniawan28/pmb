<?php
include('koneksi.php');

if (isset($_POST['update'])) {
    $id                 = mysqli_real_escape_string($conn, trim($_POST['id']));
    $kategori_id        = mysqli_real_escape_string($conn, trim($_POST['kategori_id']));
    $kode_sub_kategori  = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan         = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang        = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($id) && !empty($kategori_id) && !empty($kode_sub_kategori) && !empty($keterangan)) {

        // 1. Ambil seluruh relasi ID di atasnya dan gabungan induk kategori (D1 + D2 + D3)
        $query_kat = "SELECT 
                        kat.kelompok_utama_id,
                        kat.sub_kelompok_utama_id,
                        kat.gabungan AS gabungan_kat
                      FROM kategori kat
                      WHERE kat.id = '$kategori_id' LIMIT 1";
                      
        $res_kat  = mysqli_query($conn, $query_kat);
        $data_kat = mysqli_fetch_assoc($res_kat);

        if (!$data_kat) {
            echo "<script>alert('Kategori tidak ditemukan!'); window.location.href='sub_kategori.php';</script>";
            exit();
        }

        $kelompok_utama_id     = $data_kat['kelompok_utama_id'];
        $sub_kelompok_utama_id = $data_kat['sub_kelompok_utama_id'];
        $gabungan_kat          = $data_kat['gabungan_kat'];

        // 2. Buat string gabungan lengkap baru (D1 + D2 + D3 + D4)
        $gabungan = $gabungan_kat . $kode_sub_kategori;

        // 3. Cek keunikan kolom gabungan di database (pastikan tidak sama dengan data lain KECUALI miliknya sendiri)
        $query_check = "SELECT id FROM sub_kategori WHERE gabungan = '$gabungan' AND id != '$id' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan oleh data lain! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Update data ke tabel sub_kategori
        $query_update = "UPDATE sub_kategori 
                         SET kelompok_utama_id = '$kelompok_utama_id', 
                             sub_kelompok_utama_id = '$sub_kelompok_utama_id', 
                             kategori_id = '$kategori_id', 
                             kode = '$kode_sub_kategori', 
                             gabungan = '$gabungan', 
                             keterangan = '$keterangan', 
                             nama_barang = '$nama_barang' 
                         WHERE id = '$id'";

        if (mysqli_query($conn, $query_update)) {
            header("Location: sub_kategori.php?status=update_success");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Data tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: sub_kategori.php");
    exit();
}
?>