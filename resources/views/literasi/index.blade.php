@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Header -->
            <div class="col-12">
                <h1>Literasi</h1>
            </div>

            <!-- Main Content -->
            <div class="col-12">
                <div class="row">
                    @foreach ($postsByCategory as $category => $posts)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ $category }}</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        @foreach ($posts as $post)
                                            <li>
                                                <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if ($postsByCategory->isEmpty())
                <p class="text-center">Tidak ada postingan selain kategori "artikel".</p>
            @endif
        </div>
    </div>
@endsection
