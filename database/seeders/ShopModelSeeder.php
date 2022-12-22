<?php

namespace Database\Seeders;

use App\Models\ShopModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopModelSeeder extends Seeder
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
        DB::table("shop")->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        ShopModel::insert([
            [
                'shop_username' => 'TheFlyingLad',
                'shop_password' => Hash::make('abc123'),
                'shop_name' => 'Toko Mahalima',
                'shop_emailaddress' => 'bud1@mail.com',
                'shop_phonenumber' => '081211444555',
                'shop_accountnumber' => '515222999',
                'shop_status' => 1,
                'shop_address' => 'Jalan Mawar no. 21, Surabaya',
            ],
            [
                'shop_username' => 'bud123',
                'shop_password' => Hash::make('qwerty'),
                'shop_name' => 'Toko Trial Register',
                'shop_emailaddress' => 'marc@mail.com',
                'shop_phonenumber' => '081221333288',
                'shop_accountnumber' => '5152117791',
                'shop_status' => 1,
                'shop_address' => 'Jalan Melati no. 14, Surabaya',
            ],
        ]);
    }
}
