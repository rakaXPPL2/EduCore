@extends('layouts.admin')

@section('admin-content')
@php($breadcrumb = 'Data Guru')

<section class="welcome">
    <div>
        <div class="eyebrow">MANAJEMEN PENGGUNA</div>
        <h1>Data Guru <span style="color:#4f8df5;">.</span></h1>
        <p>Kelola akun dan data guru yang terdaftar dalam sistem.</p>
    </div>
</section>

<section class="panel page-panel">
    <div class="panel-heading">
        <div>
            <h2>Tambah Guru Baru</h2>
            <p>Daftarkan guru baru ke dalam sistem.</p>
        </div>
    </div>
    <form class="permit-form" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); display: grid; gap: 15px;" action="{{ route('admin.teachers.store') }}" method="POST">
        @csrf
        <label class="form-label">Nama lengkap
            <input class="form-control" name="name" required placeholder="Nama guru">
        </label>
        <label class="form-label">Email
            <input class="form-control" name="email" type="email" required placeholder="email@guru.sch.id">
        </label>
        <label class="form-label">Mata Pelajaran
            <input class="form-control" name="teacher_subject" placeholder="Contoh: Matematika">
        </label>
        <label class="form-label">NIP
            <input class="form-control" name="nip" placeholder="Nomor Induk Pegawai">
        </label>
        <label class="form-label">Password
            <input class="form-control" name="password" type="password" required minlength="6" placeholder="Min. 6 karakter">
        </label>
        <div style="display: flex; align-items: flex-end;">
            <button class="primary-button" type="submit">Daftarkan Guru</button>
        </div>
    </form>
</section>

<section class="panel page-panel" style="margin-top: 22px;">
    <div class="panel-heading">
        <div>
            <h2>Daftar Guru</h2>
            <p>Semua guru yang terdaftar dalam sistem.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <div class="search-box" style="position: relative;">
                <input type="text" id="searchTeachers" class="form-control" placeholder="Cari nama guru..." style="padding-left: 35px; width: 220px;">
                <svg viewBox="0 0 24 24" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; stroke: #7790ad; fill: none; stroke-width: 1.8;">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </div>
            <span class="soft-tag" id="teacherCount">{{ $teachers->count() }} guru</span>
        </div>
    </div>
    <div class="data-list" id="teacherList">
        @forelse($teachers as $teacher)
            <div class="data-row teacher-row" data-name="{{ strtolower($teacher->name) }}" data-subject="{{ strtolower($teacher->teacher_subject ?? '') }}">
                <div class="subject-icon violet">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div class="row-main">
                    <h3>{{ $teacher->name }}</h3>
                    <p>
                        {{ $teacher->email }}
                        @if($teacher->nip)
                            &bull; NIP: {{ $teacher->nip }}
                        @endif
                    </p>
                </div>
                <span class="soft-tag" style="background:#eeeaff; color:#8777df;">
                    {{ $teacher->teacher_subject ?: 'Guru' }}
                </span>
                <form action="{{ route('admin.users.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $teacher->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-button" style="width: 32px; height: 32px; background: #fff0e5; color: #e9945f;" title="Hapus">
                        <svg viewBox="0 0 24 24" width="14" height="14"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="empty-state" id="noTeachers">Belum ada guru terdaftar.</div>
        @endforelse
    </div>
</section>

<style>
.teacher-row.hidden {
    display: none;
}
</style>

<script>
document.getElementById('searchTeachers')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.teacher-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const name = row.dataset.name;
        const subject = row.dataset.subject;
        const shouldShow = name.includes(query) || subject.includes(query);
        row.classList.toggle('hidden', !shouldShow);
        if (shouldShow) visibleCount++;
    });

    document.getElementById('teacherCount').textContent = visibleCount + ' guru';
    document.getElementById('noTeachers')?.classList.toggle('hidden', visibleCount > 0 || rows.length === 0);
});
</script>
@endsection
