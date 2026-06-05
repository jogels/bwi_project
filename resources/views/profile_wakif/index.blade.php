@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-radius-10 bg-white mb-30 mt-30">
                    <div class="card-header" style="background-color: #0F3525;">
                        <h4 class="widget-title text-white mb-0">Profile <span class="text-white">Wakaf</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Main Profile Info -->
                                <div class="profile-details p-20">
                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Peruntukan Tanah Wakaf Sesuai AIW</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['peruntukan'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Provinsi</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['provinsi'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Kabupaten/Kota</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['kabupaten'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Kecamatan</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['kecamatan'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Kelurahan</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['kelurahan'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted text-end">Alamat</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px; text-align: right;">{{ $data['wakaf_info']['alamat'] }}</strong>
                                    </div>

                                    <div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">
                                        <span class="text-muted">Luas Tanah</span>
                                        <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['luas_tanah'] }}
                                            M<sup>2</sup></strong>
                                    </div>

                                    <!--<div class="detail-item mb-15 d-flex justify-content-between border-bottom pb-15">-->
                                    <!--    <span class="text-muted">Luas Bangunan</span>-->
                                    <!--    <strong class="text-end ms-3" style="color: #0F3525; max-width: 300px;">{{ $data['wakaf_info']['luas_bangunan'] }}-->
                                    <!--        M<sup>2</sup></strong>-->
                                    <!--</div>-->
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Additional Info Card -->
                                <div class="card border-radius-10 border-primary mb-30">
                                    <div class="card-body">
                                        <h5 class="mb-20" style="color: #0F3525;">Informasi Wakaf</h5>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">Nama Wakif</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['nama_wakif'] }}</strong>
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">Nama Nazhir</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['nama_nazhir'] }}</strong>
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">Status</label>
                                            @if (isset($data['wakif_info']['no_sertifikat']))
                                                <span class="badge badge-primary d-block text-end" style="background-color: #0F3525;">Sudah Sertifikat</span>
                                            @else
                                                <span class="badge badge-warning d-block text-end">Belum Sertifikat</span>
                                            @endif
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">No. Sertifikat</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['no_sertifikat'] }}</strong>
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">Tanggal Sertifikat</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['tanggal_sertifikat'] }}</strong>
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">No. AIW</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['no_aiw'] }}</strong>
                                        </div>

                                        <div class="info-item mb-15">
                                            <label class="text-muted d-block mb-2">Tanggal AIW</label>
                                            <strong class="d-block text-end" style="color: #0F3525;">{{ $data['wakif_info']['tanggal_aiw'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="col-lg-6">
                <div class="card border-radius-10 bg-white mb-30">
                    <div class="card-header" style="background-color: #0F3525;">
                        <h4 class="widget-title text-white mb-0">Galeri Foto</h4>
                    </div>
                    <div class="card-body">
                        @if (isset($data['gallery']) && count($data['gallery']) > 0)
                            <div class="row gallery-container">
                                @foreach ($data['gallery'] as $photo)
                                    <div class="col-md-4 mb-3">
                                        <div class="gallery-item">
                                            <a href="{{ asset($photo['url']) }}" data-fancybox="gallery">
                                                <img src="{{ asset($photo['url']) }}" class="img-fluid border-radius-10"
                                                    alt="Foto Wakaf">
                                            </a>
                                            <small class="d-block mt-2 text-center" style="color: #0F3525;">
                                                {{ \Carbon\Carbon::parse($photo['date'])->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-image-multiple text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-2">Tidak ada foto tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="col-lg-6">
                <div class="card border-radius-10 bg-white mb-30">
                    <div class="card-header" style="background-color: #0F3525;">
                        <h4 class="widget-title text-white mb-0">Lokasi Wakaf</h4>
                    </div>
                    <div class="card-body p-0">
                        @if (isset($data['location']) && isset($data['location']['latitude']) && isset($data['location']['longitude']))
                            <div class="p-3">
                                <small class="text-muted">
                                    <i class="mdi mdi-map-marker" style="color: #0F3525;"></i>
                                    {{ $data['wakaf_info']['alamat'] }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-map-marker-off text-muted" style="font-size: 48px;"></i>
                                <p class="text-muted mt-2">Lokasi tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if (isset($data['location']) && isset($data['location']['latitude']) && isset($data['location']['longitude']))
                <div class="card border-radius-10 bg-white mb-30">
                    <div class="card-header" style="background-color: #0F3525;">
                        <h4 class="widget-title text-white mb-0">Maps Lokasi</h4>
                    </div>
                    <div class="card-body p-0">
                        <div id="map" class="border-radius-10"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('extra_style')
    <style>
        :root {
            --primary-color: #0F3525;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border: 2px solid var(--primary-color) !important;
        }

        .badge-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .profile-details .detail-item:last-child {
            border-bottom: none !important;
        }

        .detail-item {
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background-color: rgba(33, 150, 243, 0.05);
        }

        .card {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .border-radius-10 {
            border-radius: 10px;
        }

        .widget-title span {
            font-weight: 300;
        }

        /* Gallery Styles */
        .gallery-item {
            transition: all 0.3s ease;
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(33, 150, 243, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover::after {
            opacity: 1;
        }

        #map,
        #map .leaflet-container {
            height: 400px;
            min-height: 400px;
            width: 100%;
            z-index: 1;
            border-radius: 10px;
        }

        .leaflet-container {
            background-color: #ddd;
            z-index: 1;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
@endsection

@section('extra_script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (isset($data['location']) && isset($data['location']['latitude']) && isset($data['location']['longitude']))
            var lat = {{ (float) $data['location']['latitude'] }};
            var lng = {{ (float) $data['location']['longitude'] }};
            var zoom = {{ (int) ($data['location']['zoom'] ?? 15) }};
            var map = null;

            function initWakafMap() {
                var mapEl = document.getElementById('map');
                if (!mapEl || map) {
                    return;
                }

                map = L.map('map', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView([lat, lng], zoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    subdomains: ['a', 'b', 'c'],
                    maxZoom: 19,
                    minZoom: 2
                }).addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup(
                        '<div class="text-center">' +
                        '<strong class="d-block mb-1">{{ addslashes($data['wakaf_info']['peruntukan']) }}</strong>' +
                        '<small>{{ addslashes($data['wakaf_info']['alamat']) }}</small>' +
                        '</div>'
                    )
                    .openPopup();

                map.whenReady(function() {
                    map.invalidateSize();
                });
            }

            window.addEventListener('load', function() {
                setTimeout(initWakafMap, 500);
            });

            window.addEventListener('resize', function() {
                if (map) {
                    map.invalidateSize();
                }
            });
            @endif

            if (typeof Fancybox !== 'undefined') {
                Fancybox.bind('[data-fancybox]', {
                    Toolbar: {
                        display: [
                            { id: 'prev', position: 'center' },
                            { id: 'counter', position: 'center' },
                            { id: 'next', position: 'center' },
                            'zoom',
                            'slideshow',
                            'fullscreen',
                            'close',
                        ],
                    },
                    Image: {
                        transition: 'slide',
                    },
                });
            }
        });
    </script>
@endsection
