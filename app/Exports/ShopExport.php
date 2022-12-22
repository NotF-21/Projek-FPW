<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShopExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return DB::table('shop')->select([
            "shop_username",
            "shop_name",
            "shop_address",
            "shop_phonenumber",
            "shop_emailaddress",
            "shop_accountnumber"
        ])->get();
    }

    public function headings(): array{
        return [
            'Username',
            'Nama',
            'Alamat',
            'Nomor Telepon',
            'Alamat Email',
            'Nomor Rekening'
        ];
    }
}
