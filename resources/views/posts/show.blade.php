@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 primary-sidebar sticky-sidebar sidebar-left order-2 order-md-1">
                <!-- Sidebar Widget (Weather) -->
                <div class="sidebar-widget widget-weather border-radius-10 bg-white mb-30 mt-55">
                    <div class="d-flex">
                        <div class="font-medium">
                            <p>{{ \Carbon\Carbon::now()->format('l') }}</p>
                            <h2>{{ \Carbon\Carbon::now()->format('d') }}</h2>
                            <p><strong>{{ \Carbon\Carbon::now()->format('F') }}</strong></p>
                        </div>
                        <div class="font-medium ml-10">
                            <div id="weather-widget" class="d-inline-block">
                                <!-- Weather data will be populated via JavaScript -->
                                <div class="loading">Loading weather data...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 order-1 order-md-2">
                <div class="row">
                    <!-- Post Detail -->
                    <div class="col-lg-8 col-md-12">
                        <div class="featured-post mb-50 bg-white border-radius-10 p-30">
                            <h4 class="widget-title mb-30">Post <span>Detail</span></h4>
                            <div class="post-detail">
                                <div class="img-hover-slide border-radius-15 mb-30 position-relative overflow-hidden">
                                    <a href="#">
                                        @if ($post->photo_url)
                                            <img style="width: 100%" src="{{ asset($post->photo_url) }}" alt="Post Photo"
                                                class="img-fluid">
                                        @else
                                            <img style="width: 100%" src="{{ asset('assets/imgs/default.png') }}"
                                                alt="Default Photo">
                                        @endif
                                    </a>
                                </div>
                                <div class="pr-10 pl-10">
                                    <div class="entry-meta mb-30">
                                        <div class="float-right font-small">
                                            <span>
                                                <span class="mr-10 text-muted"><i class="fa fa-clock"></i></span>
                                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="post-title mb-20">{{ $post->title }}</h4>
                                    <div class="entry-meta meta-1 font-x-small color-grey float-left text-uppercase">
                                        <span class="post-by">By <a href="#">{{ $post->author_name }}</a></span>
                                        <span
                                            class="post-on">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="post-body mt-40">
                                        {!! $post->body !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

        </div>
    </div>
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
