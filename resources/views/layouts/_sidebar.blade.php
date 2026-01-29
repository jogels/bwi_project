<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
        <a class="navbar-brand brand-logo" href="{{ url('/home') }}">
            {{-- <img src="{{asset('assets/atonergi.png')}}" alt="logo" style="margin-left: auto;"> --}}
            <h6 style="margin:0; margin-left: 15px; color: #0F3525; white-space: normal; max-width: 200px; line-height: 1.2;">{{ config('app.name') }}</h6>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/home') }}">
            {{-- <img src="{{asset('assets/atonergi-mini.png')}}" alt="logo"/> --}}
            <h6 style="margin:0; margin-left: 15px; color: #0F3525; white-space: normal; max-width: 100px; line-height: 1.2;">{{ getsingkatan(config('app.name')) }}</h6>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-profile" id="profileDropdown" href="#"
                    data-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="{{asset('assets/image/faces1.jpg')}}" alt="image"> --}}
                    <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ url('logout') }}">
                        <i class="mdi mdi-logout mr-2 text-primary"></i>
                        Keluar
                    </a>
                </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block" title="Keluar">
                <a class="nav-link" href="{{ url('logout') }}">
                    <i class="mdi mdi-power"></i>
                </a>
            </li>
            <form id="logout-form" action="{{ url('logout') }}" method="post" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav" id="ayaysir">
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">
                        <span class="menu-title">Tampilan Langsung</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-desktop"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/users') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/users') }}">
                        <span class="menu-title">Manajemen Pengguna</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-user"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/postscontent') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/postscontent') }}">
                        <span class="menu-title">Manajemen Konten</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/banner') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/banner') }}">
                        <span class="menu-title">Manajemen Banner</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/cities') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/cities') }}">
                        <span class="menu-title">Kota</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/subdistricts') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/subdistricts') }}">
                        <span class="menu-title">Kecamatan</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/vilages') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/vilages') }}">
                        <span class="menu-title">Kelurahan</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <!-- <li class="nav-item {{ Request::is('/wakifs') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/wakifs') }}">
                        <span class="menu-title">Wakif</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('/nadzirs') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/nadzirs') }}">
                        <span class="menu-title">Nadzir</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li> -->

                <li class="nav-item {{ Request::is('/wakafland') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/wakafland') }}">
                        <span class="menu-title">Tanah Wakaf</span>
                        {{-- <span class="menu-sub-title">( 2 pembaruan baru )</span> --}}
                        <i class="fa fa-newspaper-o"></i>
                    </a>
                </li>

                <li
                    class="nav-item {{ (Request::is('profil') ? 'active' : '') || (Request::is('profil/*') ? 'active' : '') }}">
                    <a class="nav-link" data-toggle="collapse" href="#profil" aria-expanded="false"
                        aria-controls="ui-basic">
                        <span class="menu-title">Profil</span>
                        <span class="d-none">
                            Profil
                        </span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-account-search"></i>
                    </a>
                    <div class="collapse {{ (Request::is('profil') ? 'show' : '') || (Request::is('profil/*') ? 'show' : '') }}"
                        id="profil">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a
                                    class="nav-link {{ (Request::is('profil/visimisi') ? 'active' : '') || (Request::is('profil/visimisi/*') ? 'active' : '') }}"
                                    href="{{ url('profil/visimisi') }}">Visi Misi<span class="d-none">Visi
                                        Misi</span></a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </nav>
