@extends('layouts.admin')

@section('admin-content')
@php($breadcrumb = 'Kelas & Rombel')

<section class="welcome">
    <div>
        <div class="eyebrow">ADMINISTRASI AKADEMIK</div>
        <h1>Kelola Kelas & Rombel <span style="color:#4f8df5;">.</span></h1>
        <p>Tentukan wali kelas dan pantau jumlah murid di setiap rombel.</p>
    </div>
</section>

<div class="permit-layout">
    <section class="panel page-panel">
        <div class="panel-heading">
            <div>
                <h2>Buat Kelas Baru</h2>
                <p>Wali kelas dapat mengawasi komunikasi dan progres rombel.</p>
            </div>
        </div>
        <form class="permit-form" action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            <label class="form-label">Nama kelas
                <input class="form-control" name="name" placeholder="Contoh: XI RPL 3" required>
            </label>
            <label class="form-label">Tingkat
                <select class="form-control" name="level" required>
                    <option value="">Pilih tingkat...</option>
                    <option value="X">Kelas X</option>
                    <option value="XI">Kelas XI</option>
                    <option value="XII">Kelas XII</option>
                </select>
            </label>
            <label class="form-label">Wali kelas
                <select class="form-control" name="homeroom_teacher_id" required>
                    <option value="">Pilih wali kelas...</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }} &bull; {{ $teacher->teacher_subject }}</option>
                    @endforeach
                </select>
            </label>
            <button class="primary-button" type="submit">Simpan kelas & wali</button>
        </form>
    </section>

    <section class="panel page-panel">
        <div class="panel-heading">
            <div>
                <h2>Rombel Terdaftar</h2>
                <p>Data kelas yang dibuat admin.</p>
            </div>
            <span class="soft-tag">{{ $classes->count() }} kelas</span>
        </div>
        <div class="data-list">
            @forelse($classes as $class)
                <div class="data-row">
                    <div class="subject-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    </div>
                    <div class="row-main">
                        <h3>{{ $class->name }}</h3>
                        <p>Tingkat {{ $class->level }} &bull; Wali kelas: {{ $class->homeroomTeacher?->name ?: 'Belum ditentukan' }}</p>
                    </div>
                    <span class="soft-tag" style="background:#e4f7f1; color:#42ad91;">
                        {{ $class->students_count }} murid
                    </span>
                </div>
            @empty
                <div class="empty-state">Belum ada kelas.</div>
            @endforelse
        </div>
    </section>
</div>
@endsection
