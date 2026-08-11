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
            <div class="gallery-bento">
                {{-- Row 1: hero text + tall image --}}
                @if ($items->get(0))
                    <article class="bento-card bento-hero-text">
                        <div class="bento-card-inner">
                            <span class="bento-label">Featured</span>
                            <h2>{{ $items[0]->title }}</h2>
                            <p>{{ $items[0]->description }}</p>
                        </div>
                    </article>
                    <a href="{{ $items[0]->image }}" class="bento-card bento-hero-image" data-fancybox="gallery" data-caption="{{ $items[0]->title }}">
                        <img src="{{ $items[0]->image }}" alt="{{ $items[0]->title }}">
                    </a>
                @endif

                {{-- Row 2: cream text + image --}}
                @if ($items->get(1))
                    <article class="bento-card bento-split-text">
                        <div class="bento-card-inner">
                            <h3>{{ $items[1]->title }}</h3>
                            <p>{{ $items[1]->description }}</p>
                        </div>
                    </article>
                    <a href="{{ $items[1]->image }}" class="bento-card bento-split-image" data-fancybox="gallery" data-caption="{{ $items[1]->title }}">
                        <img src="{{ $items[1]->image }}" alt="{{ $items[1]->title }}">
                    </a>
                @endif

                {{-- Row 3: stacked images + large text --}}
                @if ($items->get(2) || $items->get(3))
                    <div class="bento-stack">
                        @if ($items->get(2))
                            <a href="{{ $items[2]->image }}" class="bento-card bento-stack-image" data-fancybox="gallery" data-caption="{{ $items[2]->title }}">
                                <img src="{{ $items[2]->image }}" alt="{{ $items[2]->title }}">
                                <div class="bento-image-caption">
                                    <strong>{{ $items[2]->title }}</strong>
                                </div>
                            </a>
                        @endif
                        @if ($items->get(3))
                            <a href="{{ $items[3]->image }}" class="bento-card bento-stack-image" data-fancybox="gallery" data-caption="{{ $items[3]->title }}">
                                <img src="{{ $items[3]->image }}" alt="{{ $items[3]->title }}">
                                <div class="bento-image-caption">
                                    <strong>{{ $items[3]->title }}</strong>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif

                @if ($items->get(4))
                    <article class="bento-card bento-large-text">
                        <div class="bento-card-inner">
                            <span class="bento-label dark">Galeri</span>
                            <h3>{{ $items[4]->title }}</h3>
                            <p>{{ $items[4]->description }}</p>
                        </div>
                    </article>
                @endif

                {{-- Row 4: remaining items --}}
                @if ($items->get(5))
                    <a href="{{ $items[5]->image }}" class="bento-card bento-wide-image" data-fancybox="gallery" data-caption="{{ $items[5]->title }}">
                        <img src="{{ $items[5]->image }}" alt="{{ $items[5]->title }}">
                        <div class="bento-overlay-text">
                            <h3>{{ $items[5]->title }}</h3>
                            <p>{{ $items[5]->description }}</p>
                        </div>
                    </a>
                @endif

                @foreach ($items->slice(6) as $item)
                    <a href="{{ $item->image }}" class="bento-card bento-extra" data-fancybox="gallery" data-caption="{{ $item->title }}">
                        <img src="{{ $item->image }}" alt="{{ $item->title }}">
                        <div class="bento-image-caption">
                            <strong>{{ $item->title }}</strong>
                            <span>{{ $item->description }}</span>
                        </div>
                    </a>
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
        --bento-green: #0F3525;
        --bento-green-soft: #1a4a35;
        --bento-cream: #F3EEE4;
        --bento-cream-deep: #E8E0D2;
        --bento-text: #1c1c1c;
        --bento-muted: #5c5c5c;
        --bento-radius: 22px;
        --bento-gap: 16px;
    }

    .gallery-bento-page {
        padding: 10px 0 70px;
    }

    .gallery-bento-intro {
        margin-bottom: 28px;
        max-width: 720px;
    }

    .gallery-bento-kicker {
        margin: 0 0 8px;
        color: var(--bento-green);
        font-size: 12px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .gallery-bento-heading {
        margin: 0 0 12px;
        color: var(--bento-green);
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 500;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }

    .gallery-bento-lead {
        margin: 0;
        color: var(--bento-muted);
        font-size: 1rem;
        line-height: 1.7;
    }

    .gallery-bento-empty {
        background: var(--bento-cream);
        border-radius: var(--bento-radius);
        padding: 48px 24px;
        text-align: center;
        color: var(--bento-muted);
    }

    .gallery-bento {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: var(--bento-gap);
        align-items: stretch;
    }

    .bento-card {
        position: relative;
        display: block;
        overflow: hidden;
        border-radius: var(--bento-radius);
        text-decoration: none;
        color: inherit;
        min-height: 220px;
    }

    .bento-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.45s ease;
    }

    .bento-card:hover img {
        transform: scale(1.04);
    }

    .bento-card-inner {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(24px, 4vw, 42px);
    }

    .bento-label {
        display: inline-block;
        margin-bottom: 14px;
        font-size: 11px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.75);
    }

    .bento-label.dark {
        color: var(--bento-green);
    }

    .bento-hero-text {
        grid-column: span 8;
        background: linear-gradient(145deg, var(--bento-green) 0%, var(--bento-green-soft) 100%);
        color: #fff;
        min-height: 360px;
    }

    .bento-hero-text h2 {
        margin: 0 0 16px;
        font-size: clamp(1.8rem, 3.5vw, 2.8rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #fff;
    }

    .bento-hero-text p {
        margin: 0;
        max-width: 34rem;
        font-size: 1rem;
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.88);
    }

    .bento-hero-image {
        grid-column: span 4;
        min-height: 360px;
    }

    .bento-split-text {
        grid-column: span 6;
        background: var(--bento-cream);
        color: var(--bento-text);
        min-height: 300px;
    }

    .bento-split-text h3,
    .bento-large-text h3 {
        margin: 0 0 14px;
        color: var(--bento-green);
        font-size: clamp(1.4rem, 2.4vw, 2rem);
        font-weight: 500;
        line-height: 1.25;
    }

    .bento-split-text p,
    .bento-large-text p {
        margin: 0;
        color: var(--bento-muted);
        font-size: 0.98rem;
        line-height: 1.75;
    }

    .bento-split-image {
        grid-column: span 6;
        min-height: 300px;
    }

    .bento-stack {
        grid-column: span 5;
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: var(--bento-gap);
        min-height: 420px;
    }

    .bento-stack-image {
        min-height: 0;
    }

    .bento-large-text {
        grid-column: span 7;
        background: var(--bento-cream);
        min-height: 420px;
    }

    .bento-wide-image {
        grid-column: span 12;
        min-height: 340px;
    }

    .bento-extra {
        grid-column: span 4;
        min-height: 280px;
    }

    .bento-image-caption,
    .bento-overlay-text {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 22px;
        background: linear-gradient(180deg, transparent 0%, rgba(15, 53, 37, 0.85) 100%);
        color: #fff;
    }

    .bento-image-caption strong,
    .bento-overlay-text h3 {
        display: block;
        margin: 0 0 4px;
        font-size: 1.05rem;
        font-weight: 600;
        color: #fff;
    }

    .bento-image-caption span,
    .bento-overlay-text p {
        display: block;
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
        color: rgba(255, 255, 255, 0.88);
    }

    .bento-overlay-text h3 {
        font-size: clamp(1.4rem, 2.5vw, 2rem);
        margin-bottom: 8px;
    }

    @media (max-width: 991px) {
        .bento-hero-text,
        .bento-hero-image,
        .bento-split-text,
        .bento-split-image,
        .bento-stack,
        .bento-large-text,
        .bento-wide-image,
        .bento-extra {
            grid-column: span 12;
            min-height: 260px;
        }

        .bento-stack {
            grid-template-rows: none;
            grid-template-columns: 1fr 1fr;
            min-height: 220px;
        }

        .bento-stack-image {
            min-height: 220px;
        }
    }

    @media (max-width: 575px) {
        .bento-stack {
            grid-template-columns: 1fr;
        }

        .gallery-bento-page {
            padding-bottom: 40px;
        }
    }
</style>
@endsection

@section('extra_script')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind('[data-fancybox="gallery"]');
        }
    });
</script>
@endsection
