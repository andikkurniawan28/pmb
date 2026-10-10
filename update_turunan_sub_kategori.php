<?php
include('koneksi.php');

if (isset($_POST['update'])) {
    $id               = mysqli_real_escape_string($conn, trim($_POST['id']));
    $sub_kategori_id  = mysqli_real_escape_string($conn, trim($_POST['sub_kategori_id']));
    $kode_tsk         = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan       = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang      = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($id) && !empty($sub_kategori_id) && !empty($kode_tsk) && !empty($keterangan)) {

        // 1. Ambil seluruh ID relasi di atasnya dan gabungan induk sub_kategori (D1 + D2 + D3 + D4)
        $query_sub_kat = "SELECT 
                            sub_kat.kelompok_utama_id,
                            sub_kat.sub_kelompok_utama_id,
                            sub_kat.kategori_id,
                            sub_kat.gabungan AS gabungan_sub_kat
                          FROM sub_kategori sub_kat
                          WHERE sub_kat.id = '$sub_kategori_id' LIMIT 1";
                          
        $res_sub_kat  = mysqli_query($conn, $query_sub_kat);
        $data_sub_kat = mysqli_fetch_assoc($res_sub_kat);

        if (!$data_sub_kat) {
            echo "<script>alert('Sub Kategori tidak ditemukan!'); window.location.href='turunan_sub_kategori.php';</script>";
            exit();
        }

        $kelompok_utama_id     = $data_sub_kat['kelompok_utama_id'];
        $sub_kelompok_utama_id = $data_sub_kat['sub_kelompok_utama_id'];
        $kategori_id           = $data_sub_kat['kategori_id'];
        $gabungan_sub_kat      = $data_sub_kat['gabungan_sub_kat'];

        // 2. Buat string gabungan lengkap baru (D1 + D2 + D3 + D4 + D5)
        $gabungan = $gabungan_sub_kat . $kode_tsk;

        // 3. Cek keunikan kolom gabungan di database (pastikan tidak sama dengan data lain KECUALI miliknya sendiri)
        $query_check = "SELECT id FROM turunan_sub_kategori WHERE gabungan = '$gabungan' AND id != '$id' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan oleh data lain! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Update data ke tabel turunan_sub_kategori
        $query_update = "UPDATE turunan_sub_kategori 
                         SET kelompok_utama_id = '$kelompok_utama_id', 
                             sub_kelompok_utama_id = '$sub_kelompok_utama_id', 
                             kategori_id = '$kategori_id', 
                             sub_kategori_id = '$sub_kategori_id', 
                             kode = '$kode_tsk', 
                             gabungan = '$gabungan', 
                             keterangan = '$keterangan', 
                             nama_barang = '$nama_barang' 
                         WHERE id = '$id'";

        if (mysqli_query($conn, $query_update)) {
            header("Location: turunan_sub_kategori.php?status=update_success");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Data tidak boleh kosong!'); window.history.back();</script>";
    }
} else {
    header("Location: turunan_sub_kategori.php");
    exit();
}
?>