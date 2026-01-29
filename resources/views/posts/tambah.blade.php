@extends('main')
@section('content')
    {{-- @include('service.tambah') --}}
    <style type="text/css">

    </style>
    <!-- partial -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb bg-info">
                        <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a></li>
                        {{-- <li class="breadcrumb-item">Setup Master Tagihan</li> --}}
                        <li class="breadcrumb-item active" aria-current="page">Post Management</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Post Management</h4>

                        @if (session('sukses'))
                            <div class="alert alert-success" role="alert">
                                Success, Data berhasil disimpan
                            </div>
                        @endif

                        @if (session('gagal'))
                            <div class="alert alert-danger" role="alert">
                                Gagal, Data gagal disimpan
                            </div>
                        @endif

                        <form id="formportofolio">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="row">

                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            <label>Title</label>
                                        </div>

                                        <div class="col-md-10 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm" name="title"
                                                    id="title" required>
                                                <small class="text-danger" id="title-error" style="display:none;">This field is required</small>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            <label>Category</label>
                                        </div>

                                        <div class="col-md-10 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="category" id="category"
                                                    required>
                                                    <option value="">-- Select Category --</option>
                                                    <option value="artikel">Artikel</option>
                                                    <option value="Wakaf">Wakaf</option>
                                                    <option value="Sejarah Wakaf">Sejarah Wakaf</option>
                                                    <option value="Wakaf Tanah">Wakaf Tanah</option>
                                                    <option value="Wakaf Uang">Wakaf Uang</option>
                                                    <option value="Nazhir">Nazhir</option>
                                                    <option value="Regulasi Wakaf">Regulasi Wakaf</option>
                                                    <option value="Materi Wakaf">Materi Wakaf</option>
                                                    <option value="Test">Test</option>
                                                    <option value="Indeks Wakaf Nasional">Indeks Wakaf Nasional</option>
                                                    <!-- Tambahkan kategori lainnya sesuai kebutuhan -->
                                                </select>
                                                <small class="text-danger" id="category-error" style="display:none;">This field is required</small>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            <label>Description</label>
                                        </div>

                                        <div class="col-md-10 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <textarea id="body" name="body" required></textarea>
                                                    <small class="text-danger" id="body-error" style="display:none;">This field is required</small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>


                        <div id="formuploadimage">
                            <h4 class="card-title">Upload Image</h4>
                            <h6>Ukuran file 1000 x 300 px</h6>
                            <form action="{{ url('/simpanpostscontent') }}" class="dropzone">

                            </form>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" id="btnsubmit">Process</button>
                            <a href="{{ url('/postscontent') }}" class="btn btn-warning">Close</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection
@section('extra_script')
    <script>
        $(document).ready(function() {
            $('#body').summernote({
                toolbar: [
                    // Daftar toolbar yang diizinkan
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Fungsi ini akan diabaikan untuk mematikan fitur upload image
                    }
                }
            });
        });

        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone(".dropzone", {
            autoProcessQueue: false,
            uploadMultiple: true,
            url: "{{ url('/simpanpostscontent') }}",
            acceptedFiles: 'image/*',
            params: function params(files, xhr, chunk) {
                return {
                    '_token': "{{ csrf_token() }}",
                    'title': $('#title').val(),
                    'body': $('#body').val(),
                    'category': $('#category').val()
                };
            },
            init: function() {
                this.on("success", function(file, response) {
                    if (response.status == 1) {
                        iziToast.success({
                            icon: 'fa fa-save',
                            message: 'Data Berhasil Disimpan!',
                        });
                        setTimeout(function() {
                            window.location.href = "{{ url('/postscontent') }}";
                        }, 1000);
                    } else if (response.status == 2) {
                        iziToast.warning({
                            icon: 'fa fa-info',
                            message: 'Data Gagal disimpan!',
                        });
                    } else if (response.status == 3) {
                        iziToast.success({
                            icon: 'fa fa-save',
                            message: 'Data Berhasil Diubah!',
                        });
                        setTimeout(function() {
                            window.location.href = "{{ url('/postscontent') }}";
                        }, 1000);
                    } else if (response.status == 4) {
                        iziToast.warning({
                            icon: 'fa fa-info',
                            message: 'Data Gagal Diubah!',
                        });
                    }
                })
            }
        });

        $('#btnsubmit').click(function() {
            // Reset error messages
            $('.text-danger').hide();
            
            // Validate fields
            let isValid = true;
            if (!$('#title').val().trim()) {
                $('#title-error').show();
                isValid = false;
            }
            if (!$('#category').val()) {
                $('#category-error').show();
                isValid = false;
            }
            if (! $('#body').val()) {
                $('#body-error').show();
                isValid = false;
            }
            
            if (!isValid) {
                return false;
            }

            // Existing submission logic
            if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue();
            } else {
                $.ajax({
                    type: 'post',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'title': $('#title').val(),
                        'body': $('#body').val(),
                        'category': $('#category').val()
                    },
                    dataType: 'json',
                    url: baseUrl + '/simpanpostscontent',
                    success: function(response) {
                        if (response.status == 1) {
                            iziToast.success({
                                icon: 'fa fa-save',
                                message: 'Data Berhasil Disimpan!',
                            });
                            setTimeout(function() {
                                window.location.href = "{{ url('/postscontent') }}";
                            }, 1000);
                        } else if (response.status == 2) {
                            iziToast.warning({
                                icon: 'fa fa-info',
                                message: 'Data Gagal disimpan!',
                            });
                        } else if (response.status == 3) {
                            iziToast.success({
                                icon: 'fa fa-save',
                                message: 'Data Berhasil Diubah!',
                            });
                            setTimeout(function() {
                                window.location.href = "{{ url('/portofoliocontent') }}";
                            }, 1000);
                        } else if (response.status == 4) {
                            iziToast.warning({
                                icon: 'fa fa-info',
                                message: 'Data Gagal Diubah!',
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection
