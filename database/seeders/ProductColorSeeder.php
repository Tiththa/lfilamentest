<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // import the websafe colors from the file saved in storage/app/seeds folder
        $file = Storage::get('app/seeds/websafe_colors.json');
        dd($file);
    }
}
