<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKL | EduCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .pkl-shell { max-width: 1180px; margin: 0 auto; padding: 28px; }
        .pkl-hero { background: linear-gradient(135deg, #173b63, #2f78b7); color: white; border-radius: 18px; padding: 32px; display: flex; justify-content: space-between; gap: 24px; align-items: end; }
        .pkl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .pkl-card { background: white; border: 1px solid #dce7ed; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(17,42,70,.06); transition: .2s ease; }
        .pkl-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(17,42,70,.12); }
        .pkl-card-image { height: 160px; overflow: hidden; background: linear-gradient(135deg, #e8f1ff, #f5f9ff); }
        .pkl-card-image img { width: 100%; height: 100%; object-fit: cover; }
        .pkl-card-image .placeholder { height: 100%; display: flex; align-items: center; justify-content: center; color: #7790ad; font-size: 48px; }
        .pkl-card-body { padding: 18px; }
        .pkl-card-badge { display: inline-block; border-radius: 999px; padding: 4px 10px; font-size: .7rem; font-weight: 700; background: #dcecf8; color: #1b5d91; margin-bottom: 10px; }
        .pkl-card-badge.featured { background: linear-gradient(135deg, #4f8df5, #377cf6); color: white; }
        .pkl-card h3 { margin: 0 0 6px; color: #28547f; font-size: 15px; }
        .pkl-card-location { display: flex; align-items: center; gap: 5px; color: #7790ad; font-size: 12px; margin: 0 0 8px; }
        .pkl-card-location svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }
        .pkl-card-desc { color: #91a5bc; font-size: 12px; line-height: 1.5; margin: 0 0 14px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .pkl-card-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; flex-wrap: wrap; }
        .pkl-filter-bar { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 10px; margin-bottom: 20px; }
        .pkl-filter-bar input, .pkl-filter-bar select { min-width: 0; padding: 11px; border: 1px solid #cbd9e2; border-radius: 8px; font: inherit; color: #214568; background: white; }
        .pkl-class-heading { grid-column: 1 / -1; color: #28547f; font-size: 16px; font-weight: 700; padding: 8px 0 0; border-bottom: 1px solid #dce7ed; }
        .pkl-class-heading span { color: #7790ad; font-size: 11px; font-weight: 400; margin-left: 8px; }
        .pkl-meta-tag { display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: #f0f5fa; border-radius: 6px; font-size: 10px; color: #7790ad; }
        .pkl-meta-tag svg { width: 10px; height: 10px; stroke: currentColor; fill: none; }
        .pkl-muted { color: #64748b; font-size: .9rem; }
        .pkl-pill { display: inline-block; border-radius: 999px; padding: 5px 10px; font-size: .75rem; font-weight: 700; background: #dcecf8; color: #1b5d91; }
        .pkl-pill.pending { background: #eef2f5; color: #566575; }
        .pkl-pill.rejected { background: #e2e7ec; color: #3e4e5e; }
        .pkl-pill.approved { background: #e2f7ef; color: #3e9c7f; }
        .pkl-form { display: grid; gap: 10px; margin-top: 14px; }
        .pkl-form input, .pkl-form textarea, .pkl-form button { font: inherit; }
        .pkl-form input, .pkl-form textarea { border: 1px solid #cbd9e2; border-radius: 8px; padding: 10px; width: 100%; }
        .pkl-button { border: 0; border-radius: 8px; padding: 11px 15px; background: #1f6fb2; color: white; font-weight: 700; cursor: pointer; width: 100%; }
        .pkl-button:hover { background: #185fa3; }
        .pkl-button.secondary { background: #e8f0f6; color: #214568; }
        .pkl-section { margin-top: 28px; }
        .pkl-alert { padding: 13px 16px; border-radius: 10px; background: #e8f0f6; color: #214568; margin-bottom: 20px; }
        @media (max-width: 850px) { .pkl-filter-bar { grid-template-columns: 1fr 1fr; } .pkl-filter-bar .pkl-button { grid-column: span 2; } }
        @media (max-width: 650px) { .pkl-shell { padding: 16px; } .pkl-hero { display: block; } .pkl-grid { grid-template-columns: 1fr; } .pkl-filter-bar { grid-template-columns: 1fr; } .pkl-filter-bar .pkl-button { grid-column: auto; } }
    </style>
</head>
<body>
<main class="pkl-shell">
    <header class="topbar" style="margin-bottom: 22px;">
        <div class="breadcrumb"><a href="{{ route('student.dashboard') }}">Dashboard</a> / <strong>Program PKL</strong></div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button class="view-all" type="submit">Keluar</button></form>
    </header>

    @if(session('success'))<div class="pkl-alert">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="pkl-alert" style="background:#eef2f5;color:#3e4e5e;">{{ $errors->first() }}</div>@endif

    <section class="pkl-hero">
        <div><div class="eyebrow" style="color:#c5dff2;">LAYANAN KARIER SISWA</div><h1 style="margin:8px 0;">Program PKL</h1><p style="margin:0;max-width:620px;color:#e4eff8;">Pilih tempat yang sesuai minatmu, kirim laporan, lalu pantau jadwal sidang dari satu halaman.</p></div>
        <div><span class="pkl-pill" style="background:{{ $setting->pkl_enabled ? '#dcecf8' : '#eef2f5' }};color:#214568;">{{ $setting->pkl_enabled ? 'PKL aktif' : 'PKL ditutup' }}</span><p style="margin:8px 0 0;color:#e4eff8;">Mode: {{ strtoupper($setting->school_level) }} @if($setting->period) &middot; {{ $setting->period }} @endif</p></div>
    </section>

    @if(!$setting->pkl_enabled)
        <section class="pkl-card pkl-section"><h2>Fitur PKL sedang ditutup</h2><p class="pkl-muted">Administrasi belum membuka pendaftaran PKL untuk jenjang {{ strtoupper($setting->school_level) }}.</p></section>
    @else
        <section class="pkl-section">
            <div class="panel-heading" style="margin-bottom: 20px;">
                <div>
                    <h2 style="margin: 0; font-size: 18px;">Tempat PKL Tersedia</h2>
                    <p class="pkl-muted" style="margin: 5px 0 0;">Pilih tempat yang sesuai minat dan kemampuanmu.</p>
                </div>
            </div>
            <form method="GET" action="{{ route('student.pkl') }}" class="pkl-filter-bar">
                <input name="q" value="{{ $filters['search'] }}" placeholder="Cari nama perusahaan, alamat, atau deskripsi...">
                <select name="major"><option value="">Semua jurusan</option>@foreach($majors as $item)<option value="{{ $item }}" @selected($filters['major'] === $item)>{{ $item }}</option>@endforeach</select>
                @if($setting->school_level === 'smk')
                    <select name="class_level"><option value="">Semua tingkat</option>@foreach(['10', '11', '12'] as $level)<option value="{{ $level }}" @selected($filters['classLevel'] === $level)>Kelas {{ $level }}</option>@endforeach</select>
                    <input name="class_number" value="{{ $filters['classNumber'] }}" placeholder="Nomor kelas">
                @endif
                <button class="pkl-button" type="submit">Cari</button>
            </form>
            <div class="pkl-grid">
                @php($lastClassLevel = null)
                @forelse($lokerPkls as $loker)
                    @if($setting->school_level === 'smk' && $lastClassLevel !== ($loker->class_level ?: 'Semua tingkat'))
                        @php($lastClassLevel = $loker->class_level ?: 'Semua tingkat')
                        <div class="pkl-class-heading">Kelas {{ $lastClassLevel }} <span>Lowongan untuk tingkat ini</span></div>
                    @endif
                    <article class="pkl-card">
                        <div class="pkl-card-image">
                            @if($loker->poster_path)
                                <img src="{{ Storage::url($loker->poster_path) }}" alt="{{ $loker->company_name }}">
                            @else
                                <div class="placeholder">
                                    <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M4 7h16v13H4z"/><path d="M8 7V4h8v3M8 12h8"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="pkl-card-body">
                            <span class="pkl-card-badge {{ $loker->is_featured ? 'featured' : '' }}">{{ $loker->school_level === 'smk' ? 'SMK' : 'SMA' }}</span>
                            @if($loker->major || $loker->class_number)<div class="pkl-card-meta"><span class="pkl-meta-tag">{{ $loker->major ?: 'Semua jurusan' }}</span>@if($loker->class_number)<span class="pkl-meta-tag">Kelas {{ $loker->class_level }} {{ $loker->class_number }}</span>@endif</div>@endif

                            <h3>{{ $loker->company_name }}</h3>

                            <p class="pkl-card-location">
                                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $loker->location }}
                            </p>

                            @if($loker->address)
                                <p class="pkl-card-location" style="font-size: 11px; color: #9aadbf;">
                                    {{ $loker->address }}
                                </p>
                            @endif

                            <p class="pkl-card-desc">{{ $loker->description }}</p>

                            <div class="pkl-card-meta">
                                <span class="pkl-meta-tag">
                                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    {{ $loker->quota - $loker->approved_applications }} kuota tersisa
                                </span>
                                @if($loker->application_deadline)
                                    <span class="pkl-meta-tag">
                                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg>
                                        Tutup {{ $loker->application_deadline->format('d M Y') }}
                                    </span>
                                @endif
                            </div>

                            <form class="pkl-form" action="{{ route('student.pkl.apply', $loker) }}" method="POST">
                                @csrf
                                <textarea name="motivation" rows="2" placeholder="Alasan memilih tempat ini (opsional)"></textarea>
                                <button class="pkl-button" type="submit">Pilih Tempat Ini</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="pkl-card"><div class="pkl-card-body"><h3>Belum ada rekomendasi</h3><p class="pkl-muted">Administrasi akan menambahkan tempat PKL yang sesuai untukmu.</p></div></div>
                @endforelse
            </div>
        </section>
    @endif

    <section class="pkl-section">
        <div class="panel-heading" style="margin-bottom: 20px;">
            <div>
                <h2 style="margin: 0; font-size: 18px;">Progres PKL Saya</h2>
                <p class="pkl-muted" style="margin: 5px 0 0;">Status pilihan, laporan, dan sidangmu.</p>
            </div>
        </div>
        <div class="pkl-grid">
            @forelse($applications as $application)
                <article class="pkl-card">
                    <div class="pkl-card-image">
                        @if($application->lokerPkl->poster_path)
                            <img src="{{ Storage::url($application->lokerPkl->poster_path) }}" alt="{{ $application->lokerPkl->company_name }}">
                        @else
                            <div class="placeholder">
                                <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M4 7h16v13H4z"/><path d="M8 7V4h8v3M8 12h8"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="pkl-card-body">
                        <span class="pkl-pill {{ $application->status === 'pending' ? 'pending' : ($application->status === 'rejected' ? 'rejected' : 'approved') }}">
                            Pilihan: {{ ucfirst($application->status) }}
                        </span>

                        <h3>{{ $application->lokerPkl->company_name }}</h3>

                        <p class="pkl-card-location">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $application->lokerPkl->location }}
                        </p>

                        @if($application->admin_note)
                            <div style="margin-top: 10px; padding: 10px; background: #fff8e6; border-radius: 8px; font-size: 12px; color: #856404;">
                                <strong>Catatan admin:</strong> {{ $application->admin_note }}
                            </div>
                        @endif

                        @if($application->status === 'approved')
                            @if($application->report)
                                <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #e3edf0;">
                                    <span class="pkl-pill {{ $application->report->status === 'pending' ? 'pending' : ($application->report->status === 'rejected' ? 'rejected' : 'approved') }}">
                                        Laporan: {{ ucfirst($application->report->status) }}
                                    </span>
                                    @if($application->report->feedback)
                                        <p class="pkl-muted" style="margin-top: 8px; font-size: 12px;">
                                            <strong>Feedback:</strong> {{ $application->report->feedback }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <form class="pkl-form" action="{{ route('student.pkl.report.store', $application) }}" method="POST" enctype="multipart/form-data" style="margin-top: 14px; padding-top: 14px; border-top: 1px solid #e3edf0;">
                                    @csrf
                                    <label class="pkl-muted" style="font-size: 12px;">Unggah laporan PKL</label>
                                    <input type="file" name="report" accept=".pdf,.doc,.docx" required>
                                    <button class="pkl-button secondary" type="submit">Kirim Laporan</button>
                                </form>
                            @endif

                            @if($application->report?->defense)
                                <div style="margin-top: 14px; padding: 14px; background: #e8f1fc; border-radius: 10px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="#2d6fdc" fill="none"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg>
                                        <strong style="color: #28547f;">Jadwal Sidang</strong>
                                    </div>
                                    <p style="margin: 0; font-size: 13px; color: #456a91;">
                                        <strong>{{ $application->report->defense->scheduled_at->format('d M Y, H:i') }}</strong><br>
                                        {{ $application->report->defense->room }} &bull; Penguji: {{ $application->report->defense->examiner }}
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>
                </article>
            @empty
                <div class="pkl-card"><div class="pkl-card-body"><h3>Belum ada pilihan tempat</h3><p class="pkl-muted">Pilih salah satu tempat PKL di atas untuk memulai proses.</p></div></div>
            @endforelse
        </div>
    </section>
</main>
</body>
</html>
