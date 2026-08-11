@extends('main')
@section('content')
@include('galeri.tambah')

<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Manajemen Galeri</li>
        </ol>
      </nav>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Manajemen Galeri</h4>
          <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah" onclick="resetFormGaleri()">
              <i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data
            </button>
          </div>
          <div class="table-responsive">
            <table class="table table_status table-hover" id="table-data" cellspacing="0">
              <thead class="bg-gradient-info">
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Judul</th>
                  <th>Deskripsi</th>
                  <th>Style Galeri</th>
                  <th>Urutan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra_script')
<script>
var styleHints = {
  foto: 'Full width persegi panjang: judul & deskripsi di dalam foto bagian bawah.',
  foto_deskripsi: '1 baris persegi: card deskripsi + card foto. Pilih posisi foto kiri/kanan.',
  carousel: 'Bisa upload banyak foto. Grid max 3 per baris (persegi). Klik ✕ untuk hapus foto dari daftar.'
};

var carouselFiles = [];
var existingCarouselImage = null; // { url: '...' } saat edit 1 item

var table = $('#table-data').DataTable({
  processing: true,
  serverSide: false,
  searching: true,
  searchDelay: 1000,
  paging: true,
  autoWidth: false,
  ajax: { url: '{{ url('/galeritable') }}' },
  columns: [
    { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
    { data: 'gambar', name: 'gambar', orderable: false, searchable: false },
    { data: 'title', name: 'title' },
    {
      data: 'description',
      name: 'description',
      render: function (data) {
        if (!data || data === '-') return '-';
        return data.length > 80 ? data.substring(0, 80) + '...' : data;
      }
    },
    { data: 'style_label', name: 'style_label' },
    { data: 'sort_order', name: 'sort_order' },
    { data: 'status', name: 'status' },
    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
  ],
  columnDefs: [{ targets: '_all', className: 'center' }]
});

function isCarousel() {
  return $('#galeri-style').val() === 'carousel';
}

function toggleStyleFields() {
  var style = $('#galeri-style').val();
  $('#galeri-style-hint').text(styleHints[style] || '');

  if (style === 'foto_deskripsi') {
    $('#galeri-position-row').show();
  } else {
    $('#galeri-position-row').hide();
  }

  if (style === 'carousel') {
    $('#galeri-single-image-row').hide();
    $('#galeri-multi-image-row').show();
    $('#galeri-image').val('');
    renderCarouselGrid();
  } else {
    $('#galeri-single-image-row').show();
    $('#galeri-multi-image-row').hide();
    carouselFiles = [];
    existingCarouselImage = null;
    $('#galeri-carousel-grid').empty();
    $('#galeri-images').val('');
  }
}

function renderCarouselGrid() {
  var $grid = $('#galeri-carousel-grid');
  $grid.empty();

  if (existingCarouselImage && existingCarouselImage.url) {
    $grid.append(
      '<div class="galeri-carousel-preview-item" data-existing="1">' +
        '<img src="' + existingCarouselImage.url + '" alt="existing">' +
        '<button type="button" class="galeri-carousel-preview-remove" data-existing="1" title="Hapus">&times;</button>' +
      '</div>'
    );
  }

  carouselFiles.forEach(function (item, index) {
    $grid.append(
      '<div class="galeri-carousel-preview-item" data-index="' + index + '">' +
        '<img src="' + item.preview + '" alt="preview">' +
        '<button type="button" class="galeri-carousel-preview-remove" data-index="' + index + '" title="Hapus">&times;</button>' +
      '</div>'
    );
  });
}

function resetFormGaleri() {
  $('#form-galeri')[0].reset();
  $('#galeri-id').val('');
  $('#galeri-remove-image').val('0');
  $('#galeri-style').val('foto');
  $('#galeri-photo-position').val('kanan');
  $('#galeri-status').val('aktif');
  $('#galeri-image-preview').hide().find('img').attr('src', '');
  $('#galeri-modal-title').text('Form Galeri - Tambah');
  $('#galeri-image').val('');
  $('#galeri-images').val('');
  carouselFiles = [];
  existingCarouselImage = null;
  $('#galeri-carousel-grid').empty();
  toggleStyleFields();
}

$('#galeri-style').on('change', toggleStyleFields);

$('#galeri-image').on('change', function () {
  var file = this.files[0];
  if (!file) return;
  var reader = new FileReader();
  reader.onload = function (e) {
    $('#galeri-image-preview').css('display', 'inline-block').find('img').attr('src', e.target.result);
  };
  reader.readAsDataURL(file);
});

$('#galeri-images').on('change', function () {
  var files = Array.from(this.files || []);
  files.forEach(function (file) {
    if (!file.type.match(/^image\//)) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      carouselFiles.push({ file: file, preview: e.target.result });
      renderCarouselGrid();
    };
    reader.readAsDataURL(file);
  });
  // reset input agar bisa pilih file yang sama lagi nanti
  $(this).val('');
});

$(document).on('click', '.galeri-carousel-preview-remove', function () {
  if ($(this).data('existing')) {
    existingCarouselImage = null;
    $('#galeri-remove-image').val('1');
  } else {
    var index = parseInt($(this).data('index'), 10);
    carouselFiles.splice(index, 1);
  }
  renderCarouselGrid();
});

$('#simpan-galeri').on('click', function () {
  var title = $.trim($('#galeri-title').val());
  var isEdit = !!$('#galeri-id').val();
  var style = $('#galeri-style').val();

  if (!title) {
    iziToast.warning({ icon: 'fa fa-info', message: 'Judul wajib diisi!' });
    return;
  }

  if (style === 'carousel') {
    var hasExisting = existingCarouselImage && existingCarouselImage.url && $('#galeri-remove-image').val() !== '1';
    if (!isEdit && carouselFiles.length === 0) {
      iziToast.warning({ icon: 'fa fa-info', message: 'Minimal 1 foto untuk Carousel!' });
      return;
    }
    if (isEdit && !hasExisting && carouselFiles.length === 0) {
      iziToast.warning({ icon: 'fa fa-info', message: 'Minimal 1 foto untuk Carousel!' });
      return;
    }
  } else if (!isEdit && !$('#galeri-image')[0].files.length) {
    iziToast.warning({ icon: 'fa fa-info', message: 'Gambar wajib diupload!' });
    return;
  }

  var formData = new FormData();
  formData.append('_token', '{{ csrf_token() }}');
  formData.append('id', $('#galeri-id').val() || '');
  formData.append('title', $('#galeri-title').val());
  formData.append('description', $('#galeri-description').val());
  formData.append('style', style);
  formData.append('photo_position', $('#galeri-photo-position').val());
  formData.append('status', $('#galeri-status').val());
  formData.append('remove_image', $('#galeri-remove-image').val());

  if (style === 'carousel') {
    carouselFiles.forEach(function (item) {
      formData.append('images[]', item.file);
    });
  } else if ($('#galeri-image')[0].files.length) {
    formData.append('image', $('#galeri-image')[0].files[0]);
  }

  var $btn = $(this);
  $btn.prop('disabled', true).text('Menyimpan...');

  $.ajax({
    type: 'POST',
    url: baseUrl + '/simpangaleri',
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
    success: function (data) {
      $btn.prop('disabled', false).text('Submit');
      if (data.status == 1 || data.status == 3) {
        iziToast.success({
          icon: 'fa fa-save',
          message: data.message || 'Berhasil disimpan!',
        });
        $('#tambah').modal('hide');
        resetFormGaleri();
        table.ajax.reload(null, false);
      } else {
        iziToast.warning({
          icon: 'fa fa-info',
          message: data.message || 'Data gagal disimpan!',
        });
      }
    },
    error: function (xhr) {
      $btn.prop('disabled', false).text('Submit');
      var message = 'Terjadi kesalahan saat menyimpan data.';
      if (xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
      iziToast.error({ icon: 'fa fa-times', message: message });
    }
  });
});

function edit(id) {
  $.ajax({
    url: baseUrl + '/editgaleri',
    data: { id: id },
    dataType: 'json',
    success: function (data) {
      $('#galeri-id').val(data.id);
      $('#galeri-title').val(data.title);
      $('#galeri-description').val(data.description || '');
      $('#galeri-style').val(data.style || 'foto');
      $('#galeri-photo-position').val(data.photo_position || 'kanan');
      $('#galeri-status').val(data.status || 'aktif');
      $('#galeri-image').val('');
      $('#galeri-images').val('');
      $('#galeri-remove-image').val('0');
      $('#galeri-modal-title').text('Form Galeri - Edit');
      carouselFiles = [];

      if ((data.style || 'foto') === 'carousel') {
        existingCarouselImage = data.image_url ? { url: data.image_url } : null;
        $('#galeri-image-preview').hide().find('img').attr('src', '');
      } else {
        existingCarouselImage = null;
        if (data.image_url) {
          $('#galeri-image-preview').css('display', 'inline-block').find('img').attr('src', data.image_url);
        } else {
          $('#galeri-image-preview').hide().find('img').attr('src', '');
        }
      }

      toggleStyleFields();
      $('#tambah').modal('show');
    },
    error: function () {
      iziToast.error({ icon: 'fa fa-times', message: 'Gagal memuat data untuk diedit.' });
    }
  });
}

function hapus(id) {
  iziToast.question({
    close: false,
    overlay: true,
    displayMode: 'once',
    title: 'Hapus data',
    message: 'Apakah anda yakin ingin menghapus data galeri ini?',
    position: 'center',
    buttons: [
      ['<button><b>Ya</b></button>', function (instance, toast) {
        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        $.ajax({
          url: baseUrl + '/hapusgaleri',
          data: { id: id },
          dataType: 'json',
          success: function (data) {
            if (data.status == 3) {
              iziToast.success({ icon: 'fa fa-trash', message: data.message || 'Data berhasil dihapus!' });
              table.ajax.reload(null, false);
            } else {
              iziToast.warning({ icon: 'fa fa-info', message: data.message || 'Gagal menghapus data.' });
            }
          },
          error: function (xhr) {
            var message = 'Gagal menghapus data.';
            if (xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
            iziToast.error({ icon: 'fa fa-times', message: message });
          }
        });
      }, true],
      ['<button>Tidak</button>', function (instance, toast) {
        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
      }]
    ]
  });
}

$(function () {
  toggleStyleFields();
});
</script>
@endsection
