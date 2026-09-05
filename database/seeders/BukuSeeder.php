<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['category' => 'Rekayasa Perangkat Lunak', 'title' => 'Pemrograman Web Modern', 'author' => 'M. Shalahuddin', 'publisher' => 'Informatika', 'ddc_code' => '005.13', 'rack_location' => 'A-01, Baris 1', 'isbn' => '9786021514899'],
            ['category' => 'Rekayasa Perangkat Lunak', 'title' => 'Basis Data untuk SMK', 'author' => 'Fathansyah', 'publisher' => 'Informatika', 'ddc_code' => '005.74', 'rack_location' => 'A-01, Baris 2', 'isbn' => '9786026232507'],
            ['category' => 'Rekayasa Perangkat Lunak', 'title' => 'Algoritma dan Pemrograman', 'author' => 'Rosa A. S.', 'publisher' => 'Modula', 'ddc_code' => '005.1', 'rack_location' => 'A-01, Baris 3', 'isbn' => '9786028758258'],
            ['category' => 'Rekayasa Perangkat Lunak', 'title' => 'UI/UX Design untuk Pemula', 'author' => 'Surianto Rustan', 'publisher' => 'Gramedia', 'ddc_code' => '006.7', 'rack_location' => 'A-02, Baris 1', 'isbn' => '9786020633171'],
            ['category' => 'Fiksi', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'ddc_code' => '813', 'rack_location' => 'B-01, Baris 1', 'isbn' => '9789793062792'],
            ['category' => 'Fiksi', 'title' => 'Bumi', 'author' => 'Tere Liye', 'publisher' => 'Gramedia', 'ddc_code' => '813', 'rack_location' => 'B-01, Baris 2', 'isbn' => '9786020332957'],
            ['category' => 'Fiksi', 'title' => 'Negeri 5 Menara', 'author' => 'Ahmad Fuadi', 'publisher' => 'Gramedia', 'ddc_code' => '813', 'rack_location' => 'B-01, Baris 3', 'isbn' => '9789792268133'],
            ['category' => 'Otomotif', 'title' => 'Teknologi Dasar Otomotif', 'author' => 'Buntarto', 'publisher' => 'Andi', 'ddc_code' => '629.2', 'rack_location' => 'C-01, Baris 1', 'isbn' => '9789792953564'],
            ['category' => 'Otomotif', 'title' => 'Pemeliharaan Mesin Kendaraan Ringan', 'author' => 'Jalius Jama', 'publisher' => 'Erlangga', 'ddc_code' => '629.287', 'rack_location' => 'C-01, Baris 2', 'isbn' => '9786022417263'],
            ['category' => 'Sains', 'title' => 'Fisika Dasar untuk SMK', 'author' => 'Mikrajuddin Abdullah', 'publisher' => 'Erlangga', 'ddc_code' => '530', 'rack_location' => 'D-01, Baris 1', 'isbn' => '9786022985472'],
            ['category' => 'Sains', 'title' => 'Kimia Industri Dasar', 'author' => 'Sutresna', 'publisher' => 'Grafindo', 'ddc_code' => '660', 'rack_location' => 'D-01, Baris 2', 'isbn' => '9786022419182'],
            ['category' => 'Bisnis', 'title' => 'Kewirausahaan SMK', 'author' => 'Kasmir', 'publisher' => 'Rajawali Pers', 'ddc_code' => '658.11', 'rack_location' => 'E-01, Baris 1', 'isbn' => '9789797697364'],
            ['category' => 'Bahasa', 'title' => 'Bahasa Indonesia Akademik', 'author' => 'E. Kosasih', 'publisher' => 'Yrama Widya', 'ddc_code' => '499.221', 'rack_location' => 'F-01, Baris 1', 'isbn' => '9786023746928'],
            ['category' => 'Bahasa', 'title' => 'English for Vocational School', 'author' => 'Wachyu Sundayana', 'publisher' => 'Erlangga', 'ddc_code' => '428', 'rack_location' => 'F-01, Baris 2', 'isbn' => '9786022417072'],
            ['category' => 'Pengembangan Diri', 'title' => 'Atomic Habits', 'author' => 'James Clear', 'publisher' => 'Gramedia', 'ddc_code' => '158.1', 'rack_location' => 'G-01, Baris 1', 'isbn' => '9786020633171'],
        ];

        $details = [
            'Pemrograman Web Modern' => ['synopsis' => 'Panduan praktik membangun aplikasi web dari HTML, CSS, JavaScript, hingga pola pengembangan yang mudah dirawat. Cocok untuk siswa RPL yang ingin mengubah ide menjadi produk digital.', 'keywords' => 'HTML, CSS, JavaScript, web, RPL', 'page_count' => 286, 'reading_level' => 'Pemula - Menengah'],
            'Basis Data untuk SMK' => ['synopsis' => 'Membahas cara merancang tabel, relasi, normalisasi, SQL, dan pengelolaan data untuk kebutuhan aplikasi sekolah maupun industri.', 'keywords' => 'SQL, database, relasi, normalisasi, MySQL', 'page_count' => 244, 'reading_level' => 'Pemula - Menengah'],
            'Algoritma dan Pemrograman' => ['synopsis' => 'Memperkuat cara berpikir komputasional melalui algoritma, struktur data dasar, pseudocode, dan latihan pemecahan masalah yang bertahap.', 'keywords' => 'algoritma, logika, pemrograman, struktur data', 'page_count' => 318, 'reading_level' => 'Pemula'],
            'UI/UX Design untuk Pemula' => ['synopsis' => 'Mengenalkan riset pengguna, arsitektur informasi, wireframe, prototyping, dan prinsip visual untuk membuat antarmuka yang mudah dipahami.', 'keywords' => 'UI, UX, desain, prototipe, pengguna', 'page_count' => 192, 'reading_level' => 'Pemula'],
            'Laskar Pelangi' => ['synopsis' => 'Kisah persahabatan dan perjuangan anak-anak Belitung yang menjaga mimpi melalui pendidikan, keberanian, dan ketekunan di tengah keterbatasan.', 'keywords' => 'novel, pendidikan, persahabatan, inspirasi', 'page_count' => 534, 'reading_level' => 'Remaja - Umum'],
            'Bumi' => ['synopsis' => 'Petualangan Raib, Seli, dan Ali membuka dunia paralel yang penuh rahasia, persahabatan, dan pilihan besar tentang keberanian.', 'keywords' => 'fantasi, petualangan, persahabatan, novel', 'page_count' => 440, 'reading_level' => 'Remaja'],
            'Negeri 5 Menara' => ['synopsis' => 'Perjalanan enam sahabat di pesantren yang belajar bahwa cita-cita perlu dirawat dengan disiplin, doa, dan keyakinan untuk terus mencoba.', 'keywords' => 'novel, pendidikan, pesantren, motivasi', 'page_count' => 423, 'reading_level' => 'Remaja - Umum'],
            'Teknologi Dasar Otomotif' => ['synopsis' => 'Pengantar sistem kendaraan, keselamatan kerja, alat bengkel, mesin, pemindah tenaga, dan pemeriksaan dasar yang wajib dipahami siswa otomotif.', 'keywords' => 'otomotif, kendaraan, mesin, bengkel, K3', 'page_count' => 276, 'reading_level' => 'Pemula'],
            'Pemeliharaan Mesin Kendaraan Ringan' => ['synopsis' => 'Referensi prosedur perawatan mesin kendaraan ringan, diagnosis gangguan, penggunaan alat ukur, dan standar kerja bengkel yang aman.', 'keywords' => 'mesin, kendaraan ringan, perawatan, diagnosis', 'page_count' => 352, 'reading_level' => 'Menengah'],
            'Fisika Dasar untuk SMK' => ['synopsis' => 'Konsep fisika disajikan melalui contoh vokasi: pengukuran, gerak, energi, listrik, gelombang, dan penerapannya dalam pekerjaan teknis.', 'keywords' => 'fisika, energi, listrik, pengukuran, vokasi', 'page_count' => 300, 'reading_level' => 'Pemula - Menengah'],
            'Kimia Industri Dasar' => ['synopsis' => 'Mengenalkan materi, reaksi kimia, keselamatan laboratorium, proses industri, dan pengolahan bahan dengan contoh yang dekat dengan dunia kerja.', 'keywords' => 'kimia, industri, laboratorium, keselamatan', 'page_count' => 264, 'reading_level' => 'Menengah'],
            'Kewirausahaan SMK' => ['synopsis' => 'Membantu siswa mengenali peluang, menyusun model bisnis, menghitung biaya, memasarkan produk, dan membangun mental wirausaha yang adaptif.', 'keywords' => 'bisnis, kewirausahaan, pemasaran, model bisnis', 'page_count' => 228, 'reading_level' => 'Pemula'],
            'Bahasa Indonesia Akademik' => ['synopsis' => 'Panduan menulis gagasan dengan runtut melalui struktur paragraf, karya ilmiah, presentasi, kutipan, dan penggunaan bahasa Indonesia yang efektif.', 'keywords' => 'bahasa, menulis, akademik, presentasi', 'page_count' => 210, 'reading_level' => 'Pemula - Menengah'],
            'English for Vocational School' => ['synopsis' => 'Latihan bahasa Inggris kontekstual untuk sekolah vokasi, mulai dari percakapan kerja, instruksi teknis, surat sederhana, hingga wawancara.', 'keywords' => 'English, vocational, conversation, workplace', 'page_count' => 198, 'reading_level' => 'Pemula'],
            'Atomic Habits' => ['synopsis' => 'Kerangka praktis untuk membangun kebiasaan kecil yang konsisten, memahami pemicu perilaku, dan menciptakan sistem belajar yang bertahan lama.', 'keywords' => 'kebiasaan, produktivitas, belajar, pengembangan diri', 'page_count' => 320, 'reading_level' => 'Remaja - Umum'],
        ];

        foreach ($books as $book) {
            $categoryName = $book['category'];
            $categorySlug = Str::slug($categoryName);
            $category = Category::query()->firstOrCreate(
                ['slug' => $categorySlug],
                ['name' => $categoryName, 'icon' => 'book-open'],
            );
            unset($book['category']);
            $bookCode = 'BK-'.strtoupper($categorySlug).'-'.str_pad((string) (Book::query()->where('category_id', $category->id)->count() + 1), 3, '0', STR_PAD_LEFT);

            Book::query()->updateOrCreate(
                ['book_code' => $bookCode],
                $book + [
                    'book_code' => $bookCode,
                    'category_id' => $category->id,
                    'publish_year' => 2025,
                    'total_stock' => 3,
                    'available_stock' => 3,
                    'edition' => 'Edisi 2025',
                    'language' => str_contains($book['title'], 'English') ? 'Bahasa Inggris' : 'Bahasa Indonesia',
                    'book_format' => 'Buku cetak',
                    'synopsis' => $details[$book['title']]['synopsis'],
                    'keywords' => $details[$book['title']]['keywords'],
                    'page_count' => $details[$book['title']]['page_count'],
                    'reading_level' => $details[$book['title']]['reading_level'],
                    'cover_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
                ],
            );
        }
    }
}
