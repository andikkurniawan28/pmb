<h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-sitemap mr-1"></i> Pengelompokkan (D1 - D5)</h6>
<div class="row">
    <!-- D1 -->
    <div class="col-md-4 form-group">
        <label for="d1_id">Kelompok Utama (D1) <span class="text-danger">*</span></label>
        <select class="form-control select-level" data-level="1" name="kelompok_utama_id" id="d1_id" required>
            <option value="">-- Pilih Kelompok Utama (D1) --</option>
            <?php while ($d1 = mysqli_fetch_assoc($result_d1)) : ?>
                <option value="<?= $d1['id']; ?>" data-kode="<?= $d1['kode']; ?>">
                    <?= $d1['kode']; ?> - <?= htmlspecialchars($d1['keterangan'] ?? 'Kelompok Utama'); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- D2 -->
    <div class="col-md-4 form-group">
        <label for="d2_id">Sub Kelompok Utama (D2)</label>
        <select class="form-control select-level" data-level="2" name="sub_kelompok_utama_id" id="d2_id" disabled>
            <option value="">-- Pilih D2 --</option>
        </select>
    </div>

    <!-- D3 -->
    <div class="col-md-4 form-group">
        <label for="d3_id">Kategori (D3)</label>
        <select class="form-control select-level" data-level="3" name="kategori_id" id="d3_id" disabled>
            <option value="">-- Pilih D3 --</option>
        </select>
    </div>

    <!-- D4 -->
    <div class="col-md-6 form-group">
        <label for="d4_id">Sub Kategori (D4)</label>
        <select class="form-control select-level" data-level="4" name="sub_kategori_id" id="d4_id" disabled>
            <option value="">-- Pilih D4 --</option>
        </select>
    </div>

    <!-- D5 -->
    <div class="col-md-6 form-group">
        <label for="d5_id">Turunan Sub Kategori (D5)</label>
        <select class="form-control select-level" data-level="5" name="turunan_sub_kategori_id" id="d5_id" disabled>
            <option value="">-- Pilih D5 --</option>
        </select>
    </div>
</div>