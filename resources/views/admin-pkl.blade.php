@extends('layouts.admin')

@section('admin-content')
@php($breadcrumb = 'Manajemen PKL')

<section class="welcome">
    <div>
        <div class="eyebrow">ADMINISTRASI PROGRAM</div>
        <h1>Manajemen PKL <span style="color:#4f8df5;">.</span></h1>
        <p>Atur jenjang, proses pilihan murid, periksa laporan, dan jadwalkan sidang.</p>
    </div>
</section>

<div class="pkl-layout" style="display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr); gap: 22px;">
    <div style="display: grid; gap: 22px; align-content: start;">
        <section class="panel page-panel">
            <div class="panel-heading">
                <div>
                    <h2>Pengaturan Program</h2>
                    <p>Untuk SMA, program otomatis ditutup. Untuk SMK, admin dapat membukanya saat periode siap.</p>
                </div>
            </div>
            <form class="permit-form" action="{{ route('admin.pkl.settings.update') }}" method="POST">
                @csrf
                <label class="form-label">Jenjang
                    <select class="form-control" name="school_level">
                        <option value="smk" @selected($setting->school_level === 'smk')>SMK - memiliki PKL</option>
                        <option value="sma" @selected($setting->school_level === 'sma')>SMA - tanpa fitur PKL</option>
                    </select>
                </label>
                <label class="form-label">Periode
                    <input class="form-control" name="period" value="{{ $setting->period }}" placeholder="Contoh: 2026/2027">
                </label>
                <label class="form-label">Tanggal mulai sidang
                    <input class="form-control" type="date" name="defense_start_date" value="{{ $setting->defense_start_date?->format('Y-m-d') }}">
                </label>
                <label class="form-label" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #eaf2fc; border-radius: 11px;">
                    <input type="checkbox" name="pkl_enabled" value="1" @checked($setting->pkl_enabled) style="width: auto; margin: 0;">
                    <span>Buka fitur PKL untuk siswa</span>
                </label>
                <button class="primary-button" type="submit">Simpan pengaturan</button>
            </form>
        </section>

        {{-- Saran PKL dari Guru --}}
        @if($pendingSuggestions->count() > 0)
        <section class="panel page-panel" style="border-left: 4px solid #4f8df5;">
            <div class="panel-heading">
                <div>
                        <h2 style="color: #28547f;">Saran dari Guru</h2>
                    <p>{{ $pendingSuggestions->count() }} saran menunggu persetujuan.</p>
                </div>
            </div>
            <div class="suggestion-list">
                @foreach($pendingSuggestions as $suggestion)
                    <div class="suggestion-card">
                        @if($suggestion->poster_path)
                            <img src="{{ Storage::url($suggestion->poster_path) }}" alt="Poster" class="suggestion-poster">
                        @endif
                        <div class="suggestion-content">
                            <h4>{{ $suggestion->company_name }}</h4>
                            <p class="suggestion-meta">
                                <svg viewBox="0 0 24 24" width="12" height="12"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $suggestion->location }}
                                @if($suggestion->address)
                                    - {{ $suggestion->address }}
                                @endif
                            </p>
                            <p class="suggestion-desc">{{ Str::limit($suggestion->description, 100) }}</p>
                            <div class="suggestion-author">
                                <svg viewBox="0 0 24 24" width="12" height="12"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                Disarankan oleh: {{ $suggestion->suggestedBy?->name ?? 'Guru' }}
                            </div>
                            <div class="suggestion-actions">
                                <form action="{{ route('admin.pkl.suggest.approve', $suggestion) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="primary-button" style="width: auto; padding: 8px 16px; font-size: 11px;">Setujui</button>
                                </form>
                                <form action="{{ route('admin.pkl.suggest.reject', $suggestion) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="primary-button" style="width: auto; padding: 8px 16px; font-size: 11px; background: linear-gradient(135deg, #94a3b8, #64748b);">Tolak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        <section class="panel page-panel">
            <div class="panel-heading">
                <div>
                    <h2>Tambah Tempat PKL</h2>
                    <p>Tempat ini akan muncul di halaman pilihan murid.</p>
                </div>
            </div>
            <form class="permit-form" action="{{ route('admin.pkl.lokers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="form-label">Poster / Foto Tempat
                    <div class="upload-zone" style="text-align: left;">
                        <input type="file" name="poster" accept="image/*" id="posterInput" onchange="previewPoster(this)">
                        <label for="posterInput" style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                            <svg viewBox="0 0 24 24" width="24" height="24" style="stroke: #7694b6; fill: none; stroke-width: 1.8;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                            <span id="posterLabel">Pilih poster atau foto tempat...</span>
                        </label>
                    </div>
                </label>
                <div id="posterPreview" style="display: none; margin-top: 10px;">
                    <img id="previewImage" style="max-width: 100%; max-height: 150px; border-radius: 10px; border: 1px solid #d8e1ea;">
                </div>
                <label class="form-label">Nama perusahaan
                    <input class="form-control" name="company_name" required placeholder="Contoh: PT Digital Garut">
                </label>
                <label class="form-label">Lokasi
                    <input class="form-control" name="location" required placeholder="Garut / Bandung">
                </label>
                <label class="form-label">Jurusan sasaran
                    <input class="form-control" name="major" placeholder="Contoh: RPL, TKJ, Akuntansi">
                </label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;"><label class="form-label">Tingkat kelas
                    <select class="form-control" name="class_level"><option value="">Semua tingkat</option><option value="10">Kelas 10</option><option value="11">Kelas 11</option><option value="12">Kelas 12</option></select>
                </label><label class="form-label">Nomor kelas
                    <input class="form-control" name="class_number" placeholder="Contoh: 1 atau 2">
                </label></div>
                <label class="form-label">Alamat lengkap
                    <input class="form-control" name="address" placeholder="Jl. Raya, No., Kota">
                </label>
                <label class="form-label">Deskripsi
                    <textarea class="form-control" name="description" rows="3" required placeholder="Bidang kerja, skill, dan kriteria siswa"></textarea>
                </label>
                <label class="form-label">Kuota
                    <input class="form-control" name="quota" type="number" min="1" value="1" required>
                </label>
                <label class="form-label">Batas pendaftaran
                    <input class="form-control" name="application_deadline" type="date">
                </label>
                <label class="form-label" style="display: flex; align-items: center; gap: 10px; padding: 12px; background: #fff0e5; border-radius: 11px;">
                    <input type="checkbox" name="is_featured" value="1" style="width: auto; margin: 0;">
                    <span>Tampilkan sebagai rekomendasi utama</span>
                </label>
                <button class="primary-button" type="submit">Publikasikan Tempat PKL</button>
            </form>
        </section>
    </div>

    <div style="display: grid; gap: 22px; align-content: start;">
        <section class="panel page-panel">
            <div class="panel-heading">
                <div>
                    <h2>Daftar Tempat PKL</h2>
                    <p>{{ $lokerPkls->count() }} tempat tersedia.</p>
                </div>
            </div>

            {{-- Card Grid --}}
            <div class="pkl-card-grid">
                @forelse($lokerPkls as $loker)
                    <div class="pkl-card {{ $loker->is_featured ? 'featured' : '' }}">
                        @if($loker->poster_path)
                            <div class="pkl-card-image">
                                <img src="{{ Storage::url($loker->poster_path) }}" alt="{{ $loker->company_name }}">
                            </div>
                        @endif
                        <div class="pkl-card-body">
                            <div class="pkl-card-header">
                                <h3>{{ $loker->company_name }}</h3>
                                @if($loker->is_featured)
                                    <span class="featured-badge">Rekomendasi</span>
                                @endif
                            </div>
                            <p class="pkl-card-location">
                                <svg viewBox="0 0 24 24" width="12" height="12"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $loker->location }}
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px;"><span class="soft-tag" style="background:#eaf2fc; color:#28547f;">{{ $loker->major ?: 'Semua jurusan' }}</span>@if($loker->class_level)<span class="soft-tag" style="background:#f1f5f9; color:#566575;">Kelas {{ $loker->class_level }}@if($loker->class_number) {{ $loker->class_number }}@endif</span>@endif</div>
                            @if($loker->address)
                                <p class="pkl-card-address">{{ $loker->address }}</p>
                            @endif
                            <p class="pkl-card-desc">{{ Str::limit($loker->description, 80) }}</p>
                            <div class="pkl-card-footer">
                                <span class="soft-tag" style="background:#e4f7f1; color:#42ad91;">
                                    <svg viewBox="0 0 24 24" width="10" height="10" style="display: inline;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    {{ $loker->applications_count }} / {{ $loker->quota }} kuota
                                </span>
                                @if($loker->suggested_by)
                                    <span class="soft-tag" style="background:#fff0e5; color:#e9945f;">Dari Guru</span>
                                @endif
                                <form action="{{ route('admin.pkl.destroy', $loker) }}" method="POST" onsubmit="return confirm('Hapus tempat PKL ini?')" style="margin-left: auto;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-button" style="width: 28px; height: 28px; background: #fff0e5; color: #e9945f;">
                                        <svg viewBox="0 0 24 24" width="12" height="12"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">Belum ada tempat PKL.</div>
                @endforelse
            </div>
        </section>

        <section class="panel page-panel">
            <div class="panel-heading">
                <div>
                    <h2>Pilihan Tempat Murid</h2>
                    <p>Setujui pilihan agar murid dapat mengirim laporan.</p>
                </div>
                @php($pendingCount = $applications->where('status', 'pending')->count())
                @if($pendingCount > 0)
                    <span class="soft-tag" style="background:#fff0e5; color:#e9945f;">{{ $pendingCount }} menunggu</span>
                @endif
            </div>
            <div class="data-list">
                @forelse($applications as $application)
                    <div class="data-row" style="flex-direction: column; align-items: stretch;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div class="subject-icon">
                                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <div class="row-main">
                                <h3>{{ $application->student->name }}</h3>
                                <p>{{ $application->lokerPkl->company_name }} &bull; {{ $application->lokerPkl->location }}</p>
                            </div>
                            <span class="soft-tag @if($application->status === 'approved') tag-good @elseif($application->status === 'rejected') @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        @if($application->motivation)
                            <p style="margin: 10px 0 0 57px; color: #7790ad; font-size: 11px;">
                                <strong>Alasan:</strong> {{ $application->motivation }}
                            </p>
                        @endif
                        @if($application->status === 'pending')
                            <form class="permit-form" style="margin-top: 15px; padding-left: 57px;" action="{{ route('admin.pkl.applications.decide', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input class="form-control" name="admin_note" placeholder="Catatan untuk murid (opsional)" style="margin-bottom: 10px;">
                                <div style="display: flex; gap: 8px;">
                                    <button class="primary-button" name="status" value="approved" type="submit" style="width: auto; padding: 10px 18px;">Setujui</button>
                                    <button class="primary-button" name="status" value="rejected" type="submit" style="width: auto; padding: 10px 18px; background: linear-gradient(135deg, #94a3b8, #64748b);">Tolak</button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">Belum ada pilihan murid.</div>
                @endforelse
            </div>
        </section>

        <section class="panel page-panel">
            <div class="panel-heading">
                <div>
                    <h2>Pemeriksaan Laporan & Sidang</h2>
                    <p>Periksa laporan yang dikirim murid sebelum membuat jadwal sidang.</p>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.pkl') }}" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 18px;"><input class="form-control" name="student" value="{{ $filters['studentSearch'] }}" placeholder="Cari nama murid..."><input class="form-control" name="teacher" value="{{ $filters['teacherSearch'] }}" placeholder="Cari nama guru pengusul..."><button class="primary-button" type="submit" style="width: auto;">Cari</button></form>
            <div class="data-list">
                @forelse($reports as $report)
                    <div class="data-row" style="flex-direction: column; align-items: stretch;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div class="subject-icon violet">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                            </div>
                            <div class="row-main">
                                <h3>{{ $report->application->student->name }}</h3>
                                <p>
                                    {{ $report->application->lokerPkl->company_name }} &bull;
                                    <a href="{{ Storage::url($report->report_path) }}" target="_blank" style="color: #4f8df5;">Buka laporan</a>
                                </p>
                            </div>
                            <span class="soft-tag @if($report->status === 'approved') tag-good @elseif($report->status === 'rejected') @endif">
                                {{ ucfirst($report->status) }}
                            </span>
                        </div>
                        <form class="permit-form" style="margin-top: 15px; padding-left: 57px;" action="{{ route('admin.pkl.reports.review', $report) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea class="form-control" name="feedback" rows="2" placeholder="Feedback pemeriksaan">{{ $report->feedback }}</textarea>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px;">
                                <button class="primary-button" name="status" value="approved" type="submit" style="width: auto; padding: 10px 18px;">Setujui</button>
                                <button class="primary-button" name="status" value="revision" type="submit" style="width: auto; padding: 10px 18px; background: linear-gradient(135deg, #fbbf24, #f59e0b);">Minta Revisi</button>
                                <button class="primary-button" name="status" value="rejected" type="submit" style="width: auto; padding: 10px 18px; background: linear-gradient(135deg, #94a3b8, #64748b);">Tolak</button>
                            </div>
                        </form>
                        @if($report->status === 'approved')
                            <form class="permit-form" style="margin-top: 15px; padding: 15px; background: #eaf2fc; border-radius: 12px;" action="{{ route('admin.pkl.defenses.schedule', $report) }}" method="POST">
                                @csrf
                                <h4 style="margin: 0 0 12px; color: #28547f; font-size: 13px;">Jadwalkan Sidang</h4>
                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                                    <label class="form-label">Tanggal & Waktu
                                        <input class="form-control" type="datetime-local" name="scheduled_at" required>
                                    </label>
                                    <label class="form-label">Ruangan
                                        <input class="form-control" name="room" required placeholder="Ruang sidang">
                                    </label>
                                    <label class="form-label">Penguji
                                        <input class="form-control" name="examiner" required placeholder="Nama penguji">
                                    </label>
                                </div>
                                <button class="primary-button" type="submit" style="margin-top: 10px;">Jadwalkan Sidang</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">Belum ada laporan untuk diperiksa.</div>
                @endforelse
            </div>
        </section>
    </div>
</div>

<style>
@media (max-width: 900px) {
    .pkl-layout { grid-template-columns: 1fr !important; }
}

.pkl-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
}

.pkl-card {
    border: 1px solid rgba(205, 221, 239, .45);
    border-radius: 16px;
    overflow: hidden;
    background: rgba(247, 251, 255, .7);
    transition: .2s ease;
}

.pkl-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(185, 204, 229, .45);
}

.pkl-card.featured {
    border: 2px solid #4f8df5;
    box-shadow: 0 4px 16px rgba(79, 141, 245, .2);
}

.pkl-card-image {
    height: 140px;
    overflow: hidden;
    background: #eaf2fc;
}

.pkl-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pkl-card-body {
    padding: 14px;
}

.pkl-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 8px;
}

.pkl-card-header h3 {
    margin: 0;
    color: #28547f;
    font-size: 14px;
    font-weight: 600;
}

.featured-badge {
    background: linear-gradient(135deg, #4f8df5, #377cf6);
    color: white;
    font-size: 9px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    white-space: nowrap;
}

.pkl-card-location {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #7790ad;
    font-size: 11px;
    margin: 0 0 6px;
}

.pkl-card-location svg {
    stroke: currentColor;
    fill: none;
}

.pkl-card-address {
    color: #9aadbf;
    font-size: 10px;
    margin: 0 0 8px;
}

.pkl-card-desc {
    color: #91a5bc;
    font-size: 11px;
    margin: 0 0 12px;
    line-height: 1.4;
}

.pkl-card-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.suggestion-list {
    display: grid;
    gap: 16px;
}

.suggestion-card {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 14px;
    padding: 14px;
    background: rgba(255, 240, 229, .5);
    border: 1px solid rgba(233, 148, 95, .2);
    border-radius: 14px;
}

.suggestion-poster {
    width: 140px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
}

.suggestion-content h4 {
    margin: 0 0 6px;
    color: #28547f;
    font-size: 14px;
}

.suggestion-meta {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #7790ad;
    font-size: 10px;
    margin: 0 0 6px;
}

.suggestion-meta svg {
    stroke: currentColor;
    fill: none;
}

.suggestion-desc {
    color: #91a5bc;
    font-size: 11px;
    margin: 0 0 10px;
}

.suggestion-author {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #e9945f;
    font-size: 10px;
    margin-bottom: 10px;
}

.suggestion-author svg {
    stroke: currentColor;
    fill: none;
}

.suggestion-actions {
    display: flex;
    gap: 8px;
}

@media (max-width: 600px) {
    .suggestion-card {
        grid-template-columns: 1fr;
    }
    .suggestion-poster {
        width: 100%;
        height: 120px;
    }
    .pkl-card-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function previewPoster(input) {
    const preview = document.getElementById('posterPreview');
    const previewImage = document.getElementById('previewImage');
    const label = document.getElementById('posterLabel');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
        label.textContent = input.files[0].name;
    } else {
        preview.style.display = 'none';
        label.textContent = 'Pilih poster atau foto tempat...';
    }
}
</script>
@endsection
