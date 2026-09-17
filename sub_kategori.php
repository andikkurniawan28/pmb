<?php include('header.php'); ?>

<?php 
    // Query data untuk tabel
    $query = "SELECT 
                sub_kat.*, 
                utama.kode AS kode_utama,
                sub_kel.kode AS kode_sub_kelompok,
                kat.kode AS kode_kategori
              FROM sub_kategori sub_kat
              JOIN kategori kat ON sub_kat.kategori_id = kat.id
              JOIN sub_kelompok_utama sub_kel ON kat.sub_kelompok_utama_id = sub_kel.id
              JOIN kelompok_utama utama ON sub_kel.kelompok_utama_id = utama.id
              ORDER BY utama.kode ASC, sub_kel.kode ASC, kat.kode ASC, sub_kat.kode ASC";
              
    $result = mysqli_query($conn, $query);

    // Query option Kategori (D3) beserta hierarki di atasnya (D1 & D2) untuk modal
    $query_kat = "SELECT 
                    kat.id, 
                    kat.kode AS kode_kat, 
                    kat.keterangan AS ket_kat,
                    sub_kel.kode AS kode_sub_kelompok,
                    utama.kode AS kode_utama
                  FROM kategori kat
                  JOIN sub_kelompok_utama sub_kel ON kat.sub_kelompok_utama_id = sub_kel.id
                  JOIN kelompok_utama utama ON sub_kel.kelompok_utama_id = utama.id
                  ORDER BY utama.kode ASC, sub_kel.kode ASC, kat.kode ASC";
    $result_kat = mysqli_query($conn, $query_kat);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Sub Kategori</h6>
            <!-- Tombol Pemicu Modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahSubKategori">
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
                            <th>D4</th>
                            <th>Gabungan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['kode_utama']); ?></td>
                                <td><?= htmlspecialchars($row['kode_sub_kelompok']); ?></td>
                                <td><?= htmlspecialchars($row['kode_kategori']); ?></td>
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
<div class="modal fade" id="modalTambahSubKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahSubKategoriLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary" id="modalTambahSubKategoriLabel">Tambah Sub Kategori (D4)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="simpan_sub_kategori.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategori_id" class="font-weight-bold">Kategori (D3) <span class="text-danger">*</span></label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php while ($kat = mysqli_fetch_assoc($result_kat)) : ?>
                                <option value="<?= $kat['id']; ?>">
                                    [<?= htmlspecialchars($kat['kode_utama']); ?><?= htmlspecialchars($kat['kode_sub_kelompok']); ?><?= htmlspecialchars($kat['kode_kat']); ?>] <?= htmlspecialchars($kat['ket_kat']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kode" class="font-weight-bold">Kode Sub Kategori (D4) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode (contoh: 01, A, dll)..." required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="keterangan" class="font-weight-bold">Keterangan Sub Kategori <span class="text-danger">*</span></label>
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