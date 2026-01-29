<footer>
    <div class="footer-area pt-70 pb-50" style="background-color: #0F3525;">
        <div class="container">
            <!-- Main Footer Content -->
            <div class="row g-4">
                <!-- Brand Column -->
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="mb-4" style="max-width: 180px;">
                        <p class="text-light opacity-75 mb-4">Badan Wakaf Indonesia Perwakilan Provinsi DKI Jakarta dibentuk untuk mengembangkan dan memajukan perwakafan di Provinsi DKI Jakarta .</p>
                        <div class="social-links">
                            <!--<a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>-->
                            <a href="https://www.instagram.com/bwidkijakarta?igsh=MXZmM2hhcTIwZG94cw==" class="social-link"><i class="fab fa-instagram"></i></a>
                            <!--<a href="#" class="social-link"><i class="fab fa-youtube"></i></a>-->
                            <!--<a href="#" class="social-link"><i class="fab fa-twitter"></i></a>-->
                            <!--<a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>-->
                        </div>
                    </div>
                </div>

                <!-- Quick Links & Internal Links Combined -->
                <div class="col-lg-5 mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="footer-title">Quick Links</h5>
                            <ul class="footer-links">
                                <li><a href="https://www.bwi.go.id/literasiwakaf/">Literasi Wakaf</a></li>
                                <li><a href="#">News & Articles</a></li>
                                <li><a href="#">Berwakaf Yuk!</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="footer-title">Internal Links</h5>
                            <ul class="footer-links">
                                <li><a href="/about">Tentang Kami</a></li>
                                <li><a href="tel:02122406750">Kontak Kami</a></li>
                                <li><a href="/about">Tim Redaksi</a></li>
                                <!--<li><a href="#">LSP BWI</a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Column -->
                <div class="col-lg-3 mb-4">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <ul class="footer-contact">
                        <li>
                            <a href="https://www.google.com/maps/place/Badan+Wakaf+Indonesia+(BWI)+Perwakilan+Provinsi+DKI+Jakarta/@-6.1288961,106.8916436,13.71z" 
                               target="_blank" 
                               class="location-link">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. Kramat Jaya Raya, Tugu Utara, Kec. Koja, Jakarta Utara</span>
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>021-22406750</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>bwi@bwi.go.id</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="copyright-bar py-3" style="background-color: #0A2519;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <p class="text-light mb-0" style="font-size: 1.5rem;">&copy; {{ date('Y') }} Badan Wakaf Indonesia Perwakilan Provinsi DKI Jakarta 2025.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-title {
    color: white;
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: white;
}

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    display: flex;
    align-items: flex-start;
    color: rgba(255, 255, 255, 0.75);
    margin-bottom: 1rem;
}

.footer-contact i {
    margin-right: 0.75rem;
    margin-top: 0.25rem;
}

.location-link {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    display: flex;
    align-items: flex-start;
}

.location-link:hover {
    color: white;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 1.1rem;
}

.social-link:hover {
    color: white;
}
</style>
