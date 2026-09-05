<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCore | {{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="student-shell">
        <aside class="sidebar">
            <div class="brand"><a class="brand-mark" href="{{ route('student.dashboard') }}">E</a><div><strong>EduCore</strong><small>Portal siswa SMKN 1 Garut</small></div></div>
            <div class="side-label">Menu utama</div>
            <nav>
                <a class="side-link" href="{{ route('student.dashboard') }}"><span>⌂</span>Beranda</a>
                <a class="side-link" href="{{ route('student.dashboard') }}#tugas"><span>▤</span>Tugas saya <span class="nav-count">4</span></a>
                <a class="side-link {{ isset($schedules) ? 'is-active' : '' }}" href="{{ route('student.schedule') }}"><span>▣</span>Jadwal pelajaran</a>
                <a class="side-link {{ isset($grades) ? 'is-active' : '' }}" href="{{ route('student.grades') }}"><span>⌁</span>Nilai saya</a>
            </nav>
            <div class="side-label" style="margin-top: 30px;">Layanan siswa</div>
            <nav>
                <a class="side-link {{ isset($materials) ? 'is-active' : '' }}" href="{{ route('student.materials') }}"><span>▥</span>Materi belajar</a>
                <a class="side-link {{ isset($permitRequests) ? 'is-active' : '' }}" href="{{ route('student.permits') }}"><span>▧</span>Surat & izin</a>
            </nav>
            <div class="side-bottom"><div class="help-card"><strong style="font-size:12px; color:#37658f;">Butuh bantuan?</strong><p>Hubungi wali kelas untuk pertanyaan seputar pembelajaran.</p><a class="text-button" href="mailto:walikelas@educore.test">Hubungi wali kelas &rarr;</a></div><form action="{{ route('logout') }}" method="POST" style="margin-top:12px;">@csrf<button class="side-link" type="submit"><span>↪</span>Keluar</button></form></div>
        </aside>
        <main class="main-content">
            <header class="topbar"><div class="breadcrumb"><a href="{{ route('student.dashboard') }}">Portal siswa</a> / <strong>{{ $title }}</strong></div><div class="top-actions"><button class="icon-button mobile-menu" id="mobileMenu" aria-label="Buka menu"><svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button><button class="icon-button" aria-label="Notifikasi"><span class="notification-dot"></span><svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg></button><div class="profile-chip"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->student_class ?: 'Murid' }} &bull; 2026/2027</small></div></div></div></header>
            <section class="welcome"><div><div class="eyebrow">RUANG BELAJAR MURID</div><h1>{{ $title }}<span style="color:#4f8df5;">.</span></h1><p>{{ $description }}</p></div><div class="date-badge">Semester Ganjil &nbsp;&bull;&nbsp; 2026/2027</div></section>

            @if (session('success'))
                <div class="success-banner">{{ session('success') }}</div>
            @endif

            @isset($schedules)
                <section class="panel page-panel"><div class="panel-heading"><div><h2>Agenda pembelajaran</h2><p>Jadwal tersusun berdasarkan tanggal dan waktu mulai.</p></div></div><div class="data-list">@forelse ($schedules as $schedule)<div class="data-row"><div class="schedule-time"><strong>{{ substr($schedule->starts_at, 0, 5) }}</strong>{{ substr($schedule->ends_at, 0, 5) }}</div><div class="row-main"><h3>{{ $schedule->subject }}</h3><p>{{ $schedule->teacher }} &nbsp;&bull;&nbsp; {{ $schedule->room }}</p></div><span class="soft-tag">{{ $schedule->day_of_week }}</span></div>@empty<div class="empty-state">Belum ada jadwal yang tersedia.</div>@endforelse</div></section>
            @endisset

            @isset($grades)
                <section class="panel page-panel"><div class="panel-heading"><div><h2>Rekap nilai semester</h2><p>Nilai yang sudah diterbitkan oleh guru mata pelajaran.</p></div><div class="grade-average">88.6 <small>rata-rata</small></div></div><div class="data-list">@forelse ($grades as $grade)<div class="data-row"><div class="grade-score">{{ number_format((float) $grade->score, 0) }}</div><div class="row-main"><h3>{{ $grade->subject }}</h3><p>{{ $grade->teacher }} &nbsp;&bull;&nbsp; {{ $grade->semester }}</p></div><span class="soft-tag {{ (float) $grade->score >= 85 ? 'tag-good' : '' }}">{{ $grade->notes ?: 'Baik' }}</span></div>@empty<div class="empty-state">Belum ada nilai yang tersedia.</div>@endforelse</div></section>
            @endisset

            @isset($materials)
                <section class="panel page-panel"><div class="panel-heading"><div><h2>Materi terbaru</h2><p>Materi pembelajaran yang dibagikan oleh guru.</p></div><span class="soft-tag">{{ $materials->count() }} materi</span></div><div class="material-grid">@forelse ($materials as $material)<article class="material-card"><div class="material-icon">▤</div><div><span class="eyebrow">{{ $material->subject }}</span><h3>{{ $material->title }}</h3><p>{{ $material->description }}</p><small>{{ $material->teacher }} &nbsp;&bull;&nbsp; {{ optional($material->published_at)->format('d M Y') }}</small></div><button class="view-all" type="button">Buka materi &rarr;</button></article>@empty<div class="empty-state">Belum ada materi yang tersedia.</div>@endforelse</div></section>
            @endisset

            @isset($permitRequests)
                <div class="permit-layout"><section class="panel page-panel"><div class="panel-heading"><div><h2>Ajukan surat izin</h2><p>Lengkapi data berikut untuk dikirim ke wali kelas.</p></div></div><form class="permit-form" action="{{ route('student.permits.store') }}" method="POST" enctype="multipart/form-data">@csrf<label class="form-label">Nama siswa<input class="form-control" name="student_name" value="Aditya Ramadhan" required></label><label class="form-label">Jenis izin<select class="form-control" name="type" required><option>Izin sakit</option><option>Izin keperluan keluarga</option><option>Izin lainnya</option></select></label><label class="form-label">Tanggal tidak hadir<input class="form-control" type="date" name="permit_date" value="{{ now()->toDateString() }}" required></label><label class="form-label">Keterangan<textarea class="form-control" name="description" rows="4" placeholder="Tulis alasan izin secara singkat..." required></textarea></label><label class="form-label">Bukti pendukung<input class="form-control file-control" type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf"></label><button class="primary-button" type="submit">Kirim pengajuan izin</button>@if ($errors->any())<div class="form-errors">{{ $errors->first() }}</div>@endif</form></section><section class="panel page-panel"><div class="panel-heading"><div><h2>Riwayat pengajuan</h2><p>Status pengajuan izinmu.</p></div></div><div class="data-list">@forelse ($permitRequests as $permit)<div class="permit-row"><div class="subject-icon mint">▧</div><div class="row-main"><h3>{{ $permit->type }}</h3><p>{{ $permit->permit_date->format('d M Y') }} &nbsp;&bull;&nbsp; {{ $permit->description }}</p></div><span class="status">{{ ucfirst($permit->status) }}</span></div>@empty<div class="empty-state">Belum ada pengajuan izin.</div>@endforelse</div></section></div>
            @endisset
        </main>
    </div>
    @include('partials.student-coach')
</body>
</html>
