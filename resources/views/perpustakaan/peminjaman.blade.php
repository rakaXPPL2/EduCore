@extends('layouts.perpustakaan')

@section('content')
<div class="perpus-page-heading"><div><p class="perpus-kicker">SIRKULASI SAYA</p><h1>Peminjaman dan riwayat</h1><p>Pantau status pengajuan, deadline, dan denda dalam satu tempat.</p></div><a class="perpus-outline-button" href="{{ route('library.catalog') }}">Jelajah katalog</a></div>
<div class="perpus-loan-toolbar perpus-reveal is-visible"><label class="perpus-loan-search"><span>⌕</span><input id="loanSearch" type="search" placeholder="Cari judul, kode, atau kategori..." aria-label="Cari peminjaman"><kbd>⌘ K</kbd></label><div class="perpus-loan-filters" role="group" aria-label="Filter status"><button class="is-active" type="button" data-loan-filter="all">Semua</button><button type="button" data-loan-filter="pending">Menunggu</button><button type="button" data-loan-filter="borrowed">Dipinjam</button><button type="button" data-loan-filter="returned">Selesai</button></div><span class="perpus-loan-result" id="loanResult"></span></div>
<div class="perpus-loan-list" id="loanList">
@forelse ($loans as $loan)
<article class="perpus-loan-card" data-loan-item data-status="{{ $loan->status }}" data-search="{{ strtolower($loan->loan_code.' '.$loan->book->title.' '.$loan->book->author.' '.$loan->book->category->name) }}"><div class="perpus-loan-cover" style="background-image: url('{{ $loan->book->cover_image }}')"></div><div class="perpus-loan-main"><small>{{ $loan->loan_code }} · {{ $loan->book->category->name }}</small><h2>{{ $loan->book->title }}</h2><p>{{ $loan->book->author }}</p></div><div class="perpus-loan-status"><b class="status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</b>@if ($loan->due_date)<small>Deadline<br><strong>{{ $loan->due_date->format('d M Y') }}</strong><em data-due="{{ $loan->due_date->toIso8601String() }}"></em></small>@endif</div></article>
@empty <div class="perpus-empty">Belum ada transaksi peminjaman. Mulai dari katalog.</div> @endforelse
</div>
<div class="perpus-loan-no-results" id="loanNoResults" hidden><strong>Tidak ada peminjaman yang cocok.</strong><span>Coba kata kunci atau status lain.</span></div>
@endsection
