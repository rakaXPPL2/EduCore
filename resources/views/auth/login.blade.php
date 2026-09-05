<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCore | Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <main class="auth-shell">
        <section class="auth-intro">
            <a href="{{ url('/') }}" class="auth-brand"><span>E</span><strong>EduCore</strong></a>
            <div class="auth-copy"><span class="eyebrow">PORTAL SEKOLAH DIGITAL</span><h1>Belajar lebih terarah, tumbuh lebih percaya diri.</h1><p>Satu ruang untuk tugas, nilai, jadwal, dan perjalananmu menuju masa depan.</p></div>
            <div class="auth-orbit"><div class="orbit-card orbit-card-main"><strong>EduCoach</strong><span>72% kesiapan belajar</span><i></i></div><div class="orbit-card orbit-card-mini">✦</div></div>
        </section>
        <section class="auth-card">
            <div class="auth-card-heading"><span class="eyebrow">SELAMAT DATANG KEMBALI</span><h2>Masuk ke portal</h2><p>Pilih jenis akunmu untuk melanjutkan.</p></div>
            @if ($errors->any())<div class="auth-error">{{ $errors->first() }}</div>@endif
            <form action="{{ route('login.store') }}" method="POST" class="auth-form">
                @csrf
                <div class="role-switch"><label><input type="radio" name="role" value="student" @checked(old('role', 'student') === 'student')><span><b>◒</b>Murid<small>Ruang belajar</small></span></label><label><input type="radio" name="role" value="teacher" @checked(old('role') === 'teacher')><span><b>◉</b>Guru<small>Ruang mengajar</small></span></label><label><input type="radio" name="role" value="admin" @checked(old('role') === 'admin')><span><b>◆</b>Admin<small>Kelola sekolah</small></span></label></div>
                <label class="form-label">Email<input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="nama@sekolah.sch.id" required autofocus></label>
                <label class="form-label">Password<input class="form-control" type="password" name="password" placeholder="Masukkan password" required></label>
                <label class="remember-row"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
                <button class="primary-button" type="submit">Masuk ke portal &rarr;</button>
            </form>
            <p class="auth-demo">Demo murid: <strong>murid@educore.test</strong> / password<br>Demo guru: <strong>guru@educore.test</strong> / password<br>Demo admin: <strong>admin@educore.test</strong> / password</p>
        </section>
    </main>
</body>
</html>
