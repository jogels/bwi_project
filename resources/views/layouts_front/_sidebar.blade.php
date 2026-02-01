<aside id="sidebar-wrapper" class="custom-scrollbar offcanvas-sidebar position-right">
    <button class="off-canvas-close"><i class="ti-close"></i></button>
    <div class="sidebar-inner">
        <ul class="main-menu d-none d-lg-flex justify-content-start">
            <li class="menu-item-has-children">
                <a href="{{ url('/') }}">HOME</a>
            </li>
            <li class="menu-item-has-children">
                <a><span class="mr-15"></span>PROFIL</a>
                <ul class="sub-menu text-muted font-small">
                    <li><a href="{{ url('/about') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('organization.structure') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ url('/vision-mission') }}">Visi & Misi</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a><span class="mr-15"></span>INFORMASI PUBLIK</a>
                <ul class="sub-menu text-muted font-small">
                    <li><a href="{{ url('/data-wakaf') }}">Data Tanah Wakaf</a></li>
                    <li><a href="{{ route('nadzirs.index') }}">Data Nazir</a></li>
                    <li><a href="https://www.bwi.go.id/literasiwakaf/">Literasi</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a><span class="mr-15"></span>Regulasi</a>
                <ul class="sub-menu text-muted font-small">
                    <li><a href="#">Undang-undang Wakaf</a></li>
                    <li><a href="#">Peraturan Pemerintahan</a></li>
                    <li><a href="#">Peraturan BWI</a></li>
                    <li><a href="#">Peraturan Mentri Agama</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a><span class="mr-15"></span>Wakaf Uang</a>
                 <li><a href="https://https://dki.bwi.go.id/">Literasi</a></li>

                <!-- <ul class="sub-menu text-muted font-small">
                    <li><a href="#">Undang-undang Wakaf</a></li>
                    <li><a href="#">Peraturan Pemerintahan</a></li>
                    <li><a href="#">Peraturan BWI</a></li>
                    <li><a href="#">Peraturan Mentri Agama</a></li>
                </ul> -->
            </li>
        </ul>
    </div>
</aside>

<!-- Main Header -->
<header class="main-header header-style-2 mb-40">
    <div class="header-bottom header-sticky text-center" style="background-color: #0F3525;">
        <div class="scroll-progress gradient-bg-1"></div>
        <div class="mobile_menu d-lg-none d-block"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3">
                    <div class="header-logo d-flex align-items-center">
                        <a href="{{ url('/') }}" class="d-flex align-items-center">
                            <img class="logo-img d-none d-lg-inline" src="{{ asset('assets/images/logo.png') }}"
                                alt="Logo" style="height: 45px; width: 45px; object-fit: contain;">
                            <img class="logo-img d-none d-md-inline d-lg-none"
                                src="{{ asset('assets/images/logo.png') }}" alt="Logo"
                                style="height: 45px; width: 45px; object-fit: contain;">
                            <img class="logo-img d-inline d-md-none" src="{{ asset('assets/images/logo.png') }}"
                                alt="Logo" style="height: 45px; width: 45px; object-fit: contain;">
                            <span class="ml-2 font-weight-bold text-light small" style="line-height: 1.2; text-align: left;">BWI Perwakilan DKI Jakarta</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-9 main-header-navigation">
                    <div class="main-nav d-flex justify-content-between align-items-center">
                    <ul class="mobi-menu d-none menu-3-columns" id="navigation">
                                    <li class="cat-item cat-item-2"><a href="{{ url('/') }}">HOME</a></li>
                                    <li class="cat-item cat-item-3"><a href="{{ url('/about') }}">Tentang Kami</a></li>
                                    <li class="cat-item cat-item-4"><a href="{{ route('organization.structure') }}">Struktur Organisasi</a></li>
                                    <li class="cat-item cat-item-5"><a href="{{ url('/vision-mission') }}">Visi & Misi</a></li>
                                    <li class="cat-item cat-item-6"><a href="{{ url('/data-wakaf') }}">Data Tanah Wakaf</a></li>
                                    <li class="cat-item cat-item-7"><a href="{{ route('nadzirs.index') }}">Data Nazir</a></li>
                                    <li class="cat-item cat-item-2"><a href="https://www.bwi.go.id/literasiwakaf/">Literasi</a></li>
                                    <li class="cat-item cat-item-3"><a href="{{ route('pdf.show', 'undang-undang-wakaf') }}">Undang-undang Wakaf</a></li>
                                    <li class="cat-item cat-item-4"><a href="{{ route('pdf.show', 'peraturan-pemerintah') }}">Peraturan Pemerintahan</a></li>
                                    <li class="cat-item cat-item-5"><a href="{{ route('pdf.show', 'peraturan-bwi') }}">Peraturan BWI</a></li>
                                    <li class="cat-item cat-item-6"><a href="{{ route('pdf.show', 'peraturan-mentri-agama') }}">Peraturan Mentri Agama</a></li>
                                </ul>
                        <nav class="flex-grow-1">

                            <ul class="main-menu d-none d-lg-flex justify-content-start">
                                <li class="menu-item-has-children">
                                    <a href="{{ url('/') }}">HOME</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a><span class="mr-15">
                                        </span>PROFIL</a>
                                    <ul class="sub-menu text-muted font-small">
                                        <li><a href="{{ url('/about') }}">Tentang Kami</a></li>
                                        <li><a href="{{ route('organization.structure') }}">Struktur Organisasi</a></li>
                                        <li><a href="{{ url('/vision-mission') }}">Visi & Misi</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a><span class="mr-15">
                                        </span>INFORMASI PUBLIK</a>
                                    <ul class="sub-menu text-muted font-small">
                                        <li><a href="{{ url('/data-wakaf') }}">Data Tanah Wakaf</a></li>
                                        <li><a href="{{ route('nadzirs.index') }}">Data Nazir</a></li>
                                        {{-- <li><a href="home-3.html">Formulir Pergantian / Penetapan Nazir</a></li> --}}
                                        <li><a href="https://www.bwi.go.id/literasiwakaf/">Literasi</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a><span class="mr-15">
                                        </span>Regulasi</a>
                                    <ul class="sub-menu text-muted font-small">
                                        <li><a href="{{ route('pdf.show', 'undang-undang-wakaf') }}">Undang-undang
                                                Wakaf</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-pemerintah') }}">Peraturan
                                                Pemerintahan</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-bwi') }}">Peraturan
                                                BWI</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-mentri-agama') }}">Peraturan
                                                Mentri Agama</a></li>
                                    </ul>
                                    
                                </li>
                                <li class="menu-item-has-children">
                                    <a><span class="mr-15">
                                        </span>Wakaf Uang</a>
                                    <!-- <ul class="sub-menu text-muted font-small">
                                        <li><a href="{{ route('pdf.show', 'undang-undang-wakaf') }}">Undang-undang
                                                Wakaf</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-pemerintah') }}">Peraturan
                                                Pemerintahan</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-bwi') }}">Peraturan
                                                BWI</a></li>
                                        <li><a href="{{ route('pdf.show', 'peraturan-mentri-agama') }}">Peraturan
                                                Mentri Agama</a></li>
                                    </ul> -->
                                    
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
