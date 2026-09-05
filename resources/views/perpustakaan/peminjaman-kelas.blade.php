@extends('layouts.perpustakaan')

@section('content')
<div class="perpus-page-heading"><div><p class="perpus-kicker">RUANG GURU</p><h1>Paket buku untuk kelas</h1><p>Pilih koleksi yang ingin disiapkan untuk kegiatan belajar satu kelas.</p></div><a class="perpus-outline-button" href="{{ route('library.catalog') }}">Kembali ke katalog</a></div>
<div class="perpus-teacher-note"><strong>Bulk request</strong><span>Pengajuan paket kelas maksimal 20 buku dengan durasi peminjaman 14 hari. Pilih koleksi lalu kirim satu pengajuan ke petugas.</span></div>
<form method="POST" action="{{ route('library.class-loans.store') }}" id="classLoanForm">@csrf
<div class="perpus-class-toolbar"><span id="classLoanCount">0/20 buku dipilih</span><label class="perpus-class-notes">Catatan kelas<input name="notes" maxlength="500" placeholder="Contoh: Paket praktik kelas XI RPL 2"></label><button class="perpus-action" type="submit">Ajukan paket <span>↗</span></button></div>
<div class="perpus-book-grid">
@forelse ($books as $book)
<label class="perpus-book-card perpus-select-book"><input type="checkbox" name="book_ids[]" value="{{ $book->id }}"><div class="perpus-cover" style="background-image: url('{{ $book->cover_image }}')"><span>{{ $book->category->name }}</span></div><div class="perpus-book-body"><small>{{ $book->book_code }} · Rak {{ $book->rack_location }}</small><h3>{{ $book->title }}</h3><p>{{ $book->author }}</p><div class="perpus-book-foot"><b class="is-available">{{ $book->available_stock }} tersedia</b><span class="soft-tag">Pilih buku</span></div></div></label>
@empty <div class="perpus-empty">Belum ada buku yang tersedia.</div> @endforelse
</div>
</form>
@endsection
