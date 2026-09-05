@extends('layouts.admin')

@section('admin-content')
@php($breadcrumb = 'Data Murid')

<section class="welcome">
    <div>
        <div class="eyebrow">MANAJEMEN PENGGUNA</div>
        <h1>Data Murid <span style="color:#4f8df5;">.</span></h1>
        <p>Kelola akun dan data murid yang terdaftar dalam sistem.</p>
    </div>
</section>

<section class="panel page-panel">
    <div class="panel-heading">
        <div>
            <h2>Tambah Murid Baru</h2>
            <p>Registrasikan murid baru ke dalam sistem.</p>
        </div>
    </div>
    <form class="permit-form" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); display: grid; gap: 15px;" action="{{ route('admin.students.store') }}" method="POST">
        @csrf
        <label class="form-label">Nama lengkap
            <input class="form-control" name="name" required placeholder="Nama murid">
        </label>
        <label class="form-label">Email
            <input class="form-control" name="email" type="email" required placeholder="email@siswa.sch.id">
        </label>
        <label class="form-label">NIS
            <input class="form-control" name="nis" placeholder="Nomor Induk Siswa">
        </label>
        <label class="form-label">Password
            <input class="form-control" name="password" type="password" required minlength="6" placeholder="Min. 6 karakter">
        </label>
        <label class="form-label">Kelas
            <select class="form-control" name="school_class_id">
                <option value="">Pilih kelas...</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }} - {{ $class->level }}</option>
                @endforeach
            </select>
        </label>
        <div style="display: flex; align-items: flex-end;">
            <button class="primary-button" type="submit">Daftarkan Murid</button>
        </div>
    </form>
</section>

<section class="panel page-panel" style="margin-top: 22px;">
    <div class="panel-heading">
        <div>
            <h2>Daftar Murid</h2>
            <p>Semua murid yang terdaftar dalam sistem.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <div class="search-box" style="position: relative;">
                <input type="text" id="searchStudents" class="form-control" placeholder="Cari nama murid..." style="padding-left: 35px; width: 220px;">
                <svg viewBox="0 0 24 24" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; stroke: #7790ad; fill: none; stroke-width: 1.8;">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </div>
            <span class="soft-tag" id="studentCount">{{ $students->count() }} murid</span>
        </div>
    </div>

    <div id="studentList">
        @php($groupedStudents = $students->groupBy(function($student) {
            if (!$student->schoolClass) return 'Belum Terklasifikasi';
            return $student->schoolClass->level;
        })->sortKeys())

        @foreach($groupedStudents as $level => $levelStudents)
            @php($levelStudents = $levelStudents->sortBy('name'))
            <div class="student-level-group" data-level="{{ $level }}">
                <div class="level-header">
                    <h3>Kelas {{ $level }}</h3>
                    <span class="soft-tag">{{ $levelStudents->count() }} murid</span>
                </div>

                @php($byClass = $levelStudents->groupBy(function($s) {
                    return $s->schoolClass?->name ?? 'Belum Ada Kelas';
                })->sortKeys())

                @foreach($byClass as $className => $classStudents)
                    <div class="student-class-group" data-class="{{ $className }}">
                        <div class="class-header">
                            <span>{{ $className }}</span>
                            <span class="soft-tag" style="font-size: 9px;">{{ $classStudents->count() }} siswa</span>
                        </div>

                        <div class="data-list">
                            @foreach($classStudents as $student)
                                <div class="data-row student-row" data-name="{{ strtolower($student->name) }}">
                                    <div class="subject-icon">
                                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                    </div>
                                    <div class="row-main">
                                        <h3>{{ $student->name }}</h3>
                                        <p>
                                            {{ $student->email }}
                                            @if($student->nis)
                                                &bull; NIS: {{ $student->nis }}
                                            @endif
                                        </p>
                                    </div>
                                    <form action="{{ route('admin.users.destroy', $student) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $student->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button" style="width: 32px; height: 32px; background: #fff0e5; color: #e9945f;" title="Hapus">
                                            <svg viewBox="0 0 24 24" width="14" height="14"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        @if($groupedStudents->isEmpty() || ($groupedStudents->has('Belum Terklasifikasi') && $groupedStudents->count() == 1))
            <div class="empty-state" id="noStudents">Belum ada murid terdaftar.</div>
        @endif
    </div>
</section>

<style>
.student-level-group {
    margin-bottom: 25px;
}
.level-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    background: linear-gradient(135deg, #e8f1ff, #f5f9ff);
    border-radius: 12px;
    margin-bottom: 12px;
}
.level-header h3 {
    margin: 0;
    color: #28547f;
    font-size: 15px;
}
.class-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    background: #f0f5fa;
    border-radius: 10px;
    margin: 15px 0 10px;
    font-weight: 600;
    color: #456a91;
    font-size: 12px;
}
.class-header .soft-tag {
    margin-left: auto;
}
.search-highlight {
    background: #fef3c7;
    padding: 0 2px;
    border-radius: 3px;
}
.student-row.hidden {
    display: none;
}
.student-level-group.hidden,
.student-class-group.hidden {
    display: none;
}
</style>

<script>
document.getElementById('searchStudents')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const name = row.dataset.name;
        const shouldShow = name.includes(query);
        row.classList.toggle('hidden', !shouldShow);
        if (shouldShow) visibleCount++;
    });

    // Update counts
    document.querySelectorAll('.student-level-group').forEach(group => {
        const visibleRows = group.querySelectorAll('.student-row:not(.hidden)');
        group.classList.toggle('hidden', visibleRows.length === 0);

        // Update level count
        const levelCount = group.querySelector('.level-header .soft-tag');
        if (levelCount) levelCount.textContent = visibleRows.length + ' murid';
    });

    document.querySelectorAll('.student-class-group').forEach(group => {
        const visibleRows = group.querySelectorAll('.student-row:not(.hidden)');
        group.classList.toggle('hidden', visibleRows.length === 0);

        // Update class count
        const classCount = group.querySelector('.class-header .soft-tag');
        if (classCount) classCount.textContent = visibleRows.length + ' siswa';
    });

    document.getElementById('studentCount').textContent = visibleCount + ' murid';
    document.getElementById('noStudents')?.classList.toggle('hidden', visibleCount > 0 || rows.length === 0);
});
</script>
@endsection
