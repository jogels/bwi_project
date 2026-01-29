@extends('front')

@section('content')
    <style>
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -18px;
        }

        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>

    <main>
        <iframe src="{{ asset($pdfUrl) }}#toolbar=1&navpanes=1&scrollbar=1" title="Undang-undang Wakaf"></iframe>
    </main>
@endsection
