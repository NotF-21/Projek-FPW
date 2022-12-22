<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::insert([
            [
                'admin_username' => 'admin',
                'admin_password' => Hash::make('admin'),
            ],
            [
                'admin_username' => 'useradmin',
                'admin_password' => Hash::make('nimda'),
            ],
        ]);
    }
}
