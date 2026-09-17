<?php include('header.php'); ?>

<?php 
    // Query untuk mengambil data aturan digit berurutan berdasarkan kode kategori
    $query = "SELECT * FROM aturan_digit ORDER BY kode_kategori ASC";
    $result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Label Spesifikasi</h6>
            <!-- Tombol Pemicu Modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahAturan">
                <i class="fas fa-plus mr-1"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Kelompok</th>
                            <th>D6</th>
                            <th>D7</th>
                            <th>D8</th>
                            <th>D9</th>
                            <th>D10</th>
                            <th>D11</th>
                            <th>D12</th>
                            <th>D13</th>
                            <th>D14</th>
                            <th>D15</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><span class="badge badge-primary px-2 py-1"><?= htmlspecialchars($row['kode_kategori']); ?></span></td>
                                <td><strong><?= htmlspecialchars($row['nama_kelompok_excel'] ?? '-'); ?></strong></td>
                                <td><?= htmlspecialchars($row['param_d6'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d7'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d8'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d9'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d10'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d11'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d12'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d13'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d14'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d15'] ?? '-'); ?></td>
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
<div class="modal fade" id="modalTambahAturan" tabindex="-1" role="dialog" aria-labelledby="modalTambahAturanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold text-primary" id="modalTambahAturanLabel">Tambah Label Spesifikasi (D6 - D15)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="simpan_aturan_digit.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_kategori" class="font-weight-bold">Kode Kategori (3 - 5 Digit) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" 
                               placeholder="Contoh: A01 atau B102C" 
                               minlength="3" maxlength="5" pattern="[A-Za-z0-9]{3,5}" 
                               title="Kode harus terdiri dari 3 hingga 5 karakter alfanumerik" 
                               required autocomplete="off">
                        <small class="form-text text-muted">Minimal 3 karakter, maksimal 5 karakter.</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_kelompok_excel" class="font-weight-bold">Nama Kelompok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kelompok_excel" name="nama_kelompok_excel" placeholder="Masukkan nama kelompok..." required autocomplete="off">
                    </div>

                    <hr>
                    <h6 class="font-weight-bold text-secondary mb-3">Label Parameter Digit (D6 - D15)</h6>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="param_d6">Param D6</label>
                            <input type="text" class="form-control" id="param_d6" name="param_d6" placeholder="Contoh: Ukuran / Merk" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="param_d7">Param D7</label>
                            <input type="text" class="form-control" id="param_d7" name="param_d7" placeholder="Contoh: Bahan / Warna" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="param_d8">Param D8</label>
                            <input type="text" class="form-control" id="param_d8" name="param_d8" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="param_d9">Param D9</label>
                            <input type="text" class="form-control" id="param_d9" name="param_d9" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="param_d10">Param D10</label>
                            <input type="text" class="form-control" id="param_d10" name="param_d10" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="param_d11">Param D11</label>
                            <input type="text" class="form-control" id="param_d11" name="param_d11" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="param_d12">Param D12</label>
                            <input type="text" class="form-control" id="param_d12" name="param_d12" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="param_d13">Param D13</label>
                            <input type="text" class="form-control" id="param_d13" name="param_d13" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="param_d14">Param D14</label>
                            <input type="text" class="form-control" id="param_d14" name="param_d14" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="param_d15">Param D15</label>
                            <input type="text" class="form-control" id="param_d15" name="param_d15" autocomplete="off">
                        </div>
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