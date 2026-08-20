<h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-sliders-h mr-1"></i> Spesifikasi (D6 - D15)</h6>

<!-- Notifikasi Status Aturan Digit -->
<div id="info_aturan_container" class="alert d-none mb-3" role="alert">
    <div class="d-flex align-items-center mb-1">
        <span id="badge_status_aturan" class="badge mr-2 px-2 py-1" style="font-size: 0.85rem;"></span>
        <strong id="title_status_aturan"></strong>
    </div>
    <div id="info_aturan_content" class="mt-2 pl-1"></div>
</div>

<div class="row">
    <?php for ($i = 6; $i <= 15; $i++): ?>
        <div class="col-md-6 form-group">
            <label for="d<?= $i; ?>_id" id="label_d<?= $i; ?>" class="font-weight-bold text-secondary">
                D<?= $i; ?>
            </label>
            <div class="input-group">
                <!-- Select Option Utama (Hapus atribut 'name' agar tidak bentrok dengan hidden input) -->
                <select class="form-control select-level" data-level="<?= $i; ?>" id="d<?= $i; ?>_id" name="d<?= $i; ?>_id" disabled>
                    <option value="0" data-kode="0">-- Pilih D<?= $i; ?> --</option>
                </select>

                <!-- Input Teks Opsi Baru -->
                <input type="text" class="form-control ml-1" id="input_new_d<?= $i; ?>" placeholder="Nilai baru..." style="max-width: 140px;">
                
                <!-- Tombol Simpan Opsi Baru via AJAX -->
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-success btn-add-digit" data-digit="<?= $i; ?>" title="Tambah Opsi Baru">
                        <i class="fas fa-plus"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>