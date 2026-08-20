<?php
include('koneksi.php'); // Sesuaikan dengan file koneksi Anda

// Aktifkan exception reporting untuk MySQLi agar try-catch berjalan sempurna
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 1. Fungsi Helper untuk konversi nilai kosong ("" atau 0) ke NULL
function cleanInput($val) {
    if ($val === '' || $val === '0' || $val === 0 || $val === null) {
        return null;
    }
    return (int)$val;
}

// 2. Tangkap Data Utama
$kode_barang             = trim($_POST['kode_barang'] ?? '');
$nama_barang             = trim($_POST['nama_barang'] ?? '');
$deskripsi               = trim($_POST['deskripsi'] ?? '');
$satuan                  = trim($_POST['satuan'] ?? '');
$kode_5_digit            = substr($kode_barang, 0, 5); // Ambil 5 digit pertama

$kelompok_utama_id       = cleanInput($_POST['kelompok_utama_id'] ?? null);
$sub_kelompok_utama_id   = cleanInput($_POST['sub_kelompok_utama_id'] ?? null);
$kategori_id             = cleanInput($_POST['kategori_id'] ?? null);
$sub_kategori_id         = cleanInput($_POST['sub_kategori_id'] ?? null);
$turunan_sub_kategori_id = cleanInput($_POST['turunan_sub_kategori_id'] ?? null);

// 3. Tangkap D6 - D15 (Dipetakan ke digit6_id - digit15_id)
$digit6_id  = cleanInput($_POST['d6_id'] ?? null);
$digit7_id  = cleanInput($_POST['d7_id'] ?? null);
$digit8_id  = cleanInput($_POST['d8_id'] ?? null);
$digit9_id  = cleanInput($_POST['d9_id'] ?? null);
$digit10_id = cleanInput($_POST['d10_id'] ?? null);
$digit11_id = cleanInput($_POST['d11_id'] ?? null);
$digit12_id = cleanInput($_POST['d12_id'] ?? null);
$digit13_id = cleanInput($_POST['d13_id'] ?? null);
$digit14_id = cleanInput($_POST['d14_id'] ?? null);
$digit15_id = cleanInput($_POST['d15_id'] ?? null);

// Validation Sederhana
if (empty($kode_barang) || empty($nama_barang)) {
    echo "<script>
            alert('Gagal: Kode barang dan Nama barang tidak boleh kosong!');
            window.history.back();
          </script>";
    exit();
}

try {
    // 4. Query INSERT
    $sql = "INSERT INTO barang (
        kelompok_utama_id,
        sub_kelompok_utama_id,
        kategori_id,
        sub_kategori_id,
        turunan_sub_kategori_id,
        kode_5_digit,
        kode_barang,
        nama_barang,
        deskripsi,
        satuan,
        digit6_id,
        digit7_id,
        digit8_id,
        digit9_id,
        digit10_id,
        digit11_id,
        digit12_id,
        digit13_id,
        digit14_id,
        digit15_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "iiiiisssssiiiiiiiiii",
            $kelompok_utama_id,
            $sub_kelompok_utama_id,
            $kategori_id,
            $sub_kategori_id,
            $turunan_sub_kategori_id,
            $kode_5_digit,
            $kode_barang,
            $nama_barang,
            $deskripsi,
            $satuan,
            $digit6_id,
            $digit7_id,
            $digit8_id,
            $digit9_id,
            $digit10_id,
            $digit11_id,
            $digit12_id,
            $digit13_id,
            $digit14_id,
            $digit15_id
        );

        // Eksekusi Prepared Statement
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Jika Sukses -> Redirect ke barang.php dengan alert/notif
        header("Location: barang.php?status=success");
        exit();
    }

} catch (mysqli_sql_exception $e) {
    // Tangkap error jika terjadi Duplicate Entry atau constraint violation
    $errorMessage = $e->getMessage();
    
    // Custom penanganan error jika Duplicate Key pada kode_barang
    if ($e->getCode() == 1062) {
        $errorMessage = "Kode Barang '{$kode_barang}' sudah terdaftar dalam sistem! Gunakan kombinasi kode lain.";
    }

    // Ubah string error agar aman dimasukkan ke dalam JavaScript alert (hindari crash karena kutip)
    $safeError = addslashes($errorMessage);

    echo "<script>
            alert('Gagal Menyimpan Data:\\n\\n{$safeError}');
            window.history.back();
          </script>";
    exit();
} catch (Exception $e) {
    $safeError = addslashes($e->getMessage());
    echo "<script>
            alert('Terjadi kesalahan sistem:\\n\\n{$safeError}');
            window.history.back();
          </script>";
    exit();
}
?>