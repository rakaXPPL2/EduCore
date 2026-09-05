@extends('layouts.admin')

@section('admin-content')
@php($breadcrumb = 'Saran PKL')

<section class="welcome">
    <div>
        <div class="eyebrow">PROGRAM PKL</div>
        <h1>Saran Tempat PKL <span style="color:#4f8df5;">.</span></h1>
        <p>Ajukan tempat PKL yang Anda ketahui untuk direkomendasikan ke murid.</p>
    </div>
</section>

<section class="panel page-panel">
    <div class="panel-heading">
        <div>
            <h2>Ajukan Tempat PKL Baru</h2>
            <p>Saran Anda akan ditinjau oleh admin sebelum dipublikasikan.</p>
        </div>
    </div>
    <form class="permit-form" action="{{ route('teacher.pkl.suggest.store') }}" method="POST" enctype="multipart/form-data">
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
            <textarea class="form-control" name="description" rows="3" required placeholder="Bidang kerja, skill yang dipelajari, dan kriteria siswa"></textarea>
        </label>
        <label class="form-label">Kuota siswa
            <input class="form-control" name="quota" type="number" min="1" value="1" required style="width: 120px;">
        </label>
        <label class="form-label">Batas pendaftaran
            <input class="form-control" name="application_deadline" type="date">
        </label>
        <button class="primary-button" type="submit">Kirim Saran</button>
    </form>
</section>

@if($mySuggestions->count() > 0)
<section class="panel page-panel" style="margin-top: 22px;">
    <div class="panel-heading">
        <div>
            <h2>Saran Saya</h2>
            <p>{{ $mySuggestions->count() }} saran yang masih menunggu persetujuan.</p>
        </div>
    </div>
    <div class="data-list">
        @foreach($mySuggestions as $suggestion)
            <div class="data-row">
                @if($suggestion->poster_path)
                    <img src="{{ Storage::url($suggestion->poster_path) }}" alt="Poster" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                @else
                    <div class="subject-icon">
                        <svg viewBox="0 0 24 24"><path d="M4 7h16v13H4z"/><path d="M8 7V4h8v3M8 12h8"/></svg>
                    </div>
                @endif
                <div class="row-main">
                    <h3>{{ $suggestion->company_name }}</h3>
                    <p>{{ $suggestion->location }} &bull; {{ $suggestion->description }}</p>
                </div>
                <span class="soft-tag" style="background:#fff0e5; color:#e9945f;">Menunggu</span>
            </div>
        @endforeach
    </div>
</section>
@endif

<style>
.pkl-admin { max-width: 1240px; margin: 0 auto; padding: 28px; }
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
