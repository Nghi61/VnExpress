<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Không xác định',
                'slug' => 'khong-xac-dinh',
            ],
            [
                'name' => 'Kinh tế',
                'slug' => 'kinh-te',
            ],
            [
                'name' => 'Giải trí',
                'slug' => 'giai-tri',
            ],
            [
                'name' => 'Thể thao',
                'slug' => 'the-thao',
            ],
            [
                'name' => 'Pháp luật',
                'slug' => 'phap-luat',
            ],
            [
                'name' => 'Giáo dục',
                'slug' => 'giao-duc',
            ],
            [
                'name' => 'Sức khỏe',
                'slug' => 'suc-khoe',
            ],
            [
                'name' => 'Đời sống',
                'slug' => 'doi-song',
            ],
            [
                'name' => 'Du lịch',
                'slug' => 'du-lich',
            ],
            [
                'name' => 'Khoa học',
                'slug' => 'khoa-hoc',
            ]


        ];

        foreach ($data as $record) {
            Category::create($record);
        }
    }
}
