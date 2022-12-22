<?php

namespace Database\Seeders;

use App\Models\PromoType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PromoType::insert([
            [
                'promo_type_name' => 'Potongan'
            ],
            [
                'promo_type_name' => 'Diskon'
            ],
        ]);
    }
}
