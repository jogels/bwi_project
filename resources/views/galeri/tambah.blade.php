<!-- Modal Tambah Galeri -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title">Form Galeri</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form-galeri" enctype="multipart/form-data">
          <table class="table table_modal">
            <tr>
              <td style="width: 180px;">Judul <span class="text-danger">*</span></td>
              <td>
                <input type="text" class="form-control form-control-sm" name="title" id="galeri-title" required>
              </td>
            </tr>
            <tr>
              <td>Deskripsi</td>
              <td>
                <textarea class="form-control form-control-sm" name="description" id="galeri-description" rows="4"></textarea>
              </td>
            </tr>
            <tr>
              <td>Gambar</td>
              <td>
                <input type="file" class="form-control form-control-sm" name="image" id="galeri-image" accept="image/*">
                <small class="text-muted">Format: jpg, jpeg, png, webp. Maks 5MB.</small>
                <div id="galeri-image-preview" class="mt-2" style="display:none;">
                  <img src="" alt="Preview" style="max-width: 220px; max-height: 140px; object-fit: cover; border-radius: 8px;">
                </div>
              </td>
            </tr>
            <tr>
              <td>Label</td>
              <td>
                <input type="text" class="form-control form-control-sm" name="label" id="galeri-label" placeholder="Contoh: Featured / Galeri">
              </td>
            </tr>
            <tr>
              <td>Urutan</td>
              <td>
                <input type="number" class="form-control form-control-sm" name="sort_order" id="galeri-sort-order" value="0" min="0">
                <small class="text-muted">Semakin kecil angkanya, semakin awal ditampilkan.</small>
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>
                <select class="form-control form-control-sm" name="status" id="galeri-status">
                  <option value="aktif" selected>aktif</option>
                  <option value="nonaktif">nonaktif</option>
                </select>
              </td>
            </tr>
          </table>
        </form>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpan-galeri" type="button">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
