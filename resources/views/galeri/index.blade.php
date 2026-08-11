@extends('main')
@section('content')

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
            <button type="button" class="btn btn-info" disabled title="Form tambah akan menyusul">
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
                  <th>Label</th>
                  <th>Urutan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <p class="text-muted mt-3 mb-0" style="font-size: 13px;">
            Tabel database <code>galeri</code> sudah siap. Form tambah/edit/hapus akan dikerjakan pada tahap berikutnya.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra_script')
<script>
var table = $('#table-data').DataTable({
  processing: true,
  serverSide: false,
  searching: true,
  searchDelay: 1000,
  paging: true,
  autoWidth: false,
  ajax: {
    url: '{{ url('/galeritable') }}',
  },
  columns: [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
    { data: 'gambar', name: 'gambar', orderable: false, searchable: false },
    { data: 'title', name: 'title' },
    {
      data: 'description',
      name: 'description',
      render: function (data) {
        if (!data) return '-';
        return data.length > 80 ? data.substring(0, 80) + '...' : data;
      }
    },
    { data: 'label', name: 'label', defaultContent: '-' },
    { data: 'sort_order', name: 'sort_order' },
    { data: 'status', name: 'status' },
    { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
  ],
  columnDefs: [
    { targets: '_all', className: 'center' }
  ]
});

function edit(id) {
  alert('Fitur edit akan menyusul. ID: ' + id);
}

function hapus(id) {
  alert('Fitur hapus akan menyusul. ID: ' + id);
}
</script>
@endsection
