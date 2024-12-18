<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('news')->insert([
            'title' => 'Tiêu đề tin tức',
            'description' => 'Mô tả tin tức...',
            'image' => 'link-to-image.jpg',
        ]);
    }
}
