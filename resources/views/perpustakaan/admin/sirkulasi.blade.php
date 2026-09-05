@extends('layouts.perpustakaan')

@section('content')
<div class="perpus-page-heading"><div><p class="perpus-kicker">PETUGAS PERPUSTAKAAN</p><h1>ACC center sirkulasi</h1><p>Proses pengajuan dan pengembalian buku dengan cepat.</p></div><span class="perpus-admin-badge">{{ $loans->total() }} total transaksi</span></div>
<div class="perpus-admin-list">
@forelse ($loans as $loan)
<article class="perpus-admin-row"><div><small>{{ $loan->loan_code }} · {{ $loan->book->book_code }}</small><h2>{{ $loan->book->title }}</h2><p>{{ $loan->user->name }} · {{ $loan->user->nis_nip ?? 'NIS belum diisi' }} · {{ strtoupper($loan->user->role) }}</p></div><b class="status-{{ $loan->status }}">{{ ucfirst($loan->status) }}</b><div class="perpus-row-actions">@if ($loan->status === 'pending')<form method="POST" action="{{ route('library.admin.circulation.update', [$loan, 'approve']) }}">@csrf @method('PATCH')<button class="perpus-action" type="submit">Setujui</button></form><form method="POST" action="{{ route('library.admin.circulation.update', [$loan, 'reject']) }}">@csrf @method('PATCH')<button class="perpus-reject" type="submit">Tolak</button></form>@elseif (in_array($loan->status, ['borrowed', 'overdue']))<form method="POST" action="{{ route('library.admin.circulation.update', [$loan, 'return']) }}">@csrf @method('PATCH')<button class="perpus-action" type="submit">Tandai kembali</button></form>@else<span class="perpus-history-label">Riwayat tersimpan</span>@endif</div></article>
@empty <div class="perpus-empty">Tidak ada transaksi yang menunggu proses.</div> @endforelse
</div>
<div class="perpus-pagination perpus-admin-pagination">{{ $loans->links() }}</div>
@endsection
