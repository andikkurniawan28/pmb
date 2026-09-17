<?php include('header.php'); ?>

<?php 
    // Query data untuk tabel
    $query = "SELECT 
                kategori.*, 
                utama.kode AS kode_utama,
                sub.kode AS kode_sub
              FROM kategori
              JOIN sub_kelompok_utama sub ON kategori.sub_kelompok_utama_id = sub.id
              JOIN kelompok_utama utama ON sub.kelompok_utama_id = utama.id
              ORDER BY utama.kode ASC, sub.kode ASC, kategori.kode ASC";
              
    $result = mysqli_query($conn, $query);

    // Query option Sub Kelompok Utama beserta nama Kelompok Utamanya untuk dropdown modal
    $query_sub = "SELECT 
                    sub.id, 
                    sub.kode AS kode_sub, 
                    sub.keterangan AS ket_sub,
                    utama.kode AS kode_utama,
                    utama.keterangan AS ket_utama
                  FROM sub_kelompok_utama sub
                  JOIN kelompok_utama utama ON sub.kelompok_utama_id = utama.id
                  ORDER BY utama.kode ASC, sub.kode ASC";
    $result_sub = mysqli_query($conn, $query_sub);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
            <!-- Tombol Pemicu Modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahKategori">
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
                            <th>D3</th>
                            <th>Gabungan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_utama']); ?></td>
                                <td><?= htmlspecialchars($row['kode_sub']); ?></td>
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
<div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary" id="modalTambahKategoriLabel">Tambah Kategori (D3)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="simpan_kategori.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sub_kelompok_utama_id" class="font-weight-bold">Sub Kelompok Utama (D2) <span class="text-danger">*</span></label>
                        <select class="form-control" id="sub_kelompok_utama_id" name="sub_kelompok_utama_id" required>
                            <option value="">-- Pilih Sub Kelompok Utama --</option>
                            <?php while ($sub = mysqli_fetch_assoc($result_sub)) : ?>
                                <option value="<?= $sub['id']; ?>">
                                    [<?= htmlspecialchars($sub['kode_utama']); ?><?= htmlspecialchars($sub['kode_sub']); ?>] <?= htmlspecialchars($sub['ket_sub']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode Kategori (D3) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode (contoh: 01, A, dll)..." required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="font-weight-bold">Keterangan Kategori <span class="text-danger">*</span></label>
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