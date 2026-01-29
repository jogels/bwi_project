@extends('front')

@section('content')

      <div class="container">
                <div class="entry-header entry-header-2 mb-50 mt-50 text-center">
                    <div class="thumb-overlay img-hover-slide border-radius-5 position-relative" style="background-image: url( {{ url('/' . $data->url) }})">
                       
                    </div>
                </div>
                <!--end entry header-->
                <div class="row mb-50">
                    <div class="col-lg-8 col-md-12">
                        <div class="entry-main-content mt-50">
                            <h3>Visi</h3>
                            <p>{{ $data->vision }} </p>
                        </div>

                        <div class="entry-main-content mt-50">
                            <h3>Misi</h3>
                            <p>{{ $data->mission }} </p>
                        </div>
                    </div>
                </div>
                <!--End row-->
                <div class="row">
                    <div class="col-12 text-center mb-50">
                        <a href="#">
                            <img class="d-inline border-radius-10" src="assets/imgs/ads.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>

@endsection

@section('extra_script')
  <script>
  </script>
@endsection
