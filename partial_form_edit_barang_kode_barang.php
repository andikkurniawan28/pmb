<div class="row no-gutters mx-n1">
    <!-- Kode Barang (Mencolok & Hemat Tempat) -->
    <div class="col-md-8 px-1 mb-2">
        <label for="kode_barang" class="small font-weight-bold mb-1 text-primary">Kode Barang (15 Digit)</label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white font-weight-bold"><i class="fas fa-barcode mr-1"></i> KODE</span>
            </div>
            <input type="text" class="form-control form-control-sm font-weight-bold text-success bg-light"
                style="font-size: 1.1rem; letter-spacing: 3px;" name="kode_barang" id="kode_barang" readonly required>
        </div>
    </div>

    <!-- Satuan -->
    <div class="col-md-4 px-1 mb-2">
        <label for="satuan" class="small font-weight-bold mb-1">Satuan</label>
        <input type="text" class="form-control form-control-sm" name="satuan" id="satuan" value="<?= $barang['satuan']; ?>" required>
    </div>

    <!-- Nama Barang (D1 - D5) -->
    <div class="col-md-6 px-1 mb-2">
        <label for="nama_barang" class="small font-weight-bold mb-1">Nama Barang (D1 - D5)</label>
        <textarea name="nama_barang" id="nama_barang" class="form-control form-control-sm" rows="2" required><?= $barang['nama_barang'] ?></textarea>
    </div>

    <!-- Spesifikasi / Deskripsi (D6 - D15) -->
    <div class="col-md-6 px-1 mb-2">
        <label for="deskripsi" class="small font-weight-bold mb-1">Spesifikasi (D6 - D15)</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" rows="2" required><?= $barang['deskripsi'] ?></textarea>
    </div>
</div>