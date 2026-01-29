@extends('main')

@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12 stretch-card grid-margin">
                    <div class="card bg-gradient-info text-white">
                        <div class="card-body" align="center">
                            <h4 class="font-weight-normal mb-3"></h4>
                            <h2 class="font-weight-normal mb-5" id="online">Selamat Datang,
                                {{ Auth::user()->full_name }}</h2>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript"></script>
@endsection
