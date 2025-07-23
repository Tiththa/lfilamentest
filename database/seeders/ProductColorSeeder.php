<?php

namespace Database\Seeders;

use App\Models\ProductColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // import the websafe colors from the file saved in storage/app/seeds folder
        // 6 x 6 x 6 = 216 colors

        $steps = ['00', '33', '66', '99', 'CC', 'FF'];
        $colors = [];

        foreach ($steps as $r) {
            foreach ($steps as $g) {
                foreach ($steps as $b) {
                    $colors[] = [
                        'name' => "Websafe Color #{$r}{$g}{$b}",
                        'hex_code' => "#{$r}{$g}{$b}",
                        'description' => "Websafe color with hex code #{$r}{$g}{$b}",
                    ];
                }
            }
        }

        // Insert the colors into the product_colors table
        ProductColor::insert($colors);

    }
}
