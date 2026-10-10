<?php
include('koneksi.php');

// 1. Tentukan digit aktif dari URL (default ke 6 jika tidak ada/invalid), batasi hanya angka 6 sampai 15
$digit = isset($_GET['digit']) ? (int)$_GET['digit'] : 0;

// Validasi apakah digit berada di rentang 6 sampai 15
if ($digit < 6 || $digit > 15) {
    echo "<script>alert('Parameter digit tidak valid!'); window.location.href='index.php';</script>";
    exit();
}

// Nama tabel langsung dibuat dinamis sesuai nilai digit yang aktif
$table_name = "digit" . $digit;

// 2. Tangkap aksi POST untuk SIMPAN (Tambah Data Baru)
if (isset($_POST['simpan'])) {
    $d5     = mysqli_real_escape_string($conn, trim($_POST['d5']));
    $kode   = mysqli_real_escape_string($conn, trim($_POST['kode']));
    $nilai  = mysqli_real_escape_string($conn, trim($_POST['nilai']));

    if (!empty($kode) && !empty($nilai)) {
        $query_insert = "INSERT INTO $table_name (d5, kode, nilai) VALUES ('$d5', '$kode', '$nilai')";
        if (mysqli_query($conn, $query_insert)) {
            header("Location: digit_handler.php?digit=$digit&status=success");
            exit();
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

// 3. Tangkap aksi POST untuk UPDATE (Ubah Data)
if (isset($_POST['update'])) {
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
    }
}

// 4. Tangkap aksi GET untuk HAPUS Data
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, trim($_GET['id']));
    $query_delete = "DELETE FROM $table_name WHERE id = '$id'";
    if (mysqli_query($conn, $query_delete)) {
        header("Location: digit_handler.php?digit=$digit&status=delete_success");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
}

// 5. Cek apakah sedang dalam mode EDIT
$is_edit = false;
$edit_data = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $is_edit = true;
    $id_edit = mysqli_real_escape_string($conn, trim($_GET['id']));
    $q_edit = mysqli_query($conn, "SELECT * FROM $table_name WHERE id = '$id_edit'");
    $edit_data = mysqli_fetch_assoc($q_edit);
}

// 6. Ambil data untuk ditampilkan ke Tabel (Index)
$query_select = "SELECT * FROM $table_name ORDER BY id ASC";
$result = mysqli_query($conn, $query_select);
?>

<?php include('header.php'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <?php if ($is_edit): ?>
        <!-- FORM EDIT DATA (Muncul jika parameter ?action=edit&id=...) -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Digit <?= $digit; ?></h6>
            </div>
            <div class="card-body">
                <form action="digit_handler.php?digit=<?= $digit; ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $edit_data['id']; ?>">
                    <div class="form-group">
                        <label class="font-weight-bold">D5</label>
                        <input type="text" class="form-control" name="d5" value="<?= htmlspecialchars($edit_data['d5']); ?>" placeholder="Masukkan nilai D5...">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Kode</label>
                        <input type="text" class="form-control" name="kode" value="<?= htmlspecialchars($edit_data['kode']); ?>" placeholder="Masukkan kode..." required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nilai</label>
                        <textarea class="form-control" name="nilai" rows="3" placeholder="Masukkan nilai..." required><?= htmlspecialchars($edit_data['nilai']); ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-success"><i class="fas fa-save mr-1"></i> Update Perubahan</button>
                    <a href="digit_handler.php?digit=<?= $digit; ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    <?php else: ?>
        <!-- TABEL INDEX & TOMBOL TAMBAH -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Data Digit <?= $digit; ?> (Tabel: digit<?= $digit; ?>)</h6>
                <!-- Tombol Pemicu Modal Tambah -->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahDigit">
                    <i class="fas fa-plus mr-1"></i> Tambah Data
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>D5</th>
                                <th>Kode</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['d5']); ?></td>
                                    <td><?= htmlspecialchars($row['kode']); ?></td>
                                    <td><?= htmlspecialchars($row['nilai']); ?></td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="digit_handler.php?digit=<?= $digit; ?>&action=edit&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus dengan konfirmasi -->
                                        <a href="digit_handler.php?digit=<?= $digit; ?>&action=hapus&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahDigit" tabindex="-1" role="dialog" aria-labelledby="modalTambahDigitLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary" id="modalTambahDigitLabel">Tambah Data Digit <?= $digit; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="digit_handler.php?digit=<?= $digit; ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="d5" class="font-weight-bold">D5</label>
                        <input type="text" class="form-control" id="d5" name="d5" placeholder="Masukkan nilai D5...">
                    </div>
                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode..." required>
                    </div>
                    <div class="form-group">
                        <label for="nilai" class="font-weight-bold">Nilai</label>
                        <textarea class="form-control" id="nilai" name="nilai" rows="3" placeholder="Masukkan nilai..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>