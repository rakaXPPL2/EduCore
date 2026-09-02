<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 1 Garut - Motekar Wibawa Mukti</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --blue: #1E90D6; --blue-dark: #0D6EBD; --blue-deep: #0A4F8F; --blue-light: #E8F4FD; --blue-mid: #B3DCEF; --sky: #38A9E4; --white: #FFFFFF; --gray50: #F7FBFF; --gray600: #4A6580; --gray800: #1A3048; --navy: #0B2A45; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: "Poppins", sans-serif; color: var(--gray800); line-height: 1.5; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f0f7ff; }
        ::-webkit-scrollbar-thumb { background: var(--sky); border-radius: 3px; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        .icon { display: inline-block; vertical-align: middle; }
        .btn-primary { background: linear-gradient(135deg, var(--blue), var(--blue-deep)); color: white; padding: 0.875rem 1.75rem; border-radius: 9999px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-block; box-shadow: 0 6px 24px rgba(30,144,214,0.27); transition: transform 0.2s; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline { border: 2px solid var(--blue); color: var(--blue); padding: 0.875rem 1.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; background: white; transition: transform 0.2s; }
        .btn-outline:hover { transform: translateY(-2px); }
        .text-heading { font-family: "Playfair Display", Georgia, serif; }
        .text-blue { color: var(--blue); }
        .text-navy { color: var(--navy); }
        .text-gray { color: var(--gray600); }
        .bg-blue-light { background: var(--blue-light); }
        .bg-gray-50 { background: var(--gray50); }
        .bg-navy { background: var(--navy); }
        .bg-blue-deep { background: linear-gradient(135deg, var(--blue-deep), var(--blue)); }
        .py-section { padding-top: 6rem; padding-bottom: 6rem; }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }
        .font-black { font-weight: 900; }
        .tracking-wide { letter-spacing: 0.05em; }
        .uppercase { text-transform: uppercase; }
        .grid { display: grid; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-10 { margin-top: 2.5rem; }
        .p-4 { padding: 1rem; }
        .p-5 { padding: 1.25rem; }
        .p-6 { padding: 1.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-full { border-radius: 9999px; }
        .overflow-hidden { overflow: hidden; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .object-cover { object-fit: cover; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .leading-relaxed { line-height: 1.625; }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        @media (min-width: 768px) { .md-flex { display: flex; } }
        @media (min-width: 1024px) { .lg-grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); } .lg-grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
        .navbar { position: sticky; top: 0; z-index: 50; background: white; border-bottom: 1px solid var(--blue-mid); box-shadow: 0 2px 20px rgba(30,144,214,0.10); }
        .nav-link { color: var(--gray600); padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; font-size: 0.875rem; transition: all 0.2s; }
        .nav-link:hover { color: var(--blue); background: var(--blue-light); }
        .card { background: white; border-radius: 1rem; border: 1px solid var(--blue-mid); box-shadow: 0 2px 12px rgba(30,144,214,0.06); padding: 1.5rem; transition: all 0.3s; }
        .card:hover { border-color: var(--blue); box-shadow: 0 16px 40px rgba(30,144,214,0.15); transform: translateY(-4px); }
        .hero { background: linear-gradient(160deg, var(--blue-light) 0%, #fff 55%); position: relative; overflow: hidden; }
        .hero-circle { position: absolute; border-radius: 50%; opacity: 0.07; }
        .stat-item { text-align: center; padding: 2rem 1rem; }
        .stat-value { color: white; font-weight: 900; font-size: 1.875rem; font-family: "Playfair Display", serif; }
        .stat-label { color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem; }
        .jurusan-icon { width: 3.5rem; height: 3.5rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; }
        .jurusan-badge { font-size: 0.625rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; padding: 0.25rem 0.625rem; border-radius: 9999px; display: inline-block; margin-bottom: 0.75rem; }
        .section-tag { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; color: var(--blue); }
        .section-title { font-family: "Playfair Display", serif; font-weight: 900; line-height: 1.1; margin-bottom: 1rem; font-size: clamp(1.8rem, 4vw, 2.5rem); color: var(--navy); }
        .keunggulan-card { padding: 1.5rem; border-radius: 1rem; text-align: center; background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.18); backdrop-filter: blur(6px); transition: transform 0.2s; }
        .keunggulan-card:hover { transform: translateY(-4px); }
        .keunggulan-icon { width: 4rem; height: 4rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; }
        footer { background: var(--navy); }
        footer a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
        footer a:hover { color: var(--sky); }
        @media (max-width: 768px) { .desktop-nav { display: none; } .mobile-toggle { display: block; } }
        @media (min-width: 769px) { .mobile-toggle { display: none; } }
    </style>
</head>
<body>
    <!-- TOP STRIP -->
    <div style="background: var(--blue-deep);" class="py-1.5 px-4 text-center">
        <p class="text-white text-xs tracking-wide">
            <svg class="icon w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"/></svg>
            PPDB 2025/2026 Sudah Dibuka - Daftar sekarang via portal PPDB Jawa Barat
        </p>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container flex items-center justify-between" style="height: 4rem;">
            <a href="#beranda" class="flex items-center gap-3" style="text-decoration: none;">
                <img src="/images/image-2.png" alt="Logo SMKN 1 Garut" style="height: 2.75rem; width: 2.75rem; object-fit: contain;">
                <div style="line-height: 1.2;">
                    <div class="font-black text-base" style="font-family: Playfair Display, serif; color: var(--blue-deep);">SMKN 1 Garut</div>
                    <div class="text-xs tracking-widest uppercase" style="color: var(--sky);">Motekar Wibawa Mukti</div>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="desktop-nav flex items-center gap-1">
                <a href="#beranda" class="nav-link">Beranda</a>
                <a href="#tentang" class="nav-link">Tentang</a>
                <a href="#jurusan" class="nav-link">Jurusan</a>
                <a href="#galeri" class="nav-link">Galeri</a>
                <a href="#ppdb" class="nav-link">PPDB</a>
                <a href="#kontak" class="nav-link">Kontak</a>
                <a href="#ppdb" class="btn-primary" style="margin-left: 1rem;">Daftar PPDB</a>
            </div>

            <!-- Mobile Toggle -->
            <button class="mobile-toggle p-2 rounded-lg" style="color: var(--blue); background: none; border: none; cursor: pointer;" onclick="toggleMenu()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Nav -->
        <div id="mobileNav" class="mobile-nav" style="display: none;">
            <a href="#beranda" class="nav-link block py-3 text-sm font-medium" style="border-bottom: 1px solid var(--blue-light);">Beranda</a>
            <a href="#tentang" class="nav-link block py-3 text-sm font-medium" style="border-bottom: 1px solid var(--blue-light);">Tentang</a>
            <a href="#jurusan" class="nav-link block py-3 text-sm font-medium" style="border-bottom: 1px solid var(--blue-light);">Jurusan</a>
            <a href="#galeri" class="nav-link block py-3 text-sm font-medium" style="border-bottom: 1px solid var(--blue-light);">Galeri</a>
            <a href="#ppdb" class="nav-link block py-3 text-sm font-medium" style="border-bottom: 1px solid var(--blue-light);">PPDB</a>
            <a href="#kontak" class="nav-link block py-3 text-sm font-medium">Kontak</a>
            <a href="#ppdb" class="btn-primary mt-4 block text-center">Daftar PPDB</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="hero" style="padding-top: 4rem; padding-bottom: 4rem;">
        <div class="hero-circle" style="background: var(--blue); width: 500px; height: 500px; top: -6rem; right: -6rem;"></div>
        <div class="hero-circle" style="background: var(--sky); width: 288px; height: 288px; top: 10rem; right: -2.5rem;"></div>
        <div class="hero-circle" style="background: var(--blue); width: 224px; height: 224px; bottom: -4rem; left: 2rem;"></div>

        <div class="container" style="padding-top: 4rem; padding-bottom: 6rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                <div class="relative" style="z-index: 1;">
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; margin-bottom: 1.5rem; background: var(--blue-light); color: var(--blue-dark); border: 1px solid var(--blue-mid);">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--blue); display: inline-block;"></span>
                        Sekolah Menengah Kejuruan Negeri - Garut, Jawa Barat
                    </div>

                    <h1 class="font-black leading-tight mb-6" style="font-family: Playfair Display, serif; font-size: clamp(2.8rem, 5vw, 4.2rem); color: var(--navy);">
                        Raih Masa Depan<br>Bersama <span style="color: var(--blue);">SMKN 1<br>Garut</span>
                    </h1>

                    <p class="text-base leading-relaxed mb-3" style="color: var(--gray600); max-width: 460px;">
                        Mencetak generasi terampil, berkarakter, dan berdaya saing global dengan <strong style="color: var(--blue-deep);">8 Kompetensi Keahlian</strong> unggulan sejak 1951.
                    </p>
                    <p class="text-sm italic font-medium mb-10" style="color: var(--sky);">"Motekar Wibawa Mukti"</p>

                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                        <a href="#ppdb" class="btn-primary">Daftar PPDB 2025/2026</a>
                        <a href="#jurusan" class="btn-outline">Lihat Jurusan</a>
                    </div>

                    <div class="mt-10 flex flex-wrap gap-6">
                        <div><div class="font-black text-2xl" style="font-family: Playfair Display, serif; color: var(--blue);">1951</div><div class="text-xs mt-1" style="color: var(--gray600);">Tahun Berdiri</div></div>
                        <div><div class="font-black text-2xl" style="font-family: Playfair Display, serif; color: var(--blue);">8</div><div class="text-xs mt-1" style="color: var(--gray600);">Jurusan</div></div>
                        <div><div class="font-black text-2xl" style="font-family: Playfair Display, serif; color: var(--blue);">2.400+</div><div class="text-xs mt-1" style="color: var(--gray600);">Siswa</div></div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div style="position: absolute; top: -1rem; left: -1rem; width: 100%; height: 100%; border-radius: 1.5rem; background: linear-gradient(135deg, rgba(30,144,214,0.13), rgba(56,169,228,0.07)); border: 2px solid var(--blue-mid);"></div>
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl" style="box-shadow: 0 32px 80px rgba(30,144,214,0.16);">
                        <img src="/images/image.png" alt="Gedung utama SMKN 1 Garut" style="width: 100%; height: 420px; object-fit: cover;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 8rem; background: linear-gradient(to top, rgba(10,79,143,0.8), transparent);"></div>
                        <div style="position: absolute; bottom: 1.25rem; left: 1.25rem; right: 1.25rem;">
                            <p class="text-white font-semibold text-sm">Gedung Utama SMKN 1 Garut</p>
                            <p class="text-white text-xs" style="opacity: 0.7;">Jl. Cimanuk No.309A, Garut</p>
                        </div>
                    </div>
                    <div class="absolute" style="bottom: -1.25rem; left: -1.25rem; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 1rem; background: white; border: 1px solid var(--blue-mid); box-shadow: 0 8px 32px rgba(30,144,214,0.13);">
                        <img src="/images/image-2.png" alt="Logo SMKN 1 Garut" style="width: 3rem; height: 3rem; object-fit: contain;">
                        <div>
                            <p class="text-xs font-bold" style="color: var(--navy);">SMKN 1 Garut</p>
                            <p class="text-xs" style="color: var(--sky);">Akreditasi A</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="overflow: hidden; line-height: 0;">
            <svg viewBox="0 0 1440 56" fill="none" style="width: 100%;">
                <path d="M0 56C240 20 480 4 720 4C960 4 1200 20 1440 56V56H0V56Z" fill="rgba(30,144,214,0.06)"/>
            </svg>
        </div>
    </section>

    <!-- STATS BAR -->
    <div style="background: linear-gradient(90deg, var(--blue-deep), var(--blue));">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M3 21h18M9 8h1M9 12h1M9 16h1M14 8h1M14 12h1M14 16h1M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">1951</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Tahun Berdiri</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">8</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Kompetensi Keahlian</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">2.400+</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Siswa Aktif</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem;">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">120+</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Tenaga Pendidik</div>
                </div>
            </div>
        </div>
    </div>

    <!-- TENTANG SECTION -->
    <section id="tentang" style="padding-top: 6rem; padding-bottom: 6rem; background: white;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <!-- Photo -->
                <div class="relative" style="height: 480px;">
                    <img src="/images/image-1.png" alt="Lingkungan SMKN 1 Garut" class="absolute inset-0 w-full h-full object-cover rounded-3xl" style="box-shadow: 0 20px 60px rgba(30,144,214,0.13);">
                    <div class="absolute inset-0 rounded-3xl" style="background: linear-gradient(to bottom right, rgba(30,144,214,0.09), transparent 60%);"></div>
                    <div class="absolute" style="top: 2rem; right: 0; transform: translateX(0.75rem); width: 0.5rem; height: 8rem; border-radius: 9999px; background: linear-gradient(to bottom, var(--blue), var(--sky));"></div>
                    <div class="absolute bottom-5 right-5 px-4 py-3 rounded-xl flex items-center gap-2" style="background: white; border: 1px solid var(--blue-mid); box-shadow: 0 4px 20px rgba(30,144,214,0.13);">
                        <img src="/images/image-3.png" alt="Disdik Jabar" class="h-8 object-contain">
                        <div>
                            <p class="text-xs font-semibold" style="color: var(--gray600);">Binaan</p>
                            <p class="text-xs font-bold" style="color: var(--blue-deep);">Disdik Jabar</p>
                        </div>
                    </div>
                </div>

                <!-- Text -->
                <div>
                    <p class="section-tag">Tentang Kami</p>
                    <h2 class="section-title">Profil <span class="text-blue">SMKN 1 Garut</span></h2>
                    <p class="leading-relaxed mb-4 text-sm" style="color: var(--gray600);">
                        SMKN 1 Garut merupakan sekolah menengah kejuruan negeri yang berdiri sejak <strong style="color: var(--blue-deep);">1951</strong> dan berlokasi di jantung Kota Garut, Jawa Barat. Sebagai salah satu SMK tertua dan terkemuka di Garut, kami telah menghasilkan ribuan alumni yang berkiprah di berbagai bidang industri nasional maupun internasional.
                    </p>
                    <p class="leading-relaxed mb-8 text-sm" style="color: var(--gray600);">
                        Di bawah naungan Dinas Pendidikan Provinsi Jawa Barat, SMKN 1 Garut terus berinovasi dengan 8 kompetensi keahlian yang relevan dengan kebutuhan industri masa kini dan masa depan.
                    </p>

                    <!-- Visi Misi -->
                    <div>
                        <div style="display: flex; gap: 0.25rem; margin-bottom: 1rem; padding: 0.25rem; border-radius: 0.75rem; background: var(--blue-light); width: fit-content;">
                            <button onclick="setActiveTab(0)" id="tab-visi" style="padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; background: var(--blue); color: white; border: none; cursor: pointer;">Visi</button>
                            <button onclick="setActiveTab(1)" id="tab-misi" style="padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; background: transparent; color: var(--gray600); border: none; cursor: pointer;">Misi</button>
                        </div>
                        <div id="visi-content" style="padding: 1.25rem; border-radius: 1rem; font-size: 0.875rem; line-height: 1.625; background: var(--gray50); border: 1px solid var(--blue-mid); color: var(--gray600);">
                            Menjadi sekolah menengah kejuruan unggulan yang menghasilkan lulusan berkarakter, kompeten, kreatif, inovatif, dan berdaya saing di era global berbasis teknologi dan kearifan lokal.
                        </div>
                        <div id="misi-content" style="padding: 1.25rem; border-radius: 1rem; font-size: 0.875rem; line-height: 1.625; background: var(--gray50); border: 1px solid var(--blue-mid); color: var(--gray600); display: none;">
                            Menyelenggarakan pendidikan dan pelatihan vokasi berkualitas, membangun kemitraan industri strategis, mengembangkan karakter luhur siswa, serta mendorong inovasi, kreativitas, dan kewirausahaan yang berdampak bagi masyarakat.
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-6 flex gap-3 p-4 rounded-xl items-start" style="background: var(--blue-light); border: 1px solid var(--blue-mid);">
                        <svg class="icon flex-shrink-0" style="width: 1.5rem; height: 1.5rem; color: var(--blue);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p class="text-sm" style="color: var(--gray800);">
                            Jl. Cimanuk No.309A, Sukagalih, Kec. Tarogong Kidul,<br>Kabupaten Garut, Jawa Barat 44151
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JURUSAN SECTION -->
    <section id="jurusan" style="padding-top: 6rem; padding-bottom: 6rem; background: var(--gray50);">
        <div class="container">
            <div class="text-center mb-16">
                <p class="section-tag">Program Keahlian</p>
                <h2 class="section-title">8 Kompetensi Keahlian</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                <!-- AKL -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(30,144,214,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #1E90D6;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(30,144,214,0.08); color: #1E90D6;">AKL</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Akuntansi dan Keuangan Lembaga</h3>
                    <p class="text-xs" style="color: var(--gray600);">Mencatat, mengolah, dan menyusun laporan keuangan secara akurat.</p>
                </div>
                <!-- DKV -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(124,58,237,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #7C3AED;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="13.5" cy="6.5" r="2.5"/><circle cx="6.5" cy="12.5" r="2.5"/><circle cx="17.5" cy="12.5" r="2.5"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(124,58,237,0.08); color: #7C3AED;">DKV</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Desain Komunikasi Visual</h3>
                    <p class="text-xs" style="color: var(--gray600);">Seni visual kreatif - desain grafis, ilustrasi, dan videografi.</p>
                </div>
                <!-- MPLB -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(8,145,178,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #0891B2;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(8,145,178,0.08); color: #0891B2;">MPLB</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Manajemen Perkantoran & Layanan Bisnis</h3>
                    <p class="text-xs" style="color: var(--gray600);">Administrasi kantor modern dan pelayanan prima profesional.</p>
                </div>
                <!-- PMS -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(234,124,43,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #EA7C2B;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(234,124,43,0.08); color: #EA7C2B;">PMS</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Pemasaran</h3>
                    <p class="text-xs" style="color: var(--gray600);">Strategi penjualan, riset pasar, dan digital marketing.</p>
                </div>
                <!-- PPLG -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(22,163,74,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #16A34A;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(22,163,74,0.08); color: #16A34A;">PPLG</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Pengembangan Perangkat Lunak & Gim</h3>
                    <p class="text-xs" style="color: var(--gray600);">Pembuatan aplikasi, website, dan gim interaktif.</p>
                </div>
                <!-- TET -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(202,138,4,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #CA8A04;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(202,138,4,0.08); color: #CA8A04;">TET</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Teknik Energi Terbarukan</h3>
                    <p class="text-xs" style="color: var(--gray600);">Pemanfaatan energi surya dan angin ramah lingkungan.</p>
                </div>
                <!-- TJKT -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(3,105,161,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #0369A1;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(3,105,161,0.08); color: #0369A1;">TJKT</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Teknik Jaringan Komputer & Telekomunikasi</h3>
                    <p class="text-xs" style="color: var(--gray600);">Instalasi jaringan dan konfigurasi router.</p>
                </div>
                <!-- TLM -->
                <div class="card">
                    <div class="jurusan-icon" style="background: rgba(220,38,38,0.08);">
                        <svg style="width: 1.75rem; height: 1.75rem; color: #DC2626;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <span class="jurusan-badge" style="background: rgba(220,38,38,0.08); color: #DC2626;">TLM</span>
                    <h3 class="font-semibold text-sm mb-2" style="color: var(--navy);">Teknik Laboratorium Medis</h3>
                    <p class="text-xs" style="color: var(--gray600);">Prosedur pengujian sampel klinis untuk diagnosis medis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN SECTION -->
    <section style="padding-top: 5rem; padding-bottom: 5rem; background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue) 100%);">
        <div class="container">
            <div class="text-center mb-12">
                <p style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; color: rgba(255,255,255,0.7);">Mengapa SMKN 1 Garut?</p>
                <h2 style="font-family: 'Playfair Display', serif; font-weight: 900; color: white; font-size: clamp(1.8rem, 4vw, 2.5rem);">Keunggulan Sekolah</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                    </div>
                    <h3 style="color: white; font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem;">Akreditasi A</h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.75rem; line-height: 1.625;">Terakreditasi A oleh BAN-SM dengan standar mutu tertinggi</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 6.1H3"/><path d="M21 12.1H3"/><path d="M15.1 18H3"/></svg>
                    </div>
                    <h3 style="color: white; font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem;">Kemitraan Industri</h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.75rem; line-height: 1.625;">Kerja sama dengan 100+ perusahaan nasional dan multinasional</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    </div>
                    <h3 style="color: white; font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem;">Lab & Bengkel Modern</h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.75rem; line-height: 1.625;">Fasilitas praktik lengkap sesuai standar industri terkini</p>
                </div>
                <div class="keunggulan-card">
                    <div class="keunggulan-icon">
                        <svg style="width: 2.5rem; height: 2.5rem;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <h3 style="color: white; font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem;">Alumni Berprestasi</h3>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.75rem; line-height: 1.625;">Ribuan alumni sukses di bidang industri dalam dan luar negeri</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERI SECTION -->
    <section id="galeri" style="padding-top: 6rem; padding-bottom: 6rem; background: white;">
        <div class="container">
            <div class="text-center mb-14">
                <p class="section-tag">Galeri</p>
                <h2 class="section-title">Lingkungan Sekolah</h2>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div class="group relative overflow-hidden rounded-2xl" style="box-shadow: 0 8px 32px rgba(30,144,214,0.09); aspect-ratio: 16/9;">
                    <img src="/images/image.png" alt="Gedung utama SMKN 1 Garut" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background: linear-gradient(to top, rgba(10,79,143,0.8), transparent);"></div>
                    <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-white font-bold text-sm">Gedung Utama</p>
                        <p class="text-white text-xs" style="opacity: 0.7;">Tampak Depan</p>
                    </div>
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white" style="background: rgba(30,144,214,0.8); backdrop-filter: blur(4px);">Gedung Utama</div>
                </div>
                <div class="group relative overflow-hidden rounded-2xl" style="box-shadow: 0 8px 32px rgba(30,144,214,0.09); aspect-ratio: 16/9;">
                    <img src="/images/image-1.png" alt="Area taman dan lingkungan SMKN 1 Garut" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background: linear-gradient(to top, rgba(10,79,143,0.8), transparent);"></div>
                    <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <p class="text-white font-bold text-sm">Lingkungan Sekolah</p>
                        <p class="text-white text-xs" style="opacity: 0.7;">Area Taman & Lapangan</p>
                    </div>
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white" style="background: rgba(30,144,214,0.8); backdrop-filter: blur(4px);">Lingkungan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- PPDB SECTION -->
    <section id="ppdb" style="padding-top: 6rem; padding-bottom: 6rem; background: var(--gray50);">
        <div class="container">
            <div class="text-center mb-16">
                <p class="section-tag">Penerimaan Siswa Baru</p>
                <h2 class="section-title">PPPDB 2025 / 2026</h2>
                <p class="text-sm" style="color: var(--gray600);">Bergabunglah dengan ribuan siswa berprestasi di SMKN 1 Garut</p>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem;">
                <!-- Jalur Masuk -->
                <div>
                    <h3 class="font-bold text-base mb-5" style="color: var(--navy);">Jalur Penerimaan</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div class="flex gap-4 items-start p-4 bg-white rounded-xl" style="border: 1px solid var(--blue-mid); box-shadow: 0 2px 8px rgba(30,144,214,0.05);">
                            <div style="width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(30,144,214,0.08); border: 1px solid rgba(30,144,214,0.19);">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #1E90D6;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                                <span style="font-size: 0.625rem; font-weight: 900; color: #1E90D6;">50%</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm mb-1" style="color: var(--navy);">Jalur Zonasi</p>
                                <p class="text-xs leading-relaxed" style="color: var(--gray600);">Berdasarkan jarak domisili ke sekolah</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-white rounded-xl" style="border: 1px solid var(--blue-mid); box-shadow: 0 2px 8px rgba(30,144,214,0.05);">
                            <div style="width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(22,163,74,0.08); border: 1px solid rgba(22,163,74,0.19);">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #16A34A;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"/></svg>
                                <span style="font-size: 0.625rem; font-weight: 900; color: #16A34A;">30%</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm mb-1" style="color: var(--navy);">Jalur Prestasi</p>
                                <p class="text-xs leading-relaxed" style="color: var(--gray600);">Nilai rapor atau prestasi akademik & non-akademik</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-white rounded-xl" style="border: 1px solid var(--blue-mid); box-shadow: 0 2px 8px rgba(30,144,214,0.05);">
                            <div style="width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(234,88,12,0.08); border: 1px solid rgba(234,88,12,0.19);">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #EA580C;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <span style="font-size: 0.625rem; font-weight: 900; color: #EA580C;">15%</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm mb-1" style="color: var(--navy);">Jalur Afirmasi</p>
                                <p class="text-xs leading-relaxed" style="color: var(--gray600);">Keluarga tidak mampu, dilengkapi PKH/KIP</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start p-4 bg-white rounded-xl" style="border: 1px solid var(--blue-mid); box-shadow: 0 2px 8px rgba(30,144,214,0.05);">
                            <div style="width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(124,58,237,0.08); border: 1px solid rgba(124,58,237,0.19);">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #7C3AED;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                <span style="font-size: 0.625rem; font-weight: 900; color: #7C3AED;">5%</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm mb-1" style="color: var(--navy);">Jalur Perpindahan</p>
                                <p class="text-xs leading-relaxed" style="color: var(--gray600);">Mengikuti perpindahan tugas orang tua/wali</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-8 p-5 rounded-2xl bg-white" style="border: 1px solid var(--blue-mid);">
                        <h3 class="font-bold text-sm mb-4" style="color: var(--navy);">Jadwal PPDB 2025/2026</h3>
                        <div style="display: flex; flex-direction: column; gap: 0;">
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div><div style="width: 1px; flex: 1; background: var(--blue-mid); min-height: 1.5rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; width: 100%; padding-bottom: 1rem;"><p class="text-xs font-medium" style="color: var(--gray800);">Sosialisasi & Pendataan</p><p class="text-xs font-bold" style="color: var(--blue);">Mei 2025</p></div>
                            </div>
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div><div style="width: 1px; flex: 1; background: var(--blue-mid); min-height: 1.5rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; w idth: 100%; padding-bottom: 1rem;"><p class="text-xs font-medium" style="color: var(--gray800);">Pendaftaran Online</p><p class="text-xs font-bold" style="color: var(--blue);">Juni 2025</p></div>
                            </div>
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div><div style="width: 1px; flex: 1; background: var(--blue-mid); min-height: 1.5rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; width: 100%; padding-bottom: 1rem;"><p class="text-xs font-medium" style="color: var(--gray800);">Verifikasi Berkas</p><p class="text-xs font-bold" style="color: var(--blue);">Juni 2025</p></div>
                            </div>
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div><div style="width: 1px; flex: 1; background: var(--blue-mid); min-height: 1.5rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; width: 100%; padding-bottom: 1rem;"><p class="text-xs font-medium" style="color: var(--gray800);">Pengumuman Seleksi</p><p class="text-xs font-bold" style="color: var(--blue);">Juli 2025</p></div>
                            </div>
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div><div style="width: 1px; flex: 1; background: var(--blue-mid); min-height: 1.5rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; width: 100%; padding-bottom: 1rem;"><p class="text-xs font-medium" style="color: var(--gray800);">Daftar Ulang</p><p class="text-xs font-bold" style="color: var(--blue);">Juli 2025</p></div>
                            </div>
                            <div style="display: flex; gap: 0.75rem; align-items: start;">
                                <div style="display: flex; flex-direction: column; align-items: center;"><div style="width: 0.625rem; height: 0.625rem; border-radius: 50%; background: var(--blue); margin-top: 0.25rem;"></div></div>
                                <div style="display: flex; justify-content: space-between; width: 100%;"><p class="text-xs font-medium" style="color: var(--gray800);">Awal Tahun Pelajaran</p><p class="text-xs font-bold" style="color: var(--blue);">14 Juli 2025</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="bg-white rounded-2xl p-8" style="border: 1px solid var(--blue-mid); box-shadow: 0 8px 32px rgba(30,144,214,0.06);">
                    <div class="flex items-center gap-3 mb-6">
                        <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; background: var(--blue-light);">
                            <svg style="width: 1.25rem; height: 1.25rem; color: var(--blue);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <h3 class="font-bold text-lg" style="color: var(--navy);">Persyaratan Dokumen</h3>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Fotokopi Ijazah / SKL SMP/MTs yang telah dilegalisir</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Fotokopi Kartu Keluarga (KK)</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Fotokopi Akta Kelahiran</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Fotokopi Rapor SMP semester 1-5 (dilegalisir)</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Pas foto 3x4 berwarna latar merah (4 lembar)</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div style="width: 1.25rem; height: 1.25rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: var(--blue-light); border: 1px solid var(--blue-mid); flex-shrink: 0; margin-top: 0.125rem;"><svg style="width: 0.75rem; height: 0.75rem; color: var(--blue);" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="2 6 5 9 10 3"/></svg></div>
                            <p class="text-sm leading-relaxed" style="color: var(--gray600);">Fotokopi Kartu Indonesia Pintar (KIP) jika ada</p>
                        </div>
                    </div>
                    <div class="mt-6 p-4 rounded-xl text-xs leading-relaxed" style="background: var(--blue-light); border: 1px solid var(--blue-mid); color: var(--blue-deep);">
                        <strong>Catatan:</strong> Berkas asli wajib dibawa saat verifikasi. Jadwal mengikuti ketentuan PPDB Provinsi Jawa Barat.
                    </div>
                    <a href="https://ppdb.jabarprov.go.id" target="_blank" rel="noopener noreferrer" class="mt-6 flex items-center justify-center gap-2 w-full font-bold text-sm text-white py-3.5 rounded-full transition-all" style="background: linear-gradient(135deg, var(--blue), var(--blue-deep)); box-shadow: 0 6px 20px rgba(30,144,214,0.27);">
                        <svg style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                        Daftar via Portal PPDB Jabar
                    </a>
                </div>
            </div>
        </div>
    </section>
