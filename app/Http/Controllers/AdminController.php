<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Exports\ShopExport;
use App\Exports\TransExport;
use App\Mail\AcceptMail;
use App\Models\CustomerModel;
use App\Models\Promo;
use App\Models\PromoGlobal;
use App\Models\PromoType;
use App\Models\ShopModel;
use App\Models\Transaction;
use App\Models\Voucher;
use App\Models\VoucherBelonging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    //
    public function getHome () {
        $list = CustomerModel::all();

        return view('admin.listuser', ["list" => $list]);
    }

    public function deactivateUser(Request $request) {
        $user = CustomerModel::find($request->id);

        $user->customer_status = 0;
        $user->save();

        return redirect()->route('admin-home')->with('scsdact', 'Succesfully deactivated user !');
    }

    public function activateUser(Request $request) {
        $user = CustomerModel::find($request->id);

        $user->customer_status = 1;
        $user->save();

        return redirect()->route('admin-home')->with('scsact', 'Succesfully reactivated user !');
    }

    public function downloadUser() {
        return Excel::download(new CustomerExport, 'customer.xlsx');
    }

    public function getShop() {
        $list = ShopModel::where("shop_status", "!=", '2')->get();
        $waitinglist = ShopModel::where("shop_status", '=', '2')->get();

        return view('admin.listshop', ["list" => $list, "waitinglist" => $waitinglist]);
    }

    public function deactivateShop(Request $request) {
        $user = ShopModel::find($request->id);

        $user->shop_status = 0;
        $user->save();

        return redirect()->route('admin-shop-list')->with('scsdact', 'Sukses melakukan deaktivasi !');
    }

    public function activateShop(Request $request) {
        $user = ShopModel::find($request->id);

        $user->shop_status = 1;
        $user->save();

        return redirect()->route('admin-shop-list')->with('scsact', 'Sukses melakukan aktivasi !');
    }

    public function acceptShop(Request $request) {
        if ($request->choice=="accept") {
            $user = ShopModel::find($request->id);

            $user->shop_status = 1;
            $user->save();

            Mail::to($user->shop_emailaddress)->send(new AcceptMail('Selamat ! Anda diterima menjadi penjual di aplikasi Dodol Roti. Kini, Anda bisa login dan melakukan aktivitas sebagai penjual.'));

            return redirect()->route('admin-shop-list')->with('scsacpt', 'Penjual baru diterima!');
        } else if ($request->choice=="reject") {
            $user = ShopModel::find($request->id);
            Mail::to($user->shop_emailaddress)->send(new AcceptMail('Mohon maaf, saat ini Anda belum diterima menjadi penjual di aplikasi Dodol Roti. Anda bisa mengajukan pendaftaran penjual kembali'));

            ShopModel::destroy($request->id);

            return redirect()->route('admin-shop-list')->with('scsrjt', 'Penjual baru ditolak!');
        }
    }

    public function downloadShop() {
        return Excel::download(new ShopExport, 'shop.xlsx');
    }

    public function getPromo() {
        $listPromo = Promo::all();
        $listPromoGlobal = PromoGlobal::all();
        $listType = PromoType::all();

        $listVoucher = Voucher::all();
        $sumCust = count(CustomerModel::all());

        return view('admin.listpromo', ["promo" => $listPromo, "promoGlobal" => $listPromoGlobal, "type" => $listType, "voucher" => $listVoucher, "sumCust" => $sumCust]);
    }

    public function makePromo(Request $request) {
        $rules = [
            "name" => "required",
            "amount" => "required|numeric",
            "date" => "required|after:now"
        ];
        $request->validate($rules);

        PromoGlobal::create([
            "promo_global_name" => $request->name,
            "promo_global_amount" => $request->amount,
            "promo_global_type" => $request->type,
            "promo_global_sourceadmin" => Auth::id(),
            "promo_global_expiredate" => $request->date,
        ]);

        return redirect()->back()->with('Success', 'New promo added !');
    }

    public function deactivatePromo(Request $request) {
        $user = PromoGlobal::find($request->id);

        $user->promo_global_status = 0;
        $user->save();

        return redirect()->route('admin-promo-list')->with('scsdpact', 'Succesfully deactivated promo !');
    }

    public function activatePromo(Request $request) {
        $user = PromoGlobal::find($request->id);

        $user->promo_global_status = 1;
        $user->save();

        return redirect()->route('admin-promo-list')->with('scspact', 'Succesfully activated promo !');
    }

    public function makeVoucher(Request $request) {
        $rules = [
            "namev" => "required",
            "amountv" => "required|numeric",
            "datev" => "required|after:now"
        ];
        $request->validate($rules);

        Voucher::create([
            "voucher_name" => $request->namev,
            "voucher_amount" => $request->amountv,
            "voucher_type" => $request->typev,
            "voucher_expiredate" => $request->datev,
            "voucher_sourceadmin" => Auth::id(),
        ]);

        return redirect()->back()->with('Successv', 'New promo added !');
    }

    public function giveVoucher(Request $request) {
        if ($request->customer=="all") {
            $request->validate([
                'vnumber' => "required|numeric"
            ]);
            $list = CustomerModel::all();

            for($i=0; $i<intval($request->vnumber); $i++) {
                foreach($list as $c) {
                    VoucherBelonging::create([
                        "voucher_customer_voucher" => $request->voucher,
                        "voucher_customer_customer" => $c->id,
                    ]);
                }
            }

            return redirect()->back()->with('Successvg', 'Vouchers given !');
        } else {
            $request->validate([
                'vnumber' => 'required|numeric',
                "number" => "required|numeric"
            ]);

            if ($request->customer=="random") {
                $list = CustomerModel::inRandomOrder()->limit($request->number)->get();

                for($i=0; $i<intval($request->vnumber); $i++) {
                    foreach($list as $c) {
                        VoucherBelonging::create([
                            "voucher_customer_voucher" => $request->voucher,
                            "voucher_customer_customer" => $c->id,
                        ]);
                    }
                }

                return redirect()->back()->with('Successvg', 'Vouchers given !');
            } else {
                $all = CustomerModel::all();

                $list = [];
                foreach($all as $c) {
                    $sum = 0;
                    foreach($c->trans as $trans) {
                        $sum+=$trans->trans_total;
                    }
                    $list[] = [
                        "id" => $c->id,
                        "sum" => $sum,
                    ];
                }
                usort($list, fn($a, $b) => $b["sum"] <=> $a["sum"]);

                for ($i=0;$i<$request->number;$i++) {
                    for($j=0;$j<$request->vnumber;$j++) {
                        VoucherBelonging::create([
                            "voucher_customer_voucher" => $request->voucher,
                            "voucher_customer_customer" => $list[$i]["id"],
                        ]);
                    }
                }

                return redirect()->back()->with('Successvg', 'Vouchers given !');
            }
        }
    }

    public function getTransaction() {
        $list = Transaction::all();

        $promo = [];
        $promoG = [];
        $voucher = [];

        foreach($list as $t) {
            $x = DB::table('Transaction_Promo')->where('invoice_number', '=', $t->invoice_number)->first();
            if ($x==null) {
                $promo[] = "empty";
            } else {
                $promo[] = Promo::find($x->promo_id);
            }

            $pg = DB::table('Transaction_PromoGlobal')->where('invoice_number', '=', $t->invoice_number)->first();
            if ($pg==null) {
                $promoG[] = "empty";
            } else {
                $promoG[] = PromoGlobal::find($pg->promo_global_id);
            }

            $v = DB::table('Transaction_Voucher')->where('invoice_number', '=', $t->invoice_number)->first();
            if ($v==null) {
                $voucher[] = "empty";
            } else {
                $voucher[] = VoucherBelonging::find($v->voucher_id)->voucher;
            }
        }

        $shop = ShopModel::all();

        return view('admin.listtrans', ["list" => $list, "promo" => $promo, "pg" => $promoG, "voucher" => $voucher, "shop" => $shop]);
    }

    public function downloadTrans(Request $request){
        $request->validate([
            "first" => "required|lte:last|before:today",
            "last" => "required|gte:first|before:today",
            "shop" => "required"
        ]);

        return Excel::download(new TransExport($request->shop, $request->first, $request->last), 'trans.xlsx');
    }

    public function logout() {
        Auth::guard('webadmin')->logout();

        return redirect()->route('get-login');
    }
}
