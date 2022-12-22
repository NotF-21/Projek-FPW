<?php

namespace Database\Seeders;

use App\Models\CustomerModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table("customer")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        CustomerModel::factory(5)->create('');
    }
}
