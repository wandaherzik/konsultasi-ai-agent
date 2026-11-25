<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <h1 class="sitename">Sehatiku</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home<br></a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#services">Layanan</a></li>
            <li><a href="#gallery">Galeri</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li class="dropdown"><a href="#"><span>Sosial Media</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="https://www.instagram.com/puskesmas.tiku.promkes?igsh=MWJjN3BqMThuZzhmMg==">Instagram</a></li>
                <li><a href="https://www.facebook.com/share/1CFDrcnHyB/">Facebook</a></li>
              </ul>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
@auth

    @switch(auth()->user()->role)

        @case('pasien')
            <a class="cta-btn" href="{{ route('pasien.pasien.dashboard') }}">
                Dashboard
            </a>
            @break

        @case('admin')
            <a class="cta-btn" href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
            @break

        @case('dokter')
            <a class="cta-btn" href="{{ route('dokter.dashboard') }}">
                Dashboard
            </a>
            @break

        @case('kapus')
            <a class="cta-btn" href="{{ route('kapus.dashboard') }}">
                Dashboard
            </a>
            @break

    @endswitch

@else

    <a class="cta-btn" href="{{ route('login') }}">
        Daftar Sekarang
    </a>

@endauth

      </div>

    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="landing/assets/img/bg-web.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>Selamat Datang </h2>
          <p>Di Aplikasi Layanan Konsultasi Kesehatan online Sehatiku</p>
        </div>

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Apa itu Aplikasi Layanan Konsultasi Kesehatan?</h3>
              <p>
                Aplikasi Layanan Konsultasi Kesehatan hadir untuk memberikan kemudahan bagi masyarakat dalam memperoleh informasi dan melakukan konsultasi awal mengenai keluhan kesehatan.
              </p>
            </div>
          </div>

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center w-100">
              <div class="row gy-4">

                <div class="col-sm-6 d-flex align-items-stretch">
                  <div class="icon-box w-100" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>Konsultasi Online</h4>
                  </div>
                </div>

                <div class="col-sm-6 d-flex align-items-stretch">
                  <div class="icon-box w-100" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-people"></i>
                    <h4>Pendaftaran secara langsung</h4>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="landing/assets/img/doctors/169254733427.jpeg" alt="Puskesmas Tiku" class="img-fluid">
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>Tentang Puskesmas</h3>
            <p>
Pelopor munculnya Puskesmas adalah dua tokoh pergerakan Indonesia, yakni Johannes Leimena dan Abdoel Patah. Johannes Leimena pernah bekerja di RS Zending Imannuel, Bandung, pada 1930-an. Saat itu, Leimena menerapkan yang namanya Bandung Plan. Bandung Plan adalah sebuah sistem yang membuat sebuah klinik atau pusat kesehatan yang menjangkau kecamatan hingga pedesaan di Bandung. Konsep ini kemudian menjadi inspirasi bagi pemerintah Indonesia setelah merdeka demi memberikan layanan kesehatan bagi masyarakat.</p>
            <h4>Berdirinya Puskesmas</h4>
            <p>Setelah kemerdekaan Indonesia, Leimena dan Abdoel Patah memikirkan bagaimana pengobatan bisa dinikmati masyarakat hingga pelosok desa. Mereka berdua kemudian mencoba konsep Bandung Plan untuk diterapkan dalam sistem birokrasi kesehatan Indonesia.</p>
          </div>

        </div>

      </div>

    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="7" data-purecounter-duration="1" class="purecounter"></span>
              <p>Dokter</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-regular fa-hospital"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
              <p>Poli dan Klaster</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-flask"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
              <p>Jenis Layanan</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1" class="purecounter"></span>
              <p>Tenaga Kesehatan</p>
            </div>
          </div>

        </div>

      </div>

    </section>

    <!-- Services Section -->
    <section id="services" class="services section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Layanan</h2>
        <p>Daftar Layanan Di Puskesmas Tiku</p>
      </div>

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-baby"></i></div>
              <a href="#" class="stretched-link"><h3>PELAYANAN IBU DAN ANAK</h3></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-pills"></i></div>
              <a href="#" class="stretched-link"><h3>LAYANAN KEFARMASIAN</h3></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-apple-whole"></i></div>
              <a href="#" class="stretched-link"><h3>PELAYANAN GIZI</h3></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-syringe"></i></div>
              <a href="#" class="stretched-link"><h3>PELAYANAN IMUNISASI</h3></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-person-pregnant"></i></div>
              <a href="#" class="stretched-link"><h3>PELAYANAN PERSALINAN</h3></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
            <div class="service-item position-relative">
              <div class="icon"><i class="fa-solid fa-tooth"></i></div>
              <a href="#" class="stretched-link"><h3>KESEHATAN GIGI DAN MULUT</h3></a>
            </div>
          </div>

        </div>

      </div>

    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Galeri Kegiatan</h2>
      </div>

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-3">

          @foreach (['album2.jpg','album3.jpg','album4.jpg','album5.jpg','album6.jpg','album7.jpg','album8.jpg','album1.jpeg'] as $foto)
          <div class="col-lg-3 col-md-4 col-6">
            <div class="gallery-item">
              <a href="landing/assets/img/gallery/{{ $foto }}" class="glightbox" data-gallery="images-gallery">
                <img src="landing/assets/img/gallery/{{ $foto }}" alt="Kegiatan Puskesmas Tiku" class="img-fluid" loading="lazy">
              </a>
            </div>
          </div>
          @endforeach

        </div>

      </div>

    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
      </div>

      <div class="container mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7237481127627!2d99.9206332747318!3d-0.3944970353011396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd509c776add65f%3A0xa71a5cdbb9a40b8!2sPuskesmas%20Tiku!5e0!3m2!1sid!2sid!4v1786979627298!5m2!1sid!2sid" title="Lokasi Puskesmas Tiku" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Lokasi</h3>
                <p>KECAMATAN TANJUNG MUTIARA <br>Jln. Bundo Kanduang No. 1 Tiku. Telepon: 0751-699059</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Contact </h3>
                <p>08126778042</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>puskest1ku@gmail.com</p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section>

  </main>

  <footer class="site-foot">Sehatiku – Layanan Konsultasi Kesehatan Puskesmas Tiku</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="landing/assets/vendor/php-email-form/validate.js"></script>
  <script src="landing/assets/vendor/aos/aos.js"></script>
  <script src="landing/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="landing/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="landing/assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="landing/assets/js/main.js"></script>

</body>