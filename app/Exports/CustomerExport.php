<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return DB::table('customer')->select([
            "customer_username",
            "customer_name",
            "customer_address",
            "customer_phonenumber",
            "customer_gender",
            "customer_accountnumber"
        ])->get();
    }

    public function headings(): array{
        return [
            'Username',
            'Nama',
            'Alamat',
            'Nomor Telepon',
            'Gender',
            'Nomor Rekening'
        ];
    }
}
