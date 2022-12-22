<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\Transaction;
use App\Models\VoucherBelonging;
use App\Services\Midtrans\CallBackService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    //
    public function notification(Request $request) {
        $callback = new CallBackService;

        if($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $trans = $callback->getTrans();

            if($callback->isSuccess()) {
                Transaction::where("invoice_number", $trans->invoice_number)->update([
                    "order_status" => "confirmed",
                    "payment_status" => "paid",
                ]);

                if(count(DB::table('Transaction_Voucher')->where('invoice_number', $trans->invoice_number)->get())) {
                    $tv = DB::table('Transaction_Voucher')->where('invoice_number', $trans->invoice_number)->first();
                    $v = VoucherBelonging::where('voucher_id', '=', $tv->voucher_id);
                    $v->delete();
                }

                $cust = CustomerModel::find(Auth::guard('webcust')->id());
                $cart = $cust->cart;
                foreach($cart as $c) {
                    $cust->cart->detach($c->product_id);
                }
            }
            if($callback->isExpire()) {
                Transaction::where("invoice_number", $trans->invoice_number)->update([
                    "order_status" => "cancelled",
                    "payment_status" => "expired",
                ]);
            }
            if($callback->isCancelled()) {
                Transaction::where("invoice_number", $trans->invoice_number)->update([
                    "order_status" => "cancelled",
                    "payment_status" => "cancelled",
                ]);
            }

            return response()->json([
                "success" => true,
                'message' => 'Notifikasi berhasil diproses',
            ]);
        } else {
            return response()->json([
                "error" => true,
                'message' => 'Signature key tidak terverifikasi',
            ], 403);
        }
    }
}
