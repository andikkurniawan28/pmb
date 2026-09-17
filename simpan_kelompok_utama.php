<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $keterangan = mysqli_real_escape_string($conn, trim($_POST['keterangan']));

    if (!empty($keterangan)) {
        // 1. Ambil kode terakhir dari tabel kelompok_utama
        $query_check = "SELECT kode FROM kelompok_utama WHERE kode IS NOT NULL AND kode != '' ORDER BY id DESC LIMIT 1";
        $result_check = mysqli_query($conn, $query_check);
        $last_row = mysqli_fetch_assoc($result_check);

        // 2. Tentukan kode berikutnya (Urutan: 1-9 lalu A-Z)
        if ($last_row && !empty($last_row['kode'])) {
            $last_kode = strtoupper(trim($last_row['kode']));

            if ($last_kode >= '1' && $last_kode < '9') {
                // Jika 1-8, naikkan ke angka berikutnya
                $next_kode = (string)((int)$last_kode + 1);
            } elseif ($last_kode == '9') {
                // Jika sudah 9, lompat ke huruf A
                $next_kode = 'A';
            } elseif ($last_kode >= 'A' && $last_kode < 'Z') {
                // Jika A-Y, ambil karakter ASCII berikutnya
                $next_kode = chr(ord($last_kode) + 1);
            } else {
                // Jika sudah Z (Batas Maksimal)
                echo "<script>alert('Kode sudah mencapai batas maksimal (Z)!'); window.location.href='kelompok_utama.php';</script>";
                exit();
            }
        } else {
            // Nilai default awal jika tabel masih kosong
            $next_kode = '1';
        }

        // 3. Simpan data baru beserta kodenya
        $query_insert = "INSERT INTO kelompok_utama (kode, keterangan) VALUES ('$next_kode', '$keterangan')";
        
        if (mysqli_query($conn, $query_insert)) {
            header("Location: kelompok_utama.php?status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>