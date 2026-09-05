<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCore | Ruang Belajar Murid</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="student-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">E</div>
                <div><strong>EduCore</strong><small>Portal siswa SMKN 1 Garut</small></div>
            </div>
            <div class="side-label">Menu utama</div>
            <nav>
                <button class="side-link is-active" data-nav="Beranda"><svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M9 21v-7h6v7"/></svg>Beranda</button>
                <a class="side-link" href="{{ route('student.assignments') }}"><svg viewBox="0 0 24 24"><path d="M8 3h8l2 2v16H6V5z"/><path d="M9 3v4h6V3M9 12h6M9 16h4"/></svg>Tugas saya <span class="nav-count">4</span></a>
                <a class="side-link" href="{{ route('student.schedule') }}"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18M8 13h.01M12 13h.01M16 13h.01M8 17h.01M12 17h.01"/></svg>Jadwal pelajaran</a>
                <a class="side-link" href="{{ route('student.grades') }}"><svg viewBox="0 0 24 24"><path d="M4 19V5M4 19h17"/><path d="m7 15 3-4 3 2 5-7"/></svg>Nilai saya</a>
            </nav>
            <div class="side-label" style="margin-top: 30px;">Layanan siswa</div>
            <nav>
                <a class="side-link" href="{{ route('student.materials') }}"><svg viewBox="0 0 24 24"><path d="M4 5a3 3 0 0 1 3-3h13v18H7a3 3 0 0 0-3 3z"/><path d="M4 5v18M7 20h13"/></svg>Materi belajar</a>
                <a class="side-link" href="{{ route('student.permits') }}"><svg viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/><path d="m7 8 5 4 5-4M7 16h4"/></svg>Surat & izin</a>
                <a class="side-link" href="{{ route('student.chat') }}"><svg viewBox="0 0 24 24"><path d="M4 5h16v12H8l-4 4z"/><path d="M8 9h8M8 13h5"/></svg>Chat guru</a>
            </nav>
            <div class="side-bottom">
                <div class="help-card"><strong style="font-size:12px; color:#37658f;">Butuh bantuan?</strong><p>Hubungi wali kelas untuk pertanyaan seputar pembelajaran.</p><button class="text-button" data-nav="Pusat bantuan">Buka pusat bantuan &rarr;</button></div>
                <form action="{{ route('logout') }}" method="POST" style="margin-top:12px;">@csrf<button class="side-link" type="submit"><span>↪</span>Keluar</button></form>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="breadcrumb">Portal siswa / <strong>Beranda</strong></div>
                <div class="top-actions">
                    <a class="library-top-link" href="{{ route('library.dashboard') }}"><span>▣</span>E-Perpus</a>
                    <button class="icon-button mobile-menu" id="mobileMenu" aria-label="Buka menu"><svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
                    <button class="icon-button" aria-label="Notifikasi"><span class="notification-dot"></span><svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg></button>
                    <div class="profile-chip"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div><div><strong>{{ auth()->user()->name }}</strong><small>{{ auth()->user()->student_class ?: 'Murid' }} &bull; 2026/2027</small></div></div>
                </div>
            </header>

            <section class="welcome">
                <div><div class="eyebrow">SENIN, 7 SEPTEMBER 2026</div><h1>Selamat pagi, {{ auth()->user()->name }} <span style="color:#4f8df5;">.</span></h1><p>Siap melanjutkan hal baik hari ini?</p></div>
                <div class="date-badge"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg>Semester Ganjil &nbsp;&bull;&nbsp; Minggu ke-4</div>
            </section>

            <section class="metric-grid">
                <div class="metric-card"><div class="metric-top"><span>Tugas aktif</span><span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M8 3h8l2 2v16H6V5zM9 3v4h6V3M9 12h6"/></svg></span></div><div class="metric-value">4</div><div class="metric-note">Perlu diselesaikan</div></div>
                <div class="metric-card"><div class="metric-top"><span>Rata-rata nilai</span><span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M4 19V5M4 19h17M7 15l3-4 3 2 5-7"/></svg></span></div><div class="metric-value">88.6</div><div class="metric-note"><b>+2.4%</b> dari bulan lalu</div></div>
                <div class="metric-card"><div class="metric-top"><span>Kehadiran</span><span class="metric-icon"><svg viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></svg></span></div><div class="metric-value">96<span style="font-size:15px;">%</span></div><div class="metric-note"><b>Sangat baik</b> semester ini</div></div>
                <div class="metric-card"><div class="metric-top"><span>Materi selesai</span><span class="metric-icon"><svg viewBox="0 0 24 24"><path d="M4 5a3 3 0 0 1 3-3h13v18H7a3 3 0 0 0-3 3zM4 5v18"/></svg></span></div><div class="metric-value">12<span style="font-size:15px;">/18</span></div><div class="metric-note">Terus semangat belajar</div></div>
            </section>

            <div class="content-grid">
                <section class="panel">
                    <div class="panel-heading"><div><h2>Tugas terbaru</h2><p>Jangan lewatkan tenggat tugasmu.</p></div><button class="view-all" data-nav="Semua tugas">Lihat semua &rarr;</button></div>
                    <div class="filter-row"><button class="filter-pill is-active" data-filter="all">Semua <span>4</span></button><button class="filter-pill" data-filter="pending">Belum dikerjakan <span>3</span></button><button class="filter-pill" data-filter="done">Selesai <span>1</span></button></div>
                    @forelse ($assignments as $assignment)
                        <article class="assignment-card" data-assignment data-id="{{ $assignment->id }}" data-state="{{ $assignment->status === 'submitted' ? 'done' : 'pending' }}" data-title="{{ $assignment->title }}" data-subject="{{ $assignment->subject }}" data-description="{{ $assignment->description }}" data-due="{{ $assignment->due_at->format('d M Y, H:i') }}" data-points="{{ $assignment->max_points }}" data-status="{{ $assignment->status === 'submitted' ? 'Sudah dikumpulkan' : 'Belum dikerjakan' }}" data-tone="blue"><div class="subject-icon"><svg viewBox="0 0 24 24"><path d="M5 4h14v16H5zM8 8h8M8 12h2M14 12h2M8 16h2M14 16h2"/></svg></div><div><h3>{{ $assignment->title }}</h3><p>{{ $assignment->subject }} &nbsp;&bull;&nbsp; {{ $assignment->teacher }}</p></div><div class="assignment-meta"><span class="status {{ $assignment->status === 'submitted' ? 'done' : '' }}">{{ $assignment->status === 'submitted' ? 'Sudah dikumpulkan' : 'Belum dikerjakan' }}</span><span class="due">Tenggat {{ $assignment->due_at->format('d M Y, H:i') }}</span></div></article>
                    @empty
                        <div class="empty-state">Belum ada tugas yang tersedia.</div>
                    @endforelse
                </section>

                <aside>
                    <section class="panel"><div class="panel-heading"><div><h2>Aksi cepat</h2><p>Urus kebutuhan sekolahmu.</p></div></div><div class="quick-actions"><button class="quick-action" id="openPermit"><span><svg viewBox="0 0 24 24"><path d="M5 4h14v16H5zM8 8h8M8 12h5M8 16h7"/></svg></span><div><strong>Kirim surat izin</strong><small>Sakit, keperluan, dan lainnya</small></div></button><button class="quick-action" data-nav="Jadwal pelajaran"><span><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg></span><div><strong>Lihat jadwal hari ini</strong><small>5 mata pelajaran</small></div></button><button class="quick-action" data-nav="Materi belajar"><span><svg viewBox="0 0 24 24"><path d="M4 5a3 3 0 0 1 3-3h13v18H7a3 3 0 0 0-3 3zM4 5v18"/></svg></span><div><strong>Jelajahi materi</strong><small>12 materi tersedia</small></div></button></div></section>
                    <section class="panel schedule"><div class="panel-heading"><div><h2>Jadwal hari ini</h2><p>{{ now()->translatedFormat('l, d F') }}</p></div><a class="view-all" href="{{ route('student.schedule') }}">Semua &rarr;</a></div>@forelse ($upcomingSchedules as $schedule)<div class="schedule-item"><div class="schedule-time"><strong>{{ substr($schedule->starts_at, 0, 5) }}</strong>{{ substr($schedule->ends_at, 0, 5) }}</div><div><div class="schedule-name">{{ $schedule->subject }}</div><div class="schedule-room">{{ $schedule->room }} &nbsp;&bull;&nbsp; {{ $schedule->teacher }}</div></div></div>@empty<div class="empty-state">Belum ada jadwal.</div>@endforelse</section>
                </aside>
            </div>
        </main>
    </div>

    <div class="modal" id="assignmentModal"><div class="modal-backdrop"><div class="modal-card"><div class="modal-header"><div><div class="eyebrow" id="detailSubject">Matematika</div><h2 id="detailTitle">Eksplorasi Fungsi Kuadrat</h2><p>Detail dan pengumpulan tugas</p></div><button class="modal-close" data-close-modal="assignmentModal">&times;</button></div><p class="detail-copy" id="detailDescription"></p><div class="detail-stats"><div class="detail-stat"><small>Tenggat</small><strong id="detailDue"></strong></div><div class="detail-stat"><small>Nilai maksimal</small><strong id="detailPoints"></strong></div><div class="detail-stat"><small>Status</small><strong id="detailStatus"></strong></div></div><form id="assignmentForm" class="modal-form" method="POST" enctype="multipart/form-data">@csrf<label class="form-label">Lampiran tugas<label class="upload-zone"><input type="file" name="submission" id="detailUpload" accept=".pdf,.doc,.docx,.zip" required><span id="fileName">Pilih file dari perangkat</span></label></label><button class="primary-button" type="submit">Kumpulkan tugas</button></form></div></div></div>
    <div class="modal" id="permitModal"><div class="modal-backdrop"><div class="modal-card"><div class="modal-header"><div><div class="eyebrow">LAYANAN SISWA</div><h2>Kirim surat izin</h2><p>Ajukan ketidakhadiran kepada wali kelas.</p></div><button class="modal-close" data-close-modal="permitModal">&times;</button></div><form id="permitForm" class="modal-form" action="{{ route('student.permits.store') }}" method="POST" enctype="multipart/form-data">@csrf<input type="hidden" name="student_name" value="Aditya Ramadhan"><label class="form-label">Jenis izin<select class="form-control" name="type" required><option>Izin sakit</option><option>Izin keperluan keluarga</option><option>Izin lainnya</option></select></label><label class="form-label">Tanggal tidak hadir<input class="form-control" name="permit_date" type="date" value="{{ now()->toDateString() }}" required></label><label class="form-label">Keterangan<textarea class="form-control" name="description" rows="3" placeholder="Tulis alasan izin secara singkat..." required></textarea></label><label class="form-label">Bukti pendukung<label class="upload-zone"><input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf"><span>Pilih surat keterangan atau foto</span></label></label><button class="primary-button" type="submit">Kirim pengajuan izin</button></form></div></div></div>
    @include('partials.student-coach')
    <div class="toast" id="toast"><i></i><span></span></div>
</body>
</html>
