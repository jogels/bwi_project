@extends('front')

@section('content')
@php
    $items = $galleries->values();
@endphp

<section class="gallery-bento-page">
    <div class="container">
        <div class="gallery-bento-intro">
            <p class="gallery-bento-kicker">BWI Perwakilan DKI Jakarta</p>
            <h1 class="gallery-bento-heading">Galeri Kegiatan</h1>
            <p class="gallery-bento-lead">Dokumentasi kegiatan, literasi, dan pengelolaan wakaf di wilayah DKI Jakarta.</p>
        </div>

        @if ($items->isEmpty())
            <div class="gallery-bento-empty">
                <p>Belum ada data galeri.</p>
            </div>
        @else
            <div class="gallery-render">
                @php $carouselBuffer = collect(); @endphp

                @foreach ($items as $index => $item)
                    @php
                        $style = $item->style ?? 'foto';
                        $next = $items->get($index + 1);
                        $nextStyle = $next->style ?? null;
                    @endphp

                    @if ($style === 'carousel')
                        @php $carouselBuffer->push($item); @endphp

                        @if ($nextStyle !== 'carousel')
                            <div class="gallery-carousel-grid">
                                @foreach ($carouselBuffer as $carouselItem)
                                    <a href="{{ $carouselItem->image }}"
                                       class="gallery-carousel-item"
                                       @if($carouselItem->image) data-fancybox="gallery-carousel" @endif
                                       data-caption="{{ $carouselItem->title }}">
                                        @if ($carouselItem->image)
                                            <img src="{{ $carouselItem->image }}" alt="{{ $carouselItem->title }}">
                                        @endif
                                        <div class="gallery-carousel-caption">
                                            <strong>{{ $carouselItem->title }}</strong>
                                            @if ($carouselItem->description)
                                                <span>{{ $carouselItem->description }}</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            @php $carouselBuffer = collect(); @endphp
                        @endif

                    @elseif ($style === 'foto_deskripsi')
                        @php $photoLeft = ($item->photo_position ?? 'kanan') === 'kiri'; @endphp
                        <div class="gallery-split {{ $photoLeft ? 'photo-left' : 'photo-right' }}">
                            <article class="gallery-split-text">
                                <div class="gallery-split-inner">
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </article>
                            <a href="{{ $item->image }}"
                               class="gallery-split-photo"
                               @if($item->image) data-fancybox="gallery-split" @endif
                               data-caption="{{ $item->title }}">
                                @if ($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                @endif
                            </a>
                        </div>

                    @else
                        {{-- style: foto (full width) --}}
                        <a href="{{ $item->image }}"
                           class="gallery-full"
                           @if($item->image) data-fancybox="gallery-full" @endif
                           data-caption="{{ $item->title }}">
                            @if ($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->title }}">
                            @endif
                            <div class="gallery-full-caption">
                                <h3>{{ $item->title }}</h3>
                                @if ($item->description)
                                    <p>{{ $item->description }}</p>
                                @endif
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

@section('extra_style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>
    :root {
        --g-green: #0F3525;
        --g-cream: #F3EEE4;
        --g-text: #1c1c1c;
        --g-muted: #5c5c5c;
        --g-radius: 22px;
        --g-gap: 16px;
    }

    .gallery-bento-page { padding: 10px 0 70px; }

    .gallery-bento-intro { margin-bottom: 28px; max-width: 720px; }
    .gallery-bento-kicker {
        margin: 0 0 8px; color: var(--g-green); font-size: 12px;
        letter-spacing: 0.14em; text-transform: uppercase; font-weight: 600;
    }
    .gallery-bento-heading {
        margin: 0 0 12px; color: var(--g-green);
        font-size: clamp(2rem, 4vw, 3rem); font-weight: 500; line-height: 1.15;
    }
    .gallery-bento-lead { margin: 0; color: var(--g-muted); font-size: 1rem; line-height: 1.7; }

    .gallery-bento-empty {
        background: var(--g-cream); border-radius: var(--g-radius);
        padding: 48px 24px; text-align: center; color: var(--g-muted);
    }

    .gallery-render {
        display: flex;
        flex-direction: column;
        gap: var(--g-gap);
    }

    /* Style: foto (full width, landscape rectangle) */
    .gallery-full {
        position: relative;
        display: block;
        width: 100%;
        height: 320px;
        max-height: 320px;
        border-radius: var(--g-radius);
        overflow: hidden;
        text-decoration: none;
        color: #fff;
        background: #d7d1c5;
    }
    .gallery-full img {
        width: 100%;
        height: 100%;
        max-height: 320px;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform .4s ease;
    }
    .gallery-full:hover img { transform: scale(1.03); }
    .gallery-full-caption {
        position: absolute; left: 0; right: 0; bottom: 0;
        padding: 28px 24px;
        background: linear-gradient(180deg, transparent 0%, rgba(15,53,37,.88) 100%);
    }
    .gallery-full-caption h3 {
        margin: 0 0 8px; color: #fff;
        font-size: clamp(1.4rem, 2.5vw, 2rem); font-weight: 600;
    }
    .gallery-full-caption p {
        margin: 0; color: rgba(255,255,255,.9); font-size: .98rem; line-height: 1.6;
        max-width: 48rem;
    }

    /* Style: foto+Deskripsi (persegi) */
    .gallery-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--g-gap);
        align-items: stretch;
    }
    .gallery-split.photo-left .gallery-split-photo { order: 1; }
    .gallery-split.photo-left .gallery-split-text { order: 2; }
    .gallery-split.photo-right .gallery-split-text { order: 1; }
    .gallery-split.photo-right .gallery-split-photo { order: 2; }

    .gallery-split-text {
        background: var(--g-cream);
        border-radius: var(--g-radius);
        aspect-ratio: 1 / 1;
        width: 100%;
    }
    .gallery-split-inner {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(24px, 4vw, 42px);
    }
    .gallery-split-inner h3 {
        margin: 0 0 14px; color: var(--g-green);
        font-size: clamp(1.4rem, 2.4vw, 2rem); font-weight: 500; line-height: 1.25;
    }
    .gallery-split-inner p {
        margin: 0; color: var(--g-muted); font-size: .98rem; line-height: 1.75;
    }
    .gallery-split-photo {
        display: block;
        border-radius: var(--g-radius);
        overflow: hidden;
        aspect-ratio: 1 / 1;
        width: 100%;
        background: #d7d1c5;
        text-decoration: none;
    }
    .gallery-split-photo img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
        transition: transform .4s ease;
    }
    .gallery-split-photo:hover img { transform: scale(1.03); }

    /* Style: Carousel grid 3 per row (persegi) */
    .gallery-carousel-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--g-gap);
    }
    .gallery-carousel-item {
        position: relative;
        display: block;
        border-radius: var(--g-radius);
        overflow: hidden;
        aspect-ratio: 1 / 1;
        width: 100%;
        background: #d7d1c5;
        text-decoration: none;
        color: #fff;
    }
    .gallery-carousel-item img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
        transition: transform .4s ease;
    }
    .gallery-carousel-item:hover img { transform: scale(1.04); }
    .gallery-carousel-caption {
        position: absolute; left: 0; right: 0; bottom: 0;
        padding: 18px;
        background: linear-gradient(180deg, transparent 0%, rgba(15,53,37,.85) 100%);
    }
    .gallery-carousel-caption strong {
        display: block; margin-bottom: 4px; font-size: 1rem; color: #fff;
    }
    .gallery-carousel-caption span {
        display: block; font-size: .88rem; color: rgba(255,255,255,.88); line-height: 1.45;
    }

    @media (max-width: 991px) {
        .gallery-split { grid-template-columns: 1fr; }
        .gallery-split-text,
        .gallery-split-photo {
            aspect-ratio: 1 / 1;
            max-width: 420px;
            margin: 0 auto;
        }
        .gallery-split.photo-left .gallery-split-photo,
        .gallery-split.photo-left .gallery-split-text,
        .gallery-split.photo-right .gallery-split-text,
        .gallery-split.photo-right .gallery-split-photo { order: initial; }
        .gallery-carousel-grid { grid-template-columns: repeat(2, 1fr); }
        .gallery-full, .gallery-full img {
            height: 260px;
            max-height: 260px;
        }
    }

    @media (max-width: 575px) {
        .gallery-carousel-grid { grid-template-columns: 1fr; }
        .gallery-bento-page { padding-bottom: 40px; }
        .gallery-full, .gallery-full img {
            height: 220px;
            max-height: 220px;
        }
    }
</style>
@endsection

@section('extra_script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind('[data-fancybox]');
        }
    });
</script>
@endsection
