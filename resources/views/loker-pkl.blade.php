<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Lowongan PKL - SMKN 1 Garut' }}</title>
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
        .btn-primary { background: linear-gradient(135deg, var(--blue), var(--blue-deep)); color: white; padding: 0.875rem 1.75rem; border-radius: 9999px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-block; box-shadow: 0 6px 24px rgba(30,144,214,0.27); transition: transform 0.2s; border: none; cursor: pointer; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline { border: 2px solid var(--blue); color: var(--blue); padding: 0.875rem 1.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; background: white; transition: transform 0.2s; }
        .btn-outline:hover { transform: translateY(-2px); }
        .font-bold { font-weight: 700; }
        .font-black { font-weight: 900; }
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .leading-tight { line-height: 1.25; }
        .leading-relaxed { line-height: 1.625; }
        .mb-6 { margin-bottom: 1.5rem; }
        .text-center { text-align: center; }
        .text-white { color: white; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-3 { gap: 0.75rem; }
        .gap-6 { gap: 1.5rem; }
        .navbar { position: sticky; top: 0; z-index: 50; background: white; border-bottom: 1px solid var(--blue-mid); box-shadow: 0 2px 20px rgba(30,144,214,0.10); }
        .nav-link { color: var(--gray600); padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; font-size: 0.875rem; transition: all 0.2s; }
        .nav-link:hover { color: var(--blue); background: var(--blue-light); }
        .nav-link.active { color: var(--blue); background: var(--blue-light); }
        .loker-card { background: white; border-radius: 1rem; border: 1px solid var(--blue-mid); box-shadow: 0 2px 12px rgba(30,144,214,0.06); padding: 1.5rem; transition: all 0.3s; overflow: hidden; }
        .loker-card:hover { border-color: var(--blue); box-shadow: 0 16px 40px rgba(30,144,214,0.15); transform: translateY(-4px); }
        .section-tag { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem; color: var(--blue); }
        .section-title { font-family: "Playfair Display", serif; font-weight: 900; line-height: 1.1; margin-bottom: 1rem; font-size: clamp(1.8rem, 4vw, 2.5rem); color: var(--navy); }
        .search-input { width: 100%; padding: 0.875rem 1rem 0.875rem 3rem; border: 2px solid var(--blue-mid); border-radius: 9999px; font-size: 0.875rem; font-family: "Poppins", sans-serif; transition: all 0.2s; }
        .search-input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 4px rgba(30,144,214,0.1); }
        .filter-btn { padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid var(--blue-mid); background: white; color: var(--gray600); cursor: pointer; transition: all 0.2s; }
        .filter-btn:hover, .filter-btn.active { background: var(--blue); color: white; border-color: var(--blue); }
        .modal { display: none; position: fixed; inset: 0; z-index: 100; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal.show { display: flex; }
        .modal-content { background: white; border-radius: 1rem; padding: 2rem; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; }
        .form-input { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--blue-mid); border-radius: 0.5rem; font-size: 0.875rem; font-family: "Poppins", sans-serif; }
        .form-input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(30,144,214,0.1); }
        .form-label { display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--navy); }
        .form-group { margin-bottom: 1rem; }
        footer { background: var(--navy); }
        footer a { color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.2s; }
        footer a:hover { color: var(--sky); }
        @media (max-width: 768px) { .desktop-nav { display: none; } .mobile-toggle { display: block; } .hide-mobile { display: none; } }
        @media (min-width: 769px) { .mobile-toggle { display: none; } }
    </style>
</head>
<body>

    <!-- TOP STRIP -->
    <div style="background: var(--blue-deep); padding: 0.375rem 1rem; text-align: center;">
        <p class="text-white text-xs tracking-wide">
            <svg class="icon" style="width: 1rem; height: 1rem; margin-right: 0.25rem; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"/></svg>
            Lowongan PKL - Kesempatan Magang untuk Siswa SMKN 1 Garut
        </p>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container flex items-center justify-between" style="height: 4rem;">
            <a href="/" class="flex items-center gap-3" style="text-decoration: none;">
                <img src="/images/image-2.png" alt="Logo SMKN 1 Garut" style="height: 2.75rem; width: 2.75rem; object-fit: contain;">
                <div style="line-height: 1.2;">
                    <div class="font-black text-base" style="font-family: Playfair Display, serif; color: var(--blue-deep);">SMKN 1 Garut</div>
                    <div class="text-xs tracking-widest uppercase" style="color: var(--sky);">Motekar Wibawa Mukti</div>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="desktop-nav flex items-center gap-1">
                <a href="/" class="nav-link">Beranda</a>
                <a href="/#tentang" class="nav-link">Tentang</a>
                <a href="/#jurusan" class="nav-link">Jurusan</a>
                <a href="/loker-pkl" class="nav-link active">Lowongan PKL</a>
                <a href="/#galeri" class="nav-link">Galeri</a>
                <a href="/#kontak" class="nav-link">Kontak</a>
            </div>

            <!-- Mobile Toggle -->
            <button class="mobile-toggle p-2 rounded-lg" style="color: var(--blue); background: none; border: none; cursor: pointer;" onclick="toggleMenu()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Nav -->
        <div id="mobileNav" style="display: none;">
            <a href="/" class="nav-link" style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--blue-light);">Beranda</a>
            <a href="/#tentang" class="nav-link" style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--blue-light);">Tentang</a>
            <a href="/#jurusan" class="nav-link" style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--blue-light);">Jurusan</a>
            <a href="/loker-pkl" class="nav-link active" style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--blue-light);">Lowongan PKL</a>
            <a href="/#galeri" class="nav-link" style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid var(--blue-light);">Galeri</a>
            <a href="/#kontak" class="nav-link" style="display: block; padding: 0.75rem 1rem;">Kontak</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section style="padding-top: 4rem; padding-bottom: 4rem; background: linear-gradient(160deg, var(--blue-light) 0%, #fff 55%); position: relative; overflow: hidden;">
        <div style="position: absolute; border-radius: 50%; opacity: 0.07; background: var(--blue); width: 500px; height: 500px; top: -6rem; right: -6rem;"></div>
        <div style="position: absolute; border-radius: 50%; opacity: 0.07; background: var(--sky); width: 288px; height: 288px; top: 10rem; right: -2.5rem;"></div>
        <div style="position: absolute; border-radius: 50%; opacity: 0.07; background: var(--blue); width: 224px; height: 224px; bottom: -4rem; left: 2rem;"></div>
        
        <div class="container" style="padding-top: 4rem; padding-bottom: 2rem; position: relative; z-index: 1;">
            <div style="text-align: center; max-width: 700px; margin: 0 auto;">
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; margin-bottom: 1.5rem; background: var(--blue-light); color: var(--blue-dark); border: 1px solid var(--blue-mid);">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--blue); display: inline-block;"></span>
                    Kesempatan Magang & Pelatihan Siswa
                </div>

                <h1 class="font-black leading-tight mb-6" style="font-family: Playfair Display, serif; font-size: clamp(2.2rem, 5vw, 3.5rem); color: var(--navy);">
                    Lowongan PKL<br><span style="color: var(--blue);">SMKN 1 Garut</span>
                </h1>

                <p class="text-base leading-relaxed mb-6" style="color: var(--gray600); max-width: 560px; margin: 0 auto 1.5rem;">
                    Temukan berbagai kesempatan <strong style="color: var(--blue-deep);">Praktek Kerja Lapangan (PKL)</strong> dari perusahaan partner kami untuk mengembangkan skill dan pengalaman praktis siswa.
                </p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center;">
                    <button onclick="openModal()" class="btn-primary">
                        <svg class="icon" style="width: 1rem; height: 1rem; margin-right: 0.5rem; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Tambah Lowongan
                    </button>
                    <button onclick="document.getElementById('loker-section').scrollIntoView({behavior: 'smooth'})" class="btn-outline">
                        Lihat Lowongan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div style="background: linear-gradient(90deg, var(--blue-deep), var(--blue));">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">{{ $lokerPkls->count() }}</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Lowongan Aktif</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">100+</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Perusahaan Partner</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem; border-right: 1px solid rgba(255,255,255,0.15);">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">500+</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Siswa Terempatan</div>
                </div>
                <div style="text-align: center; padding: 2rem 1rem;">
                    <svg class="icon" style="width: 1.5rem; height: 1.5rem; margin: 0 auto 0.5rem; display: block;" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <div style="color: white; font-weight: 900; font-size: 1.875rem; font-family: Playfair Display, serif;">8</div>
                    <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem;">Jurusan</div>
                </div>
            </div>
        </div>
    </div>
