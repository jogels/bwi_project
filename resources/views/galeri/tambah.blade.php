<!-- Modal Tambah / Edit Galeri -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info">
        <h4 class="modal-title" id="galeri-modal-title">Form Galeri</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form-galeri" enctype="multipart/form-data">
          <input type="hidden" name="id" id="galeri-id" value="">
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
              <td>Gambar <span class="text-danger">*</span></td>
              <td>
                <input type="file" class="form-control form-control-sm" name="image" id="galeri-image" accept="image/*">
                <small class="text-muted">Format: jpg, jpeg, png, webp. Maks 5MB. Saat edit, kosongkan jika tidak diganti.</small>
                <div id="galeri-image-preview" class="mt-2" style="display:none;">
                  <img src="" alt="Preview" style="max-width: 220px; max-height: 140px; object-fit: cover; border-radius: 8px;">
                </div>
              </td>
            </tr>
            <tr>
              <td>Style Galeri <span class="text-danger">*</span></td>
              <td>
                <select class="form-control form-control-sm" name="style" id="galeri-style">
                  <option value="foto">foto</option>
                  <option value="foto_deskripsi">foto+Deskripsi</option>
                  <option value="carousel">Carousel</option>
                </select>
                <small class="text-muted d-block mt-1" id="galeri-style-hint">
                  Full width: judul & deskripsi di dalam foto bagian bawah.
                </small>
              </td>
            </tr>
            <tr id="galeri-position-row" style="display:none;">
              <td>Posisi Foto</td>
              <td>
                <select class="form-control form-control-sm" name="photo_position" id="galeri-photo-position">
                  <option value="kanan">Foto di kanan</option>
                  <option value="kiri">Foto di kiri</option>
                </select>
                <small class="text-muted">Khusus style foto+Deskripsi.</small>
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
