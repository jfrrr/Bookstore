<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the 8 required book categories as specified in the PRD.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Novel, cerpen, dan karya fiksi kreatif dari penulis lokal dan internasional.',
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Buku pemrograman, rekayasa perangkat lunak, kecerdasan buatan, dan dunia digital.',
            ],
            [
                'name' => 'Bisnis',
                'description' => 'Strategi bisnis, kewirausahaan, manajemen, dan keuangan pribadi.',
            ],
            [
                'name' => 'Pengembangan Diri',
                'description' => 'Motivasi, produktivitas, mindset, dan cara memaksimalkan potensi diri.',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description'],
                    'status' => 'active',
                ]
            );
        }
    }
}
