<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public $product;
    public function __construct($id)
    {
        $this->product = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return DB::table('h_trans')->join('d_trans', 'h_trans.invoice_number', '=', 'd_trans.invoice_number')->
        join('product', 'd_trans.product_id', '=', 'product.product_id')->join('customer', 'h_trans.trans_customer', '=', 'customer.id')
        ->where('product.product_id', '=', $this->product)->where('h_trans.order_status', '!=', 'cancelled')->select([
            "h_trans.invoice_number",
            "h_trans.trans_date",
            "customer.customer_name",
            "d_trans.product_number",
            DB::raw("d_trans.product_number*product.product_price"),
        ])->get();
    }

    public function headings(): array{
        return [
            'Nomor_Nota',
            'Tanggal Transaksi',
            'Nama Customer',
            'Jumlah Pembelian',
            'Total',
        ];
    }
}
