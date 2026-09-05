<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(): View
    {
        $loans = Loan::query()
            ->with('book.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('perpustakaan.peminjaman', compact('loans'));
    }

    public function classLoans(): View
    {
        return view('perpustakaan.peminjaman-kelas', [
            'books' => Book::query()->with('category')->where('available_stock', '>', 0)->orderBy('title')->get(),
        ]);
    }

    public function storeClassRequest(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->isTeacher(), 403);

        $data = $request->validate([
            'book_ids' => ['required', 'array', 'min:1', 'max:20'],
            'book_ids.*' => ['integer', 'distinct', 'exists:books,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $loanCount = DB::transaction(function () use ($data): int {
            $created = 0;

            foreach ($data['book_ids'] as $bookId) {
                $book = Book::query()->lockForUpdate()->findOrFail($bookId);
                abort_if($book->available_stock < 1, 422, "Stok buku {$book->title} tidak mencukupi.");

                $book->decrement('available_stock');
                Loan::query()->create([
                    'loan_code' => 'KL-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
                    'user_id' => auth()->id(),
                    'book_id' => $book->id,
                    'status' => 'pending',
                    'notes' => $data['notes'] ?? 'Pengajuan paket buku kelas',
                ]);
                $created++;
            }

            return $created;
        });

        return to_route('library.class-loans')->with('success', "{$loanCount} buku berhasil diajukan sebagai paket kelas.");
    }

    public function store(Book $book): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->isStudent(), 403);

        $activeLoanCount = Loan::query()
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])
            ->count();

        if ($activeLoanCount >= 3) {
            return back()->withErrors(['book' => 'Batas maksimal 3 buku aktif sudah tercapai.']);
        }

        $alreadyRequested = Loan::query()
            ->where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])
            ->exists();

        if ($alreadyRequested) {
            return back()->withErrors(['book' => 'Buku ini sudah ada dalam daftar pinjamanmu.']);
        }

        $loan = DB::transaction(function () use ($book, $user): Loan {
            $lockedBook = Book::query()->lockForUpdate()->findOrFail($book->id);

            if ($lockedBook->available_stock < 1) {
                abort(422, 'Stok buku sedang habis.');
            }

            $lockedBook->decrement('available_stock');

            return Loan::query()->create([
                'loan_code' => 'LP-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
                'user_id' => $user->id,
                'book_id' => $lockedBook->id,
                'status' => 'pending',
            ]);
        });

        return to_route('library.loans')->with('success', "Pengajuan {$loan->loan_code} berhasil dikirim.");
    }
}
