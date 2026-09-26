<!-- Judul Ringkas -->
<h6 class="font-weight-bold text-primary mb-1 small"><i class="fas fa-sliders-h mr-1"></i> Label Spesifikasi (D6 - D15)</h6>

<!-- Alert Status Kompak -->
<div id="info_aturan_container" class="alert d-none py-1 px-2 mb-2 small" role="alert">
    <div class="d-flex align-items-center">
        <span id="badge_status_aturan" class="badge mr-2 px-2 py-1" style="font-size: 0.75rem;"></span>
        <strong id="title_status_aturan"></strong>
    </div>
    <div id="info_aturan_content" class="mt-1 pl-1 small"></div>
</div>

<!-- Grid 5 Kolom x 2 Baris (Sejajar dan Hemat Tempat) -->
<div class="row no-gutters mx-n1">
    <?php for ($i = 6; $i <= 15; $i++): ?>
        <div class="col-md-2-4 px-1 mb-2"> <!-- Setiap digit memakan 20% lebar (5 kolom per baris) -->
            <label for="d<?= $i; ?>_id" id="label_d<?= $i; ?>" class="small font-weight-bold text-secondary mb-1 d-block text-truncate">
                D<?= $i; ?>
            </label>
            <div class="input-group input-group-sm">
                <!-- Select Option Utama -->
                <select class="form-control form-control-sm select-level px-1" data-level="<?= $i; ?>" id="d<?= $i; ?>_id" name="d<?= $i; ?>_id" disabled>
                    <option value="0" data-kode="0" data-keterangan="">-- D<?= $i; ?> --</option>
                </select>

                <!-- Input Teks Opsi Baru (Lebar Fleksibel Kecil) -->
                <input type="text" class="form-control form-control-sm px-1" id="input_new_d<?= $i; ?>" placeholder="+ Nilai" style="max-width: 65px;">
                
                <!-- Tombol Simpan Icon Only untuk Menghemat Ruang Horisontal -->
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-success btn-sm px-2 btn-add-digit" data-digit="<?= $i; ?>" title="Tambah Opsi Baru D<?= $i; ?>">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>

<!-- Tambahkan CSS ini di file CSS utama / <style> tag Anda agar Bootstrap support 5 kolom sejajar -->
<style>
@media (min-width: 768px) {
    .col-md-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>