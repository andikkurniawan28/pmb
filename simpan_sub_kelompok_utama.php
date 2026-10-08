<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $kelompok_utama_id = mysqli_real_escape_string($conn, trim($_POST['kelompok_utama_id']));
    $kode_sub          = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $keterangan        = mysqli_real_escape_string($conn, trim($_POST['keterangan']));
    $nama_barang       = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));

    if (!empty($kelompok_utama_id) && !empty($kode_sub) && !empty($keterangan)) {

        // 1. Ambil kode dari tabel kelompok_utama (D1)
        $query_utama = "SELECT kode FROM kelompok_utama WHERE id = '$kelompok_utama_id' LIMIT 1";
        $res_utama   = mysqli_query($conn, $query_utama);
        $data_utama  = mysqli_fetch_assoc($res_utama);

        if (!$data_utama) {
            echo "<script>alert('Kelompok Utama tidak ditemukan!'); window.location.href='sub_kelompok_utama.php';</script>";
            exit();
        }

        $kode_utama = $data_utama['kode'];

        // 2. Buat string gabungan (Kode D1 + Kode D2)
        $gabungan = $kode_utama . $kode_sub;

        // 3. Cek keunikan kolom gabungan di database
        $query_check = "SELECT id FROM sub_kelompok_utama WHERE gabungan = '$gabungan' LIMIT 1";
        $res_check   = mysqli_query($conn, $query_check);

        if (mysqli_num_rows($res_check) > 0) {
            echo "<script>
                    alert('Kode Gabungan [$gabungan] sudah digunakan! Silakan gunakan kode lain.');
                    window.history.back();
                  </script>";
            exit();
        }

        // 4. Simpan ke database jika kode gabungan belum ada
        $query_insert = "INSERT INTO sub_kelompok_utama (kelompok_utama_id, kode, gabungan, keterangan, nama_barang) 
                         VALUES ('$kelompok_utama_id', '$kode_sub', '$gabungan', '$keterangan', '$nama_barang')";

        if (mysqli_query($conn, $query_insert)) {
            header("Location: sub_kelompok_utama.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    } else {
        header("Location: sub_kelompok_utama.php?status=empty");
        exit();
    }
}
?>