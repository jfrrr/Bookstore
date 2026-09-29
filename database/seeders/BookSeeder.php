<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds 20+ realistic books with proper Indonesian pricing (Rupiah).
 * Uses placeholder cover images from via.placeholder.com to avoid copyright issues.
 */
class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Fiksi (3)
            [
                'category' => 'Fiksi',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'description' => 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam mengejar mimpi di tengah keterbatasan. Kisah yang mengharukan dan penuh semangat.',
                'price' => 85000,
                'stock' => 45,
                'cover_image' => 'books/laskar-pelangi.jpg',
            ],
            [
                'category' => 'Fiksi',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'description' => 'Mahakarya sastra Indonesia yang mengisahkan perjuangan Minke di era kolonial Belanda. Novel pertama dari Tetralogi Buru.',
                'price' => 95000,
                'stock' => 30,
                'cover_image' => 'books/bumi-manusia.jpg',
            ],
            [
                'category' => 'Fiksi',
                'title' => 'Perahu Kertas',
                'author' => 'Dewi Lestari',
                'description' => 'Kisah cinta dua jiwa muda yang penuh mimpi dan petualangan. Novel yang hangat dan menginspirasi dari Dee Lestari.',
                'price' => 79000,
                'stock' => 60,
                'cover_image' => 'books/perahu-kertas.jpg',
            ],
            // Teknologi (3)
            [
                'category' => 'Teknologi',
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'Panduan lengkap menulis kode yang bersih, terstruktur, dan mudah dipelihara. Wajib baca setiap developer profesional.',
                'price' => 175000,
                'stock' => 20,
                'cover_image' => 'books/clean-code.jpg',
            ],
            [
                'category' => 'Teknologi',
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas & Andrew Hunt',
                'description' => 'Filosofi dan praktik terbaik untuk menjadi programmer yang adaptif dan produktif di era modern.',
                'price' => 190000,
                'stock' => 15,
                'cover_image' => 'books/the-pragmatic-programmer.jpg',
            ],
            [
                'category' => 'Teknologi',
                'title' => 'Laravel: Up & Running',
                'author' => 'Matt Stauffer',
                'description' => 'Panduan komprehensif menggunakan Laravel framework untuk membangun aplikasi web modern yang scalable.',
                'price' => 210000,
                'stock' => 18,
                'cover_image' => 'books/laravel-up-and-running.jpg',
            ],
            // Bisnis (2)
            [
                'category' => 'Bisnis',
                'title' => 'Zero to One',
                'author' => 'Peter Thiel',
                'description' => 'Cara membangun perusahaan yang benar-benar inovatif dan menciptakan sesuatu yang belum pernah ada sebelumnya.',
                'price' => 129000,
                'stock' => 35,
                'cover_image' => 'books/zero-to-one.jpg',
            ],
            [
                'category' => 'Bisnis',
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'description' => 'Metodologi revolusioner untuk membangun bisnis yang efisien melalui siklus validasi cepat dan iterasi berkelanjutan.',
                'price' => 115000,
                'stock' => 28,
                'cover_image' => 'books/the-lean-startup.jpg',
            ],
            // Pengembangan Diri (2)
            [
                'category' => 'Pengembangan Diri',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'Strategi terbukti untuk membangun kebiasaan kecil yang memberikan hasil luar biasa dalam jangka panjang.',
                'price' => 119000,
                'stock' => 65,
                'cover_image' => 'books/atomic-habits.jpg',
            ],
            [
                'category' => 'Pengembangan Diri',
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'description' => 'Tujuh kebiasaan fundamental yang membentuk karakter dan efektivitas seseorang dalam kehidupan pribadi dan profesional.',
                'price' => 109000,
                'stock' => 40,
                'cover_image' => 'books/the-7-habits-of-highly-effective-people.jpg',
            ],
        ];

        foreach ($books as $bookData) {
            $category = Category::where('name', $bookData['category'])->first();
            if (!$category) continue;

            Book::updateOrCreate(
                ['slug' => Str::slug($bookData['title'])],
                [
                    'category_id' => $category->id,
                    'title' => $bookData['title'],
                    'author' => $bookData['author'],
                    'description' => $bookData['description'],
                    'price' => $bookData['price'],
                    'stock' => $bookData['stock'],
                    'cover_image' => $bookData['cover_image'] ?? null,
                    'status' => 'active',
                ]
            );
        }
    }
}
