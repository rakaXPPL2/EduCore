@extends('layouts.admin')

@section('admin-content')
<section class="welcome">
    <div>
        <div class="eyebrow">{{ now()->translatedFormat('l, d F Y') }}</div>
        <h1>Selamat datang, {{ auth()->user()->name }} <span style="color:#4f8df5;">.</span></h1>
        <p>Pantau seluruh aktivitas dan kelola data akademik sekolah.</p>
    </div>
    <div class="date-badge">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4M8 2v4M3 9h18"/></svg>
        Semester Ganjil &nbsp;&bull;&nbsp; 2026/2027
    </div>
</section>

<section class="metric-grid">
    <div class="metric-card">
        <div class="metric-top">
            <span>Total Murid</span>
            <span class="metric-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </span>
        </div>
        <div class="metric-value">{{ $stats['students'] }}</div>
        <div class="metric-note">Siswa terdaftar</div>
    </div>
    <div class="metric-card">
        <div class="metric-top">
            <span>Total Guru</span>
            <span class="metric-icon">
                <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </span>
        </div>
        <div class="metric-value">{{ $stats['teachers'] }}</div>
        <div class="metric-note">Guru aktif</div>
    </div>
    <div class="metric-card">
        <div class="metric-top">
            <span>Kelas</span>
            <span class="metric-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </span>
        </div>
        <div class="metric-value">{{ $stats['classes'] }}</div>
        <div class="metric-note">Rombel aktif</div>
    </div>
    <div class="metric-card">
        <div class="metric-top">
            <span>Menunggu Tindakan</span>
            <span class="metric-icon" style="background:#fff0e5; color:#e9945f;">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
            </span>
        </div>
        <div class="metric-value">{{ $stats['pendingPermits'] + $stats['pendingPkl'] }}</div>
        <div class="metric-note">{{ $stats['pendingPermits'] }} izin, {{ $stats['pendingPkl'] }} PKL</div>
    </div>
</section>

{{-- Overview Kelas --}}
<section class="panel page-panel">
    <div class="panel-heading">
        <div>
            <h2>Ringkasan Kelas</h2>
            <p>Distribusi siswa berdasarkan tingkat dan rombel.</p>
        </div>
        <a class="view-all" href="{{ route('admin.students') }}">Lihat semua murid &rarr;</a>
    </div>
    <div class="class-overview">
        @foreach($classesByLevel as $level => $levelClasses)
            <div class="class-level-section">
                <div class="class-level-header">
                    <h3>Kelas {{ $level }}</h3>
                    <span class="soft-tag">{{ $levelClasses->sum('students_count') }} siswa</span>
                </div>
                <div class="class-cards">
                    @foreach($levelClasses as $class)
                        <div class="class-mini-card">
                            <div class="class-mini-icon">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <div class="class-mini-info">
                                <strong>{{ $class->name }}</strong>
                                <small>{{ $class->homeroomTeacher?->name ?? 'Belum ada wali kelas' }}</small>
                            </div>
                            <div class="class-mini-count">
                                <span>{{ $class->students_count }}</span>
                                <small>siswa</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        @if($classesByLevel->isEmpty())
            <div class="empty-state">Belum ada kelas dibuat.</div>
        @endif
    </div>
</section>

<div class="content-grid">
    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Murid Terbaru</h2>
                <p>Registrasi murid baru dalam sistem.</p>
            </div>
            <a class="view-all" href="{{ route('admin.students') }}">Lihat semua &rarr;</a>
        </div>
        <div class="data-list">
            @forelse($recentStudents as $student)
                <div class="data-row">
                    <div class="subject-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div class="row-main">
                        <h3>{{ $student->name }}</h3>
                        <p>{{ $student->schoolClass?->name ?: 'Belum ada kelas' }} &bull; {{ $student->email }}</p>
                    </div>
                    <span class="soft-tag">{{ $student->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <div class="empty-state">Belum ada murid terdaftar.</div>
            @endforelse
        </div>
    </section>

    <aside>
        <section class="panel">
            <div class="panel-heading">
                <div>
                    <h2>Izin Menunggu</h2>
                    <p>Pengajuan surat izin yang perlu ditinjau.</p>
                </div>
            </div>
            <div class="data-list">
                @forelse($recentPermits as $permit)
                    <div class="data-row">
                        <div class="subject-icon mint">
                            <svg viewBox="0 0 24 24"><path d="M5 4h14v16H5z"/><path d="M8 8h8M8 12h5M8 16h7"/></svg>
                        </div>
                        <div class="row-main">
                            <h3>{{ $permit->student_name }}</h3>
                            <p>{{ $permit->type }} &bull; {{ $permit->permit_date->format('d M Y') }}</p>
                        </div>
                        <span class="soft-tag" style="color:#e9945f; background:#fff0e5;">{{ ucfirst($permit->status) }}</span>
                    </div>
                @empty
                    <div class="empty-state">Tidak ada izin menuggu.</div>
                @endforelse
            </div>
        </section>

        <section class="panel" style="margin-top: 22px;">
            <div class="panel-heading">
                <div>
                    <h2>Guru Terbaru</h2>
                    <p>Daftar guru yang baru bergabung.</p>
                </div>
                <a class="view-all" href="{{ route('admin.teachers') }}">Lihat semua &rarr;</a>
            </div>
            <div class="data-list">
                @forelse($recentTeachers as $teacher)
                    <div class="data-row">
                        <div class="subject-icon violet">
                            <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                        </div>
                        <div class="row-main">
                            <h3>{{ $teacher->name }}</h3>
                            <p>{{ $teacher->teacher_subject ?: 'Guru' }} &bull; {{ $teacher->email }}</p>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">Belum ada guru terdaftar.</div>
                @endforelse
            </div>
        </section>

        <section class="panel" style="margin-top: 22px;">
            <div class="panel-heading">
                <div>
                    <h2>Aksi Cepat</h2>
                    <p>Tindakan administratif sering digunakan.</p>
                </div>
            </div>
            <div class="quick-actions">
                <a class="quick-action" href="{{ route('admin.students') }}">
                    <span><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                    <div>
                        <strong>Tambah Murid</strong>
                        <small>Registrasi siswa baru</small>
                    </div>
                </a>
                <a class="quick-action" href="{{ route('admin.teachers') }}">
                    <span><svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg></span>
                    <div>
                        <strong>Tambah Guru</strong>
                        <small>Daftarkan guru baru</small>
                    </div>
                </a>
                <a class="quick-action" href="{{ route('admin.classes') }}">
                    <span><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></span>
                    <div>
                        <strong>Kelola Kelas</strong>
                        <small>Atur rombel & wali kelas</small>
                    </div>
                </a>
                <a class="quick-action" href="{{ route('admin.pkl') }}">
                    <span><svg viewBox="0 0 24 24"><path d="M4 7h16v13H4z"/><path d="M8 7V4h8v3M8 12h8M8 16h5"/></svg></span>
                    <div>
                        <strong>Program PKL</strong>
                        <small>Kelola magang siswa</small>
                    </div>
                </a>
            </div>
        </section>
    </aside>
</div>

<style>
.class-overview {
    display: grid;
    gap: 20px;
}
.class-level-section {
    background: rgba(232, 241, 255, .5);
    border-radius: 14px;
    padding: 16px;
}
.class-level-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}
.class-level-header h3 {
    margin: 0;
    color: #28547f;
    font-size: 14px;
}
.class-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
}
.class-mini-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: white;
    border: 1px solid rgba(205, 221, 239, .45);
    border-radius: 12px;
}
.class-mini-icon {
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    background: #e4efff;
    color: #3b7eee;
}
.class-mini-icon svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
}
.class-mini-info {
    flex: 1;
    min-width: 0;
}
.class-mini-info strong {
    display: block;
    color: #28547f;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.class-mini-info small {
    display: block;
    color: #91a5bc;
    font-size: 9px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.class-mini-count {
    text-align: center;
    padding: 6px 10px;
    background: #f0f5fa;
    border-radius: 8px;
}
.class-mini-count span {
    display: block;
    font: 700 16px 'Space Grotesk', sans-serif;
    color: #3277e6;
}
.class-mini-count small {
    display: block;
    color: #91a5bc;
    font-size: 8px;
}
</style>
@endsection
