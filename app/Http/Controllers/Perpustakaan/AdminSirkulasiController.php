<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminSirkulasiController extends Controller
{
    public function index(): View
    {
        return view('perpustakaan.admin.sirkulasi', [
            'loans' => Loan::query()->with(['user', 'book'])->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function update(Loan $loan, string $action): RedirectResponse
    {
        abort_unless(in_array($action, ['approve', 'reject', 'return'], true), 404);

        DB::transaction(function () use ($loan, $action): void {
            $loan->loadMissing(['book', 'user']);

            if ($action === 'approve') {
                abort_unless($loan->status === 'pending', 422, 'Pengajuan ini sudah diproses.');
                $loan->update(['status' => 'borrowed', 'loan_date' => now(), 'due_date' => now()->addDays($loan->user->isTeacher() ? 14 : 7)]);

                return;
            }

            if ($action === 'reject') {
                abort_unless($loan->status === 'pending', 422, 'Pengajuan ini sudah diproses.');
                $loan->book->increment('available_stock');
                $loan->update(['status' => 'rejected']);

                return;
            }

            abort_unless(in_array($loan->status, ['borrowed', 'overdue'], true), 422, 'Buku belum berstatus dipinjam.');
            $fine = $loan->due_date?->isPast() ? $loan->due_date->diffInDays(now()) * 1000 : 0;
            $loan->book->increment('available_stock');
            $loan->user->increment('literacy_points', $fine === 0 ? 10 : 0);
            $loan->update(['status' => 'returned', 'return_date' => now(), 'fine_amount' => $fine]);
        });

        return back()->with('success', 'Status sirkulasi berhasil diperbarui.');
    }

    public function suggestBooks(): JsonResponse
    {
        return response()->json(Book::query()->select(['id', 'book_code', 'title', 'author', 'available_stock'])->where('title', 'like', '%'.request('q').'%')->limit(8)->get());
    }

    public function books(): View
    {
        return view('perpustakaan.admin.buku', [
            'books' => Book::query()->with('category')->latest()->paginate(10)->withQueryString(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function storeBook(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'book_code' => ['required', 'string', 'max:80', 'unique:books,book_code'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'publish_year' => ['required', 'integer', 'between:1900,2100'],
            'category_id' => ['required', 'exists:categories,id'],
            'isbn' => ['nullable', 'string', 'max:40'],
            'ddc_code' => ['nullable', 'string', 'max:30'],
            'rack_location' => ['required', 'string', 'max:100'],
            'total_stock' => ['required', 'integer', 'min:1', 'max:1000'],
            'synopsis' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
        ]);

        Book::query()->create($data + [
            'available_stock' => $data['total_stock'],
            'edition' => 'Edisi pertama',
            'language' => 'Bahasa Indonesia',
            'book_format' => 'Buku cetak',
            'reading_level' => 'SMK / umum',
            'cover_image' => $data['cover_image'] ?? 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
            'keywords' => $data['keywords'] ?? Str::lower($data['title']),
        ]);

        return to_route('library.admin.books')->with('success', 'Buku berhasil ditambahkan ke katalog.');
    }
}
