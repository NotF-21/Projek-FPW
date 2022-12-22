<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProductType::insert([
            [
                'Type_Name' => 'Cake',
            ],
            [
                'Type_Name' => 'Bread',
            ],
            [
                'Type_Name' => 'Snacks',
            ],
            [
                'Type_Name' => 'Drinks',
            ],
            [
                'Type_Name' => 'Others',
            ],
        ]);
    }
}
