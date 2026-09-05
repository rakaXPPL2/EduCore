<?php

namespace App\Http\Controllers\Perpustakaan;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('perpustakaan.landing', [
            'featuredBooks' => Book::query()->with('category')->latest()->limit(4)->get(),
            'collectionCount' => Book::query()->sum('total_stock'),
            'categoryCount' => Category::query()->count(),
        ]);
    }

    public function catalog(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $category = trim((string) $request->string('category'));
        $books = Book::query()
            ->with('category')
            ->when($category !== '', fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $category)))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('ddc_code', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $user = $request->user();
        $activeLoans = Loan::query()->where('user_id', $user->id)->whereIn('status', ['approved', 'borrowed', 'overdue'])->count();

        return view('perpustakaan.index', [
            'books' => $books,
            'search' => $search,
            'category' => $category,
            'categories' => Category::query()->withCount('books')->orderBy('name')->get(),
            'totalBooks' => Book::query()->sum('total_stock'),
            'activeLoans' => $activeLoans,
            'historyCount' => Loan::query()->where('user_id', $user->id)->whereIn('status', ['returned', 'rejected'])->count(),
            'literacyPoints' => $user->literacy_points,
        ]);
    }

    public function profile(Request $request): View
    {
        $user = $request->user();
        if (! $user->qr_code_token) {
            $user->forceFill(['qr_code_token' => (string) Str::uuid()])->save();
            $user->refresh();
        }
        $loans = Loan::query()->where('user_id', $user->id);
        $returnedCount = (clone $loans)->where('status', 'returned')->count();
        $onTimeCount = (clone $loans)->where('status', 'returned')->whereColumn('return_date', '<=', 'due_date')->count();
        $roleData = match ($user->role) {
            'teacher' => [
                'profileTitle' => 'Profil ruang guru.',
                'profileDescription' => 'Kelola paket referensi dan pantau kesiapan bahan belajar kelas.',
                'primaryStatLabel' => 'Buku kelas selesai',
                'primaryStat' => $returnedCount,
                'primaryStatNote' => 'koleksi dikembalikan',
                'secondaryStatLabel' => 'Paket aktif',
                'secondaryStat' => (clone $loans)->whereIn('status', ['pending', 'borrowed', 'overdue'])->count(),
                'secondaryStatNote' => 'perlu dipantau',
                'panelKicker' => 'CLASSROOM LIBRARY',
                'panelTitle' => 'Siapkan bacaan untuk kelas',
                'panelDescription' => 'Pilih hingga 20 buku pelajaran untuk diajukan sebagai satu paket dengan durasi 14 hari.',
                'panelRoute' => 'library.class-loans',
                'panelAction' => 'Buka paket kelas',
                'progressBars' => [['label' => 'Kesiapan paket kelas', 'value' => 82], ['label' => 'Koleksi kembali tepat waktu', 'value' => min(100, $returnedCount * 12)], ['label' => 'Kapasitas paket berikutnya', 'value' => 68]],
            ],
            'admin' => [
                'profileTitle' => 'Profil petugas perpustakaan.',
                'profileDescription' => 'Pantau koleksi, transaksi, dan ritme layanan perpustakaan sekolah.',
                'primaryStatLabel' => 'Koleksi aktif',
                'primaryStat' => Book::query()->count(),
                'primaryStatNote' => 'judul terdaftar',
                'secondaryStatLabel' => 'Transaksi terbuka',
                'secondaryStat' => Loan::query()->whereIn('status', ['pending', 'borrowed', 'overdue'])->count(),
                'secondaryStatNote' => 'perlu diproses',
                'panelKicker' => 'LIBRARY CONTROL',
                'panelTitle' => 'Pusat kendali layanan',
                'panelDescription' => 'Kelola koleksi baru dan proses seluruh pengajuan peminjaman dari satu ruang kerja.',
                'panelRoute' => 'library.admin.circulation',
                'panelAction' => 'Buka sirkulasi',
                'progressBars' => [['label' => 'Koleksi terdata', 'value' => 94], ['label' => 'Transaksi tertangani', 'value' => 78], ['label' => 'Kesiapan layanan', 'value' => 88]],
            ],
            default => [
                'profileTitle' => 'Kartu anggota kamu.',
                'profileDescription' => 'Satu profil untuk membaca, meminjam, dan mengumpulkan jejak literasi.',
                'primaryStatLabel' => 'Buku selesai',
                'primaryStat' => $returnedCount,
                'primaryStatNote' => 'koleksi dibaca',
                'secondaryStatLabel' => 'On-time rate',
                'secondaryStat' => $returnedCount > 0 ? (int) round(($onTimeCount / $returnedCount) * 100) : 0,
                'secondaryStatNote' => 'ketepatan kembali',
                'panelKicker' => 'LITERACY SCORE',
                'panelTitle' => number_format($user->literacy_points).' poin literasi',
                'panelDescription' => 'Setiap buku yang selesai dan kembali tepat waktu menambah langkah baikmu.',
                'panelRoute' => 'library.catalog',
                'panelAction' => 'Cari buku baru',
                'progressBars' => [['label' => 'Konsistensi membaca', 'value' => min(100, $returnedCount * 18)], ['label' => 'Ketepatan pengembalian', 'value' => $returnedCount > 0 ? (int) round(($onTimeCount / $returnedCount) * 100) : 0], ['label' => 'Target literasi', 'value' => min(100, $user->literacy_points)]],
            ],
        };

        return view('perpustakaan.profil', [
            'user' => $user,
            'readCount' => $returnedCount,
            'onTimeRate' => $returnedCount > 0 ? (int) round(($onTimeCount / $returnedCount) * 100) : 0,
            'activeCount' => (clone $loans)->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue'])->count(),
            'categoryCount' => Category::query()->count(),
        ] + $roleData);
    }

    public function show(Book $book): View
    {
        return view('perpustakaan.buku', ['book' => $book->load('category')]);
    }
}
