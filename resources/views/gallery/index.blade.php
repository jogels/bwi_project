@extends('front')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-50">
                <div class="widget-header position-relative mb-30 pl-10 pr-10">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="widget-title mb-0">Galeri <span>Kegiatan</span></h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse ($galleries as $item)
                        <div class="col-lg-4 col-md-6 mb-30">
                            <article class="background-white border-radius-10 h-100">
                                <div class="gallery-thumb border-radius-10 overflow-hidden" style="height: 220px;">
                                    <a href="{{ $item->image }}" data-fancybox="gallery" data-caption="{{ $item->title }}">
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                            class="w-100 h-100" style="object-fit: cover;">
                                    </a>
                                </div>
                                <div class="p-20">
                                    <h5 class="mb-10" style="color: #0F3525;">{{ $item->title }}</h5>
                                    <p class="color-grey mb-0" style="font-size: 14px; line-height: 1.6;">
                                        {{ $item->description }}
                                    </p>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="background-white border-radius-10 p-40 text-center">
                                <p class="color-grey mb-0">Belum ada data galeri.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
<style>
    .gallery-thumb img {
        transition: transform 0.3s ease;
    }

    .gallery-thumb:hover img {
        transform: scale(1.05);
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
