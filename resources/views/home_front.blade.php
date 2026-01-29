@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <!-- sidebar-left -->
            <div class="col-lg-2 col-md-3 primary-sidebar sticky-sidebar sidebar-left order-2 order-md-1">
                <!-- Widget Weather -->
                <div class="sidebar-widget widget-weather border-radius-10 bg-white mb-30 mt-55">
                    <div class="d-flex">
                        <div class="font-medium">
                            <p>{{ \Carbon\Carbon::now()->format('l') }}</p>
                            <h2>{{ \Carbon\Carbon::now()->format('d') }}</h2>
                            <p><strong>{{ \Carbon\Carbon::now()->format('F') }}</strong></p>
                        </div>
                        <div class="font-medium ml-10 ">
                            <div id="weather-widget" class="d-inline-block">
                                <!-- Weather data will be populated via JavaScript -->
                                <div class="loading">Loading weather data...</div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- main content -->
            <div class="col-lg-10 col-md-9 order-1 order-md-2">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <!-- Featured posts -->
                        <div class="featured-post mb-50">
                            <h4 class="widget-title mb-30">Highlight <span> Hari ini</span></h4>
                            <div class="featured-slider-1 border-radius-10">
                                @foreach ($data['highlights'] as $highlight)
                                    <div class="slider-single" style="padding: 15px;">
                                        <div
                                            class="img-hover-slide border-radius-15 mb-20 position-relative overflow-hidden">
                                            <a href="#">
                                                @if ($highlight->photo_url)
                                                    <img style="width: 100%" src="{{ asset($highlight->photo_url) }}"
                                                        alt="Post Photo" class="img-fluid">
                                                @else
                                                    <img style="width: 100%" src="{{ asset('assets/imgs/default.png') }}"
                                                        alt="Default Photo">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="p-15">
                                            <div class="entry-meta mb-20">
                                                <div class="float-right font-small">
                                                    <span><span class="mr-10 text-muted"><i
                                                                class="fa fa-clock"></i></span>{{ \Carbon\Carbon::parse($highlight->created_at)->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <h4 class="post-title mb-15">
                                                <a
                                                    href="{{ route('posts.show', $highlight->id) }}">{{ $highlight->title }}</a>
                                            </h4>
                                            <div
                                                class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                <span class="post-by">By <a
                                                        href="#">{{ $highlight->author_name }}</a></span>
                                                <span
                                                    class="post-on">{{ \Carbon\Carbon::parse($highlight->created_at)->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-12 sidebar-right">

                        <!--Post aside style 2-->
                        <div class="sidebar-widget">
                            <div class="widget-header mb-30">
                                <h5 class="widget-title">Trending <span>Hari ini</span></h5>
                            </div>
                            <div class="post-aside-style-2">
                                <ul class="list-post">
                                    @foreach ($data['trending'] as $trend)
                                        <li class="wow fadeIn animated">
                                            <div class="d-flex" style="margin-bottom: 5px;">
                                                <div class="post-thumb d-flex mr-15 border-radius-5 img-hover-scale">
                                                    <a href="#">
                                                        @if ($trend->photo_url)
                                                            <img style="width: 100%" src="{{ asset($trend->photo_url) }}"
                                                                alt="Post Photo" class="img-fluid">
                                                        @else
                                                            <img style="width: 100%"
                                                                src="{{ asset('assets/imgs/default.png') }}"
                                                                alt="Default Photo">
                                                        @endif
                                                    </a>

                                                </div>
                                                <div class="post-content media-body">
                                                    <h6 class="post-title mb-10 text-limit-2-row">
                                                        <a
                                                            href="{{ route('posts.show', $trend->id) }}">{{ $trend->title }}</a>
                                                    </h6>
                                                    <div
                                                        class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                        <span class="post-by">By <a
                                                                href="#">{{ $trend->author_name }}</a></span>
                                                        <span
                                                            class="post-on">{{ \Carbon\Carbon::parse($trend->created_at)->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tampilkan Banner, sebanyak yang ditemukan --}}
                <div class="row">
                    <div class="col-lg-8 col-md-12 text-center mt-50 mb-50">
                        <div id="adsCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner d-flex">
                                @foreach ($data['banners'] as $index => $banner)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img class="border-radius-10 w-100 h-200" src="{{ asset($banner->photo_url) }}"
                                            alt="Banner {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            {{-- Tambahkan kontrol navigasi carousel (opsional) --}}
                            <a class="carousel-control-prev" href="#adsCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Sebelumnya</span>
                            </a>
                            <a class="carousel-control-next" href="#adsCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Selanjutnya</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="latest-post mb-50">
                            <div class="widget-header position-relative mb-30">
                                <div class="row">
                                    <div class="col-7">
                                        <h4 class="widget-title mb-0">Terbaru <span>Artikel</span></h4>
                                    </div>
                                    <div class="col-5 text-right">
                                        {{-- <h6 class="font-medium pr-15">
                                            <a class="text-muted font-small" href="#">View all</a>
                                        </h6> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="loop-list-style-1">
                                @foreach ($data['posts'] as $post)
                                    <article
                                        class="first-post p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                        <div
                                            class="img-hover-slide border-radius-15 mb-30 position-relative overflow-hidden">
                                            @if ($post->photo_url)
                                                <img style="width: 100%" src="{{ asset($post->photo_url) }}"
                                                    alt="Post Photo" class="img-fluid">
                                            @else
                                                <img style="width: 100%" src="{{ asset('assets/imgs/default.png') }}"
                                                    alt="Default Photo">
                                            @endif
                                            {{-- <a href="{{ route('posts.show', $post->id) }}">
                                                <img style="width: 100%" src="{{ $post->image_url }}"
                                                    alt="{{ $post->title }}">
                                            </a> --}}
                                        </div>
                                        <div class="pr-10 pl-10">
                                            <div class="entry-meta mb-30">
                                                <div class="float-right font-small">
                                                </div>
                                            </div>
                                            <h4 class="post-title mb-20">

                                                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                            </h4>
                                            <div class="mb-20 overflow-hidden">
                                                <div
                                                    class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                                    <span class="post-by">By <a
                                                            href="#">{{ $post->author_name }}</a></span>
                                                    <span
                                                        class="post-on">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        @if ($data['posts']->hasPages())
                            <div class="pagination">
                                {{ $data['posts']->links() }}
                            </div>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/+6285776111187" class="float-whatsapp" target="_blank">
        <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/whatsapp.svg" alt="WhatsApp" />
        <span>Konsultasi Wakaf</span>
    </a>

    <style>
        .float-whatsapp {
            position: fixed;
            height: 48px;
            bottom: 40px;
            right: 40px;
            background-color: white;
            color: #4CAF50;
            border-radius: 24px;
            text-align: center;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 100;
            display: flex;
            align-items: center;
            padding: 0 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .float-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .float-whatsapp img {
            width: 24px;
            height: 24px;
            margin-right: 8px;
            filter: invert(0.4) sepia(1) saturate(5) hue-rotate(85deg);
        }

        .float-whatsapp span {
            font-weight: 500;
            white-space: nowrap;
        }
    </style>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Jakarta coordinates
        const latitude = -6.2088;
        const longitude = 106.8456;
        const weatherWidget = document.getElementById('weather-widget');

        async function getWeather() {
            try {
                const response = await fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m`
                );
                const data = await response.json();

                // Map weather codes to weather icons
                // Reference: https://open-meteo.com/en/docs#weathervariables
                const getWeatherIcon = (code) => {
                    if (code === 0) return 'wi-day-sunny';
                    if (code >= 1 && code <= 3) return 'wi-day-cloudy';
                    if (code >= 51 && code <= 67) return 'wi-rain';
                    if (code >= 71 && code <= 77) return 'wi-snow';
                    if (code >= 80 && code <= 82) return 'wi-showers';
                    if (code >= 95 && code <= 99) return 'wi-thunderstorm';
                    return 'wi-day-sunny'; // default
                };

                const weatherHTML = `
                <ul>
                    <li><span class="font-small">
                        <a class="text-primary" href="#">Jakarta</a><br>
                        <i class="wi ${getWeatherIcon(data.current.weather_code)} mr-5"></i>${Math.round(data.current.temperature_2m)}ºc
                    </span>
                    <p>Wind: ${data.current.wind_speed_10m} km/h</p></li>
                </ul>
            `;

                weatherWidget.innerHTML = weatherHTML;
            } catch (error) {
                console.error('Error fetching weather:', error);
                weatherWidget.innerHTML = '<p>Unable to load weather data</p>';
            }
        }

        getWeather();
        // Update weather every 30 minutes
        setInterval(getWeather, 30 * 60 * 1000);
    });
</script>
