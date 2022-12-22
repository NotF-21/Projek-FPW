<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public $shopId;
    public $first;
    public $last;
    public function __construct($shopId, $first, $last)
    {
        $this->shopId = $shopId;
        $this->first = $first;
        $this->last = $last;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return DB::table('h_trans')->join('d_trans', 'h_trans.invoice_number', '=', 'd_trans.invoice_number')->
        join('product', 'd_trans.product_id', '=', 'product.product_id')->join('customer', 'h_trans.trans_customer', '=', 'customer.id')
        ->join('shop', 'product.shop_id', '=', 'shop.id')->where('h_trans.trans_date', '<=', $this->last)
        ->where('h_trans.trans_date', '>=', $this->first)->where('shop.id', '=', $this->shopId)
        ->select([
            "h_trans.invoice_number",
            "customer.customer_name",
            "shop.shop_name",
            "h_trans.trans_date",
            "h_trans.payment_status",
            "h_trans.order_status",
            "h_trans.trans_total",
        ])->get();
    }

    public function headings(): array{
        return [
            'Nomor Nota',
            'Customer',
            'Toko Penjual',
            'Tanggal Transaksi',
            'Status Pembayaran',
            'Status Pengiriman',
            'Total Transaksi',
        ];
    }
}
