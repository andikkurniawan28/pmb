<?php include('header.php'); ?>

<?php 
    // Query data untuk tabel
    $query = "SELECT 
                sub.*, 
                utama.kode AS kode_utama
              FROM sub_kelompok_utama sub
              JOIN kelompok_utama utama ON sub.kelompok_utama_id = utama.id
              ORDER BY sub.kelompok_utama_id ASC, sub.id ASC";
              
    $result = mysqli_query($conn, $query);

    // Query untuk isi option dropdown Kelompok Utama di modal
    $query_utama = "SELECT id, kode, keterangan FROM kelompok_utama ORDER BY kode ASC";
    $result_utama = mysqli_query($conn, $query_utama);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sub Kelompok Utama</h6>
            <!-- Tombol Pemicu Modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahSub">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>D1</th>
                            <th>D2</th>
                            <th>Gabungan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_utama']); ?></td>
                                <td><?= htmlspecialchars($row['kode']); ?></td>
                                <td><?= htmlspecialchars($row['gabungan']); ?></td>
                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="modalTambahSub" tabindex="-1" role="dialog" aria-labelledby="modalTambahSubLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary" id="modalTambahSubLabel">Tambah Sub Kelompok Utama (D2)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="simpan_sub_kelompok_utama.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelompok_utama_id" class="font-weight-bold">Kelompok Utama (D1) <span class="text-danger">*</span></label>
                        <select class="form-control" id="kelompok_utama_id" name="kelompok_utama_id" required>
                            <option value="">-- Pilih Kelompok Utama --</option>
                            <?php while ($u = mysqli_fetch_assoc($result_utama)) : ?>
                                <option value="<?= $u['id']; ?>">
                                    [<?= htmlspecialchars($u['kode']); ?>] - <?= htmlspecialchars($u['keterangan']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode Sub Kelompok (D2) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode (contoh: 01, AA, dll)..." required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="font-weight-bold">Keterangan Sub Kelompok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan..." required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>