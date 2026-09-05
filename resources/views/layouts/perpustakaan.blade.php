<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'E-Perpus' }} | EduCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="perpus-page">
    <div class="perpus-ambient perpus-ambient-one"></div>
    <div class="perpus-ambient perpus-ambient-two"></div>
    <header class="perpus-topbar">
        <a href="{{ route(auth()->user()->isTeacher() ? 'teacher.dashboard' : (auth()->user()->role === 'admin' ? 'admin.classes' : 'student.dashboard')) }}" class="perpus-back">&larr; Kembali ke Web Sekolah</a>
        <div class="perpus-brand"><span>EP</span><strong>E-Perpus</strong><small>SMKN 1 Garut</small></div>
        <nav class="perpus-nav" aria-label="Navigasi E-Perpus"><a class="{{ request()->routeIs('library.dashboard') ? 'is-active' : '' }}" href="{{ route('library.dashboard') }}">Beranda</a><a class="{{ request()->routeIs('library.catalog') ? 'is-active' : '' }}" href="{{ route('library.catalog') }}">Katalog</a><a class="{{ request()->routeIs('library.loans') || request()->routeIs('library.class-loans') ? 'is-active' : '' }}" href="{{ auth()->user()->isTeacher() ? route('library.class-loans') : route('library.loans') }}">{{ auth()->user()->isTeacher() ? 'Paket kelas' : 'Peminjaman' }}</a><a class="{{ request()->routeIs('library.profile') ? 'is-active' : '' }}" href="{{ route('library.profile') }}">Profil</a>@if (auth()->user()->role === 'admin')<a class="{{ request()->routeIs('library.admin.*') ? 'is-active' : '' }}" href="{{ route('library.admin.circulation') }}">Sirkulasi</a><a class="{{ request()->routeIs('library.admin.books*') ? 'is-active' : '' }}" href="{{ route('library.admin.books') }}">Koleksi</a>@endif</nav>
        <div class="perpus-account"><span>{{ auth()->user()->name }}</span><b>{{ strtoupper(auth()->user()->role) }}</b></div>
    </header>
    <main class="perpus-container">
        @if (session('success'))<div class="perpus-alert-data" data-alert-type="success" data-alert-message="{{ session('success') }}"></div>@endif
        @if ($errors->any())<div class="perpus-alert-data" data-alert-type="error" data-alert-message="{{ $errors->first() }}"></div>@endif
        @yield('content')
    </main>
    <div class="perpus-toast" id="perpusToast" role="status" aria-live="polite"></div>
    <div class="perpus-swal" id="perpusSwal" aria-hidden="true"><div class="perpus-swal-backdrop" data-close-swal></div><div class="perpus-swal-card" role="alertdialog" aria-modal="true"><button class="perpus-swal-close" type="button" data-close-swal aria-label="Tutup">×</button><div class="perpus-swal-icon" id="perpusSwalIcon"></div><p class="perpus-swal-kicker" id="perpusSwalKicker">BERHASIL</p><h2 id="perpusSwalTitle"></h2><p id="perpusSwalMessage"></p><button class="perpus-action" type="button" data-close-swal>Oke, mengerti</button></div></div>
</body>
</html>
