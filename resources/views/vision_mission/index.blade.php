@extends('front')

@section('content')
    <div class="container">
        <div class="row">
            <!-- main content -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="">
                        <div class="latest-post mb-50">
                            <div class="widget-header position-relative mb-30">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="widget-title mb-0">Visi & <span>Misi</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="loop-list-style-1">
                                <article class="p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                    <div class="post-thumb d-flex mb-15 border-radius-10 img-hover-scale w-100" style="height: 300px; overflow: hidden;">
                                        <img class="border-radius-10 w-100 h-100" style="object-fit: cover; object-position: center;"
                                            src="{{ asset($data->photo_url ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') }}"
                                            alt="Vision & Mission">
                                    </div>
                                </article>

                                <article class="p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                    <div class="pr-10 pl-10">
                                        <h5 class="post-title mb-15">Our Vision</h5>
                                        <div class="entry-meta meta-1 font-x-small color-grey float-left">
                                            <!--<p>{{ $data->vision ?? 'No vision data available' }}</p>-->
                                            <p>"Terwujudnya lembaga independen yang di percaya masyarakat, mempunyai kemampuan dan integritas untuk mengembangkan perwakafan nasional dan internasional "</p>

                                        </div>
                                    </div>
                                </article>

                                <article class="p-10 background-white border-radius-10 mb-30 wow fadeIn animated">
                                    <div class="pr-10 pl-10">
                                        <h5 class="post-title mb-15">Our Mission</h5>
                                        <div class="entry-meta meta-1 font-x-small color-grey float-left">
                                            <!--<p>{{ $data->mission ?? 'No mission data available' }}</p>-->
                                            <p>"Menjadikan Badan Wakaf Indonesia sebagai lembaga profesional yang mampu mewujudkan potensi dan manfaat ekonomi harta benda walaf untuk kepentingan ibadah dan pemberdayaan"</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
