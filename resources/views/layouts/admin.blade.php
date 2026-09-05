<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCore | Administrator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="student-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">E</div>
                <div><strong>EduCore</strong><small>Panel Admin SMKN 1</small></div>
            </div>

            <div class="side-label">Beranda</div>
            <nav>
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M9 21v-7h6v7"/></svg>
                    Dashboard
                </a>
            </nav>

            <div class="side-label">Manajemen User</div>
            <nav>
                <a class="side-link {{ request()->routeIs('admin.students') ? 'is-active' : '' }}" href="{{ route('admin.students') }}">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Data Murid
                </a>
                <a class="side-link {{ request()->routeIs('admin.teachers') ? 'is-active' : '' }}" href="{{ route('admin.teachers') }}">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    Data Guru
                </a>
            </nav>

            <div class="side-label">Akademik</div>
            <nav>
                <a class="side-link {{ request()->routeIs('admin.classes') ? 'is-active' : '' }}" href="{{ route('admin.classes') }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Kelas & Rombel
                </a>
            </nav>

            <div class="side-label">Program Sekolah</div>
            <nav>
                <a class="side-link {{ request()->routeIs('admin.pkl') ? 'is-active' : '' }}" href="{{ route('admin.pkl') }}">
                    <svg viewBox="0 0 24 24"><path d="M4 7h16v13H4z"/><path d="M8 7V4h8v3M8 12h8M8 16h5"/></svg>
                    Manajemen PKL
                </a>
            </nav>

            <div class="side-bottom">
                <div class="help-card">
                    <strong style="font-size:12px; color:#37658f;">Panel Administrator</strong>
                    <p>Kelola seluruh data akademik dan pengguna sistem EduCore.</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-top:12px;">
                    @csrf
                    <button class="side-link" type="submit">
                        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="breadcrumb">
                    @if(isset($breadcrumb))
                        <a href="{{ route('admin.dashboard') }}">Admin</a> / <strong>{{ $breadcrumb }}</strong>
                    @else
                        Admin / <strong>Dashboard</strong>
                    @endif
                </div>
                <div class="top-actions">
                    <button class="icon-button mobile-menu" id="mobileMenu" aria-label="Buka menu">
                        <svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="profile-chip">
                        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                        <div>
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>Administrator</small>
                        </div>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="success-banner">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="form-errors" style="margin-bottom: 20px;">{{ $errors->first() }}</div>
            @endif

            @yield('admin-content')
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenu')?.addEventListener('click', () => {
            document.querySelector('.sidebar')?.classList.toggle('is-mobile-open');
        });

        // Close sidebar on outside click
        document.addEventListener('click', (e) => {
            const sidebar = document.querySelector('.sidebar');
            const mobileBtn = document.getElementById('mobileMenu');
            if (sidebar?.classList.contains('is-mobile-open') &&
                !sidebar.contains(e.target) &&
                !mobileBtn?.contains(e.target)) {
                sidebar.classList.remove('is-mobile-open');
            }
        });
    </script>
</body>
</html>
