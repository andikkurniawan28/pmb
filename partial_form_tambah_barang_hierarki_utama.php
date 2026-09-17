<h6 class="font-weight-bold text-primary mb-1 small"><i class="fas fa-sitemap mr-1"></i> Famili (D1 - D5)</h6>
<div class="row no-gutters mx-n1">
    <!-- D1 -->
    <div class="col-md px-1 mb-1">
        <label for="d1_id" class="small font-weight-bold mb-0">D1: Kelompok Utama <span class="text-danger">*</span></label>
        <select class="form-control form-control-sm select-level" data-level="1" name="kelompok_utama_id" id="d1_id" required>
            <option value="">-- Pilih D1 --</option>
            <?php while ($d1 = mysqli_fetch_assoc($result_d1)) : ?>
                <option value="<?= $d1['id']; ?>" data-kode="<?= $d1['kode']; ?>" data-keterangan="<?= $d1['keterangan']; ?>">
                    <?= $d1['kode']; ?> - <?= htmlspecialchars($d1['keterangan'] ?? 'Kelompok Utama'); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- D2 -->
    <div class="col-md px-1 mb-1">
        <label for="d2_id" class="small font-weight-bold mb-0">D2: Sub Kelompok</label>
        <select class="form-control form-control-sm select-level" data-level="2" name="sub_kelompok_utama_id" id="d2_id" disabled>
            <option value="">-- Pilih D2 --</option>
        </select>
    </div>

    <!-- D3 -->
    <div class="col-md px-1 mb-1">
        <label for="d3_id" class="small font-weight-bold mb-0">D3: Kategori</label>
        <select class="form-control form-control-sm select-level" data-level="3" name="kategori_id" id="d3_id" disabled>
            <option value="">-- Pilih D3 --</option>
        </select>
    </div>

    <!-- D4 -->
    <div class="col-md px-1 mb-1">
        <label for="d4_id" class="small font-weight-bold mb-0">D4: Sub Kategori</label>
        <select class="form-control form-control-sm select-level" data-level="4" name="sub_kategori_id" id="d4_id" disabled>
            <option value="">-- Pilih D4 --</option>
        </select>
    </div>

    <!-- D5 -->
    <div class="col-md px-1 mb-1">
        <label for="d5_id" class="small font-weight-bold mb-0">D5: Turunan Sub Kategori</label>
        <select class="form-control form-control-sm select-level" data-level="5" name="turunan_sub_kategori_id" id="d5_id" disabled>
            <option value="">-- Pilih D5 --</option>
        </select>
    </div>
</div>