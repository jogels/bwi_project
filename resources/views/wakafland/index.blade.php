@extends('main')
@section('content')
    @include('wakafland.tambah')
    @include('wakafland.import')
    <style type="text/css">
        #map {
            height: 300px;
            width: 100%;
        }
    </style>
    <!-- partial -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb bg-info">
                        <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tanah Wakaf</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tanah Wakaf</h4>
                        <!-- Buttons -->
                        <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Data
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
                                <i class="fa fa-upload"></i>&nbsp;&nbsp;Import Data
                            </button>
                        </div>

                        <!-- Filter (New Row) -->
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="city">Kota</label>
                                <select class="form-control select2" name="city_id_filter" id="city_id_filter"
                                    onchange="onCityChange(this.value)">
                                    <option value="">-- Pilih Kota --</option>
                                    @foreach ($city as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="subdistrict_filter">Kecamatan</label>
                                <select id="subdistrict_filter" class="form-control" name="subdistrict_filter" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive mt-4">
                            <table class="table table_status table-hover" id="table-data" cellspacing="0">
                                <thead class="bg-gradient-info">
                                    <tr>
                                        <th>No</th>
                                        <th>No Registrasi</th>
                                        <th>Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
                                        <th>Luas Area</th>
                                        <th>Penggunaan</th>
                                        <th>Nama Objek</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>No Sertifikat</th>
                                        <th>Tanggal Sertifikat</th>
                                        <th>No AIW</th>
                                        <th>Tanggal AIW</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Wakif</th>
                                        <th>Nadzir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat melalui DataTable AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- content-wrapper ends -->

    <!-- Modal -->
    <div id="mapmodal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xs">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-gradient-info">
                    <h4 class="modal-title">Pilih Lokasi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Form Pencarian Lokasi -->
                    <div class="form-group">

                        <input type="text" id="locationSearch" class="form-control" placeholder="Masukkan kota atau lokasi"
                            hidden />
                    </div>

                    <!-- Peta -->
                    <div id="map" style="height: 400px;"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="pickmap()" type="button">Proses</button>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
@section('extra_script')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        $(document).on('change', '#city_id_filter, #city_id_import', function() {
            const isImport = this.id === 'city_id_import';
            const cityId = $(this).val();
            isImport ? onCityChangeImport(cityId) : onCityChange(cityId);
        });

        // $('#simpan').click(function() {
        //     resetForm();
        // });

        $('#modal-close').click(function() {
            resetForm();
        });

        $('#modal-close-x').click(function() {
            resetForm();
        });

        function onCityChange(cityId) {
            console.log("<<Masuk function");
            if (cityId == '' || cityId == null) {
                return;
            }

            if (!cityId) {
                $('#subdistrict_filter').prop('disabled', true).html('<option value="">Pilih Kecamatan</option>');
                $('#village').prop('disabled', true).html('<option value="">Pilih Desa</option>');
                return;
            }

            // Ajax untuk mendapatkan data
            $.ajax({
                url: baseUrl + '/get-subdistricts/' + cityId,
                method: 'GET',
                dataType: "json",
                success: function(data) {
                    let options = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(subdistrict => {
                        options += `<option value="${subdistrict.id}">${subdistrict.name}</option>`;
                    });
                    $('#subdistrict_filter').prop('disabled', false).html(options);

                    table.ajax.reload();
                    table.settings()[0].ajax.data = function(d) {
                        d.city_id = cityId;
                    };
                },
                error: function(error) {
                    alert('Gagal memuat data kecamatan.');
                }
            });
        }

        function onCityChangeImport(cityId) {
            console.log("<<Masuk function");

            if (cityId == '' || cityId == null) {
                return;
            }

            if (!cityId) {
                $('#subdistrict_id_import').prop('disabled', true).html('<option value="">Pilih Kecamatan</option>');
            }

            // Ajax untuk mendapatkan data
            $.ajax({
                url: baseUrl + '/get-subdistricts/' + cityId,
                method: 'GET',
                dataType: "json",
                success: function(data) {
                    let options = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(subdistrict => {
                        options += `<option value="${subdistrict.id}">${subdistrict.name}</option>`;
                    });
                    $('#subdistrict_id_import').prop('disabled', false).html(options);

                    table.ajax.reload();
                    table.settings()[0].ajax.data = function(d) {
                        d.city_id = cityId;
                    };
                },
                error: function(error) {
                    console.error('Gagal memuat kecamatan:', error);
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat kecamatan. Silakan coba lagi.',
                    });
                }
            });
        }

        // Add event listener for subdistrict filter
        $('#subdistrict_filter').on('change', function() {
            table.settings()[0].ajax.data = function(d) {
                d.subdistrict_id = $('#subdistrict_filter').val();
            };
            table.ajax.reload();
            console.log($('#subdistrict_filter').val(), "<<Subdistrict Filter1111");
            
        });

        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: false,
            searching: true,
            searchDelay: 1000,
            paging: true,
            dom: 'Bfrtip',
            title: '',
            buttons: [
                'copy',
                {
                    extend: 'print',
                    text: 'Cetak',
                    customize: function(win) {
                        const $body = $(win.document.body);
                        $body.find('style').append('@page { size: landscape; }');
                        
                        const actionColumn = $body.find('th:contains("Aksi")');
                        const colIndex = actionColumn.index();
                        if (colIndex > -1) {
                            actionColumn.hide();
                            $body.find(`td:nth-child(${colIndex + 1})`).hide();
                        }
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        // Mengatur orientasi sheet Excel menjadi landscape
                        $('pageMargins', sheet).text('0.7,0.7,0.7,0.7');
                        // Menghilangkan kolom aksi di Excel
                        $(sheet).find('row c[r="A1"]').each(function() {
                            var colIndex = $(this).parent().index() + 1;
                            $('row', sheet).each(function() {
                                $('c', this).eq(colIndex - 1).remove();
                            });
                        });
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    customize: function(csv) {
                        // CSV tidak mendukung orientasi, tetapi kita bisa menghilangkan kolom aksi
                        var lines = csv.split('\n');
                        var filteredLines = lines.filter(function(line) {
                            return !line.includes('Aksi'); // Menghilangkan kolom aksi
                        });
                        return filteredLines.join('\n');
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize: function(doc) {
                        // Mengatur orientasi PDF menjadi landscape
                        doc.pageSize = 'A4';
                        doc.pageOrientation = 'landscape';

                        // Menghilangkan kolom aksi di PDF
                        var body = doc.content[1].table.body;
                        var actionColumnIndex = body[0].indexOf('Aksi');
                        for (var i = 0; i < body.length; i++) {
                            body[i].splice(actionColumnIndex, 1);
                        }
                    }
                }
            ],
            ajax: {
                url: '{{ url('/wakaflandtable') }}',
                data: function(d) {
                    const $cityFilter = $('#city_id_filter');
                    const $subdistrictFilter = $('#subdistrict_filter');
                    console.log($cityFilter.val(), "<<City Filter");
                    console.log($subdistrictFilter.val(), "<<Subdistrict Filter");
                    d.city_id = $cityFilter.val();
                    d.subdistrict_id = $subdistrictFilter.val();
                }
            },
            columnDefs: [

                {
                    targets: 0,
                    className: 'center id'
                },
                {
                    targets: 1,
                    className: 'center'
                },
                {
                    targets: 2,
                    className: 'center'
                },
                {
                    targets: 2,
                    className: 'center'
                },
            ],
            "columns": [{
                    data: 'DT_Row_Index',
                    name: 'DT_Row_Index'
                },
                {
                    data: 'register_no',
                    name: 'register_no'
                },
                {
                    data: 'city_name',
                    name: 'city_name'
                },
                {
                    data: 'subdistrict_name',
                    name: 'subdistrict_name'
                },
                {
                    data: 'village_name',
                    name: 'village_name'
                },
                {
                    data: 'area_size',
                    name: 'area_size'
                },
                {
                    data: 'used',
                    name: 'used'
                },
                {
                    data: 'object_name',
                    name: 'object_name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'certificate_no',
                    name: 'certificate_no'
                },
                {
                    data: 'certificate_date',
                    name: 'certificate_date'
                },
                {
                    data: 'aiw_no',
                    name: 'aiw_no'
                },
                {
                    data: 'aiw_date',
                    name: 'aiw_date'
                },
                {
                    data: 'latitude',
                    name: 'latitude'
                },
                {
                    data: 'longitude',
                    name: 'longitude'
                },
                {
                    data: 'wakif_name',
                    name: 'wakif_name'
                },
                {
                    data: 'nadzir_name',
                    name: 'nadzir_name'
                },
                {
                    data: 'aksi',
                    name: 'aksi'
                }
            ]
        });

        $('#city_id').on('change', function() {
            const cityId = $(this).val();
            if (!cityId) {
                // clearMarkers(); // Hapus semua marker
                // mymap.setView([latitude, longitude], 2); // Reset peta ke posisi awal
                // table.ajax.reload(null, false); // Reload DataTable tanpa filter
                return;
            }

            onCityChangeAdd(cityId); // Panggil fungsi onCityChange untuk memproses data
        });

        $('#subdistrict_id').on('change', function() {
            const subdistrictId = $(this).val();
            if (!subdistrictId) {
                // clearMarkers(); // Hapus semua marker
                // mymap.setView([latitude, longitude], 2); // Reset peta ke posisi awal
                // table.ajax.reload(null, false); // Reload DataTable tanpa filter
                return;
            }

            onSubdistrictChangeAdd(subdistrictId); // Panggil fungsi onCityChange untuk memproses data
        });



        function onCityChangeAdd(cityId) {
            if (cityId == '' || cityId == null) {
                return;
            }
            console.log("<<Masuk function");

            if (!cityId) {
                $('#subdistrict_id').prop('disabled', true).html('<option value="">Pilih Kecamatan</option>');
                $('#village').prop('disabled', true).html('<option value="">Pilih Desa</option>');
                return;
            }

            // Ajax untuk mendapatkan data
            $.ajax({
                url: baseUrl + '/get-subdistricts/' + cityId,
                method: 'GET',
                dataType: "json",
                success: function(data) {
                    let options = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(subdistrict => {
                        options += `<option value="${subdistrict.id}">${subdistrict.name}</option>`;
                    });
                    $('#subdistrict_id').prop('disabled', false).html(options);

                },
                error: function(error) {
                    alert('Gagal memuat kecamatan.');
                }
            });
        }

        function onSubdistrictChangeAdd(subdistrictId) {
            if (!subdistrictId) {
                $('#village_id').prop('disabled', true).html('<option value="">Pilih Desa</option>');
                return;
            }

            // Ajax untuk mendapatkan data
            $.ajax({
                url: baseUrl + '/get-villages/' + subdistrictId,
                method: 'GET',
                dataType: "json",
                success: function(data) {
                    let options = '<option value="">Pilih Desa</option>';
                    data.forEach(village => {
                        options += `<option value="${village.id}">${village.name}</option>`;
                    });
                    $('#village_id').prop('disabled', false).html(options);

                },
                error: function(error) {
                    alert('Gagal memuat desa.');
                }
            });
        }

        let markers = [];

        function clearMarkers() {
            markers.forEach(marker => mymap.removeLayer(marker));
            markers = [];
        }

        function resetForm() {
            $('#form-wakaf')[0].reset();
            $('.select2').val('').trigger('change');
            $('#selected-files').empty();
            $('#photos').val('');
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        function edit(id) {
            $.ajax({
                url: baseUrl + '/editwakafland',
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    console.log("Edit data received:", data); // Debug log
                    
                    $('.id').val(data.id);
                    $('.register_no').val(data.register_no);
                    
                    // Set city first
                    $("#city_id").val(data.city_id).trigger('change');
                    
                    // Use setTimeout to ensure city change event has completed
                    setTimeout(function() {
                        // Load and set subdistricts
                        $.ajax({
                            url: baseUrl + '/get-subdistricts/' + data.city_id,
                            method: 'GET',
                            dataType: "json",
                            success: function(subdistrictData) {
                                console.log("Subdistrict data loaded:", subdistrictData); // Debug log
                                
                                let options = '<option value="">Pilih Kecamatan</option>';
                                subdistrictData.forEach(subdistrict => {
                                    options += `<option value="${subdistrict.id}">${subdistrict.name}</option>`;
                                });
                                
                                $('#subdistrict_id')
                                    .html(options)
                                    .prop('disabled', false)
                                    .val(data.subdistrict_id)
                                    .trigger('change');
                                
                                // Use setTimeout again for village loading
                                setTimeout(function() {
                                    // Load and set villages
                                    $.ajax({
                                        url: baseUrl + '/get-villages/' + data.subdistrict_id,
                                        method: 'GET',
                                        dataType: "json",
                                        success: function(villageData) {
                                            console.log("Village data loaded:", villageData); // Debug log
                                            
                                            let villageOptions = '<option value="">Pilih Desa</option>';
                                            villageData.forEach(village => {
                                                villageOptions += `<option value="${village.id}">${village.name}</option>`;
                                            });
                                            
                                            $('#village_id')
                                                .html(villageOptions)
                                                .prop('disabled', false)
                                                .val(data.village_id)
                                                .trigger('change');
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error loading villages:", error);
                                        }
                                    });
                                }, 300);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error loading subdistricts:", error);
                            }
                        });
                    }, 300);

                    // Rest of the form data
                    $('.area_size').val(data.area_size);
                    $('.used').val(data.used);
                    $('.object_name').val(data.object_name);
                    $('.address').val(data.address);
                    $('.status').val(data.status);
                    $('.certificate_no').val(data.certificate_no);
                    $('#certificate_date').val(data.certificate_date);
                    $('.aiw_no').val(data.aiw_no);
                    $('#aiw_date').val(data.aiw_date);
                    $('.latitude').val(data.latitude);
                    $('.longitude').val(data.longitude);
                    $(".wakif_name").val(data.wakif_name);
                    $(".nadzir_name").val(data.nadzir_name);

                    // Photo handling
                    const photoContainer = $('#selected-files');
                    photoContainer.empty();
                    
                    if (data.photo_urls && data.photo_urls.length > 0) {
                        photoContainer.append(`
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-2">Foto yang ada:</p>
                                </div>
                            </div>
                            <div class="row">
                        `);
                        
                        data.photo_urls.forEach((url, index) => {
                            const fullUrl = `{{ asset('${url}') }}`;
                            
                            photoContainer.append(`
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="card">
                                        <img src="${fullUrl}" class="card-img-top" alt="Foto Tanah Wakaf" 
                                             style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2 text-center">
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deletePhoto(${data.photo_ids[index]})">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                        
                        photoContainer.append('</div>');
                    }

                    $('#tambah').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error in edit function:", error);
                }
            });
        }

        // Add delete photo function
        function deletePhoto(photoId) {
            iziToast.question({
                close: false,
                overlay: true,
                displayMode: 'once',
                title: 'Hapus Foto',
                message: 'Apakah Anda yakin ingin menghapus foto ini?',
                position: 'center',
                buttons: [
                    ['<button><b>Ya</b></button>', function(instance, toast) {
                        $.ajax({
                            url: baseUrl + '/wakafland/delete-photo',
                            type: 'POST',
                            data: {
                                photo_id: photoId,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status === 1) {
                                    iziToast.success({
                                        icon: 'fa fa-trash',
                                        message: 'Foto berhasil dihapus!',
                                    });
                                    // Refresh the photos display
                                    edit($('.id').val());
                                } else {
                                    iziToast.error({
                                        icon: 'fa fa-times',
                                        message: 'Gagal menghapus foto: ' + response.message,
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                iziToast.error({
                                    icon: 'fa fa-times',
                                    message: 'Error menghapus foto: ' + error,
                                });
                            }
                        });
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>Tidak</button>', function(instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        $('#simpan').click(function() {
            // Reset previous validation states
            $('.is-invalid').removeClass('is-invalid');
            
            // Required fields validation
            let isValid = true;
            const requiredFields = [
                { elem: '.register_no', message: 'Nomor registrasi wajib diisi' },
                { elem: '#city_id', message: 'Kota wajib diisi' },
                { elem: '#subdistrict_id', message: 'Kecamatan wajib diisi' },
                { elem: '#village_id', message: 'Desa wajib diisi' },
                { elem: '.area_size', message: 'Luas area wajib diisi' },
                { elem: '.used', message: 'Penggunaan wajib diisi' },
                { elem: '.object_name', message: 'Nama objek wajib diisi' },
                { elem: '.aiw_no', message: 'Nomor AIW wajib diisi' },
                { elem: '.address', message: 'Alamat wajib diisi' }
            ];

            requiredFields.forEach(field => {
                const element = $(field.elem);
                const value = element.val();
                
                if (!value || value.trim() === '') {
                    element.addClass('is-invalid');
                    if (element.next('.invalid-feedback').length === 0) {
                        element.after(`<div class="invalid-feedback">${field.message}</div>`);
                    }
                    console.log(element, "<<Element");
                    isValid = false;
                }
            });

            

            // If validation fails, stop form submission
            if (!isValid) {
                iziToast.error({
                    title: 'Validation Error',
                    message: 'Please fill in all required fields',
                });
                return false;
            }

            // Continue with existing form submission code
            var formData = new FormData();

            // Add id if exists
            const id = $('.id').val();
            if (id) {
                formData.append('id', id);
            }
            
            // Add all form inputs to FormData
            $('.table_modal :input').each(function() {
                if ($(this).attr('type') != 'file') {
                    formData.append($(this).attr('name'), $(this).val());
                }
            });
            
            // Add multiple files
            var files = $('#photos')[0].files;
            for (var i = 0; i < files.length; i++) {
                formData.append('photos[]', files[i]);
            }

            $.ajax({
                type: "POST",
                url: baseUrl + '/simpanwakafland',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.status == 1) {
                        iziToast.success({
                            icon: 'fa fa-save',
                            message: 'Data Berhasil Disimpan!',
                        });
                        reloadall();
                    } else if (data.status == 2) {
                        iziToast.warning({
                            icon: 'fa fa-info',
                            message: 'Data Gagal disimpan!',
                        });
                    } else if (data.status == 3) {
                        iziToast.success({
                            icon: 'fa fa-save',
                            message: 'Data Berhasil Diubah!',
                        });
                        reloadall();
                    } else if (data.status == 4) {
                        iziToast.warning({
                            icon: 'fa fa-info',
                            message: 'Data Gagal Diubah!',
                        });
                    }
                    resetForm();
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        icon: 'fa fa-times',
                        message: 'Error: ' + error,
                    });
                }
            });
        });

        // Add file input change handler
        $('#photos').change(function() {
            var fileList = $('#selected-files');
            fileList.empty();

            if (this.files.length > 0) {
                fileList.append('<p>File yang dipilih:</p>');
                for (var i = 0; i < this.files.length; i++) {
                    fileList.append('<div>' + this.files[i].name + '</div>');
                }
            }

            console.log('Files selected:', this.files);
        });

        function hapus(id) {
            iziToast.question({
                close: false,
                overlay: true,
                displayMode: 'once',
                title: 'Hapus data',
                message: 'Apakah anda yakin ?',
                position: 'center',
                buttons: [
                    ['<button><b>Ya</b></button>', function(instance, toast) {
                        $.ajax({
                            url: baseUrl + '/hapuswakafland',
                            data: {
                                id
                            },
                            dataType: 'json',
                            success: function(data) {
                                iziToast.success({
                                    icon: 'fa fa-trash',
                                    message: 'Data Berhasil Dihapus!',
                                });

                                reloadall();
                            }
                        });
                    }, true],
                    ['<button>Tidak</button>', function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOut'
                        }, toast, 'button');
                    }],
                ]
            });
        }

        function reloadall() {
            resetForm();
            $('#tambah').modal('hide');
            table.ajax.reload(null, false); // false prevents page reset
        }

        var latitude = -6.175392  // Monas latitude
        var longitude = 106.827153  // Monas longitude
        let marker = null;

        const mymap = L.map('map').setView([latitude, longitude], 13);


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            subdomains: ['a', 'b', 'c'],
            minZoom: 1,
            maxZoom: 19
        }).addTo(mymap);

        // Fungsi untuk menambahkan marker baru
        function updateMarker(lat, lng) {
            console.log("<<Masuk Update");
            console.log(marker, "<<Marker Update");

            if (marker) {
                console.log("<<Masuk remove Update");

                mymap.removeLayer(marker); // Hapus marker lama
            }
            marker = L.marker([lat, lng]).addTo(mymap);
            // Fetch nama lokasi menggunakan Nominatim API
            const nominatimUrl = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

            
            fetch(nominatimUrl)
                .then((response) => response.json())
                .then((data) => {
                    const address = data.display_name || "Nama lokasi tidak ditemukan";
                    marker.bindPopup(address).openPopup(); // Gunakan nama lokasi sebagai konten popup
                })
                .catch((error) => {
                    console.error("Error fetching address:", error);
                    marker.bindPopup("Nama lokasi tidak ditemukan").openPopup(); // Tampilkan pesan default jika gagal
                });

            mymap.setView([lat, lng], 13); // Pusatkan peta ke marker baru
            console.log(marker, "<<Marker");

        }

        mymap.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;

            updateMarker(lat, lng); // Perbarui marker berdasarkan klik
            latitude = lat;
            longitude = lng;

        });

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {

                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                updateMarker(lat, lng); // Gunakan fungsi updateMarker
                latitude = lat;
                longitude = lng;
            }, function(error) {
                console.error("Geolocation error:", error.message);
                // alert("Geolocation failed. Please check location permissions.");
                mymap.setView([51.505, -0.09], 13);
            });
        } else {
            iziToast.warning({
                title: 'Browser Support',
                message: 'Geolocation is not supported by this browser.',
            });
        }

        const geocoder = L.Control.geocoder({
            query: '',
            placeholder: 'Search for a location',
            collapsed: false,
            expand: true,
            defaultMarkGeocode: false,
        }).addTo(mymap);

        geocoder.on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            const latitude = latlng.lat;
            const longitude = latlng.lng;

            updateMarker(latitude, longitude); // Gunakan fungsi updateMarker

            document.querySelector('.latitude').value = latitude;
            document.querySelector('.longitude').value = longitude;

            const addressInput = document.querySelector('.address');
            if (addressInput.value.trim() === '') {
                const nominatimUrl =
                    `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

                fetch(nominatimUrl)
                    .then((response) => response.json())
                    .then((data) => {

                        const address = data.display_name || 'Address not found';

                        document.querySelector('.address').value = address;
                    })
                    .catch((error) => {
                        console.error('Error fetching address:', error);
                        document.querySelector('.address').value = 'Address not found';
                    });
            }
        });


        // document.getElementById('locationSearch').addEventListener('input', function(e) {
        //     geocoder.query(e.target.value);
        // });

        $('#mapmodal').on('shown.bs.modal', function() {
            mymap.invalidateSize();
        });

        function pickmap() {
            document.querySelector('.latitude').value = latitude;
            document.querySelector('.longitude').value = longitude;

            const addressInput = document.querySelector('.address');
            if (addressInput.value.trim() === '') {
                const nominatimUrl =
                    `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

                fetch(nominatimUrl)
                    .then((response) => response.json())
                    .then((data) => {

                        const address = data.display_name || 'Address not found';

                        document.querySelector('.address').value = address;
                    })
                    .catch((error) => {
                        console.error('Error fetching address:', error);
                        document.querySelector('.address').value = 'Address not found';
                    });
            }

            $('#mapmodal').modal('hide');
        }
    </script>
@endsection
