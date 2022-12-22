<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Exports\ProductExport;
use App\Exports\SalesExport;
use App\Models\Chat;
use App\Models\Chatroom;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Promo;
use App\Models\PromoGlobal;
use App\Models\PromoType;
use App\Models\ShopModel;
use App\Models\Transaction;
use App\Models\VoucherBelonging;
use App\Rules\NoWhitespace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;

class ShopController extends Controller
{
    public function getRegister() {
        return view('shop.register');
    }

    public function register(Request $request) {
        $rules = [
            "username" => ["required", "unique:customer,customer_username", "unique:shop,shop_username", "min:6", "alpha_num", new NoWhitespace()],
            "password" => "required|min:6|same:confirm",
            "confirm" => "required",
            "name" => "required|max:100",
            "address" => "required|email",
            "phonenumber" => "required|numeric|digits_between:8,14",
            "account" => "required|numeric|digits_between:8,16",
            "address" => "required",
        ];

        $request->validate($rules);

        $res = ShopModel::create([
            'shop_username'=> $request->username,
            'shop_password'  => Hash::make($request->password),
            'shop_name' => $request->name,
            'shop_emailaddress' => $request->address,
            'shop_phonenumber' => $request->phonenumber,
            'shop_accountnumber' => $request->account,
            'shop_address' => $request->address,
        ]);

        if ($res) {
            return redirect()->route('get-login')->with('Message', 'Succesfully registered !');
        } else {
            return redirect()->back()->with('Message', 'Failed registering ! Please try again !');
        }
    }

    public function getHome() {
        $shop = Auth::id();
        $list = Product::withTrashed()->where('shop_id', '=', $shop)->get();
        return view('shop.home', ["product" => $list, "type" => ProductType::all()]);
    }

    public function makeProduct(Request $request) {
        $request->validate([
            'namep' => 'required',
            'descp' => 'required',
            'typep' => 'required',
            'pricep' => 'required|numeric',
            'stockp' => 'required|numeric|min:1',
        ]);

        Product::create([
            'product_name' => $request->namep,
            'product_price' => $request->pricep,
            'product_desc' => $request->descp,
            'product_stock' => $request->stockp,
            'type_id' => $request->typep,
            'shop_id' => Auth::id(),
        ]);

        if (isset($request->imagep)) {
            $request->validate([
                'imagep' => 'mimes:jpeg,bmp,png,jpg',
            ]);

            $p = Product::orderBy('product_id', 'desc')->first();

            $namafile = 'product_'.$p->product_id;
            $path = $request->file("imagep")->storeAs("imgProduct", $namafile, 'public');

            $p->product_img = $namafile;
            $p->save();
        }

        return redirect()->back()->with('scsaddp', 'Successfully added product !');
    }

    public function editProduct(Request $request) {
        $request->validate([
            'namee' => 'required',
            'desce' => 'required',
            'pricee' => 'required|numeric',
        ],
        [
            'namee.required' => 'Name must be filled',
            'desce.required' => 'Description must be filled',
            'pricee.required' =>  'Price must be filled',
            'pricee.numeric' => 'Price must be in numbers',
        ]);

        $p = Product::find(intval($request->ide));
        $p->product_name = $request->namee;
        $p->product_desc = $request->desce;
        $p->product_price = $request->pricee;
        $p->save();

        return redirect()->back()->with('scse', 'Successfully edited product !');
    }

    public function uploadProduct(Request $request) {
        $request->validate([
            'uploadp' => 'required|mimes:png,jpg,jpeg'
        ]);

        $p = Product::find($request->id);

        $filename = 'product_'.$p->product_id;
        $path = $request->file("uploadp")->storeAs("imgProduct", $filename, 'public');

        $p->product_img = $filename;
        $p->save();

        return redirect()->route('shop-home')->with('scsupl', 'Successfully uploaded photo !');
    }

    public function restockProduct(Request $request) {
        $request->validate([
            'restn' => 'required|numeric',
        ],
        [
            'restn.required' => 'Number must be filled',
            'restn.numeric' => 'Number must be in number',
        ]);

        $p = Product::find($request->productr);
        $p->product_stock = intval($p->product_stock) + intval($request->restn);
        $p->save();

        return redirect()->route('shop-home')->with('scsr', 'Successfully restocked product !');
    }

    public function delete(Request $request) {
        $product = $request->id;
        $item = Product::withTrashed()->find($product);

        $isRecovered = false;
        if ($item->trashed()){
            $res = $item->restore();
            $isRecovered = true;
        } else {
            $res = $item->delete();
        }

        if ($res) {
            if ($isRecovered){
                return redirect()->route('shop-home')->with("Message", "Managed to recover product !");
            } else {
                return redirect()->route('shop-home')->with("Message", "Managed to delete product  !");
            }
        } else {
            return redirect()->route('shop-home')->with("Message", "Failed to delete product !");
        }
    }

    public function downloadProduct() {
        $all = DB::table('product')->select(['product_name', 'product_desc','product_price', 'product_stock'])->where('shop_id', '=', Auth::guard('webshop')->id())->get()->toArray();
        $red = DB::table('product')->select(['product_name', 'product_desc','product_price', 'product_stock'])->where('shop_id', '=', Auth::guard('webshop')->id())->where('product_stock', '<', 10)->get()->toArray();

        $arr = [$all, $red];
        return Excel::download(new ProductExport($arr), 'product.xlsx');
    }

    public function getPromo() {
        $listType = PromoType::all();

        $global = PromoGlobal::where("promo_global_status", '=', 1)->get();
        $shop = Promo::where("promo_sourceshop", '=', Auth::guard('webshop')->id())->get();

        return view('shop.promo', ["pg" => $global, "ps" => $shop, "type" => $listType]);
    }

    public function addPromo(Request $request) {
        $rules = [
            "name" => "required",
            "amount" => "required",
            "date" => "required|after:now"
        ];
        $request->validate($rules);

        Promo::create([
            "promo_name" => $request->name,
            "promo_amount" => $request->amount,
            "promo_type" => $request->type,
            "promo_sourceshop" => Auth::guard('webshop')->id(),
            "promo_expiredate" => $request->date,
        ]);

        $p = Promo::orderBy("promo_id", "desc")->first();
        $sum = count(Promo::where('promo_sourceshop', '=', Auth::guard('webshop')->id())->get());
        $type = PromoType::find($request->type);
        $date = date('F j, Y',strtotime($p->promo_expiredate));
        $url = url("shop/promo/delete/$p->promo_id");

        return json_encode(array("statusCode" => 200, 'new' => $p, 'num' => $sum, "type" => $type, 'date' => $date, 'url' => $url));
    }

    public function deletePromo(Request $request) {
        $p = Promo::find($request->id);
        $check = false;

        if ($p->promo_status==1) {
            $p->promo_status = 0;
            $check = true;
        } else $p->promo_status = 1;

        $p->save();

        if ($check) {
            return redirect()->route('shop-promo')->with('scsdel', 'Successfully deactivated promo !');
        } else {
            return redirect()->route('shop-promo')->with('scsact', 'Successfully activated promo !');
        }
    }

    public function getChatroom() {
        $rooms = Chatroom::where('Chatroom_shop', '=', Auth::id())->get();

        return view('shop.chatroom', ["rooms" => $rooms]);
    }

    public function getChat(Request $request) {
        $room = $request->id;
        $chats = Chat::where('room_id', '=', $request->id)->where('deleted_at', '=' , null)->get();
        $cust = Chatroom::find($request->id)->customer->customer_name;

        return view('shop.chat', ["chats" => $chats, "customer" => $cust, "room" => $room]);
    }

    public function chat(Request $request) {
        Chat::create([
            'chat_content' => $request->content,
            'chat_sender' => "shop",
            'room_id' => $request->room,
        ]);

        return redirect()->back();
    }

    public function deleteChat(Request $request) {
        $chat = Chat::find($request->id);
        $chat->delete();

        return redirect()->back();
    }

    public function getTrans() {
        $list = Transaction::join('d_trans', 'd_trans.invoice_number', '=', 'h_trans.invoice_number')->join('product', 'product.product_id', '=', 'd_trans.product_id')
        ->join('shop', 'shop.id', '=', 'product.shop_id')->join('customer', 'customer.id', '=', 'h_trans.trans_customer')->where('shop.id', '=', Auth::id())->select([
            "h_trans.invoice_number as invoice_number",
            "h_trans.trans_date as trans_date",
            "customer.customer_name as customer_name",
            "h_trans.trans_total as trans_total",
            "h_trans.payment_status as payment_status",
            "h_trans.order_status as order_status",
            "h_trans.shipping_address as shipping_address",
        ])->get();

        $promo = [];
        $promoG = [];
        $voucher = [];
        $details = [];

        foreach($list as $t) {
            $details[] = Transaction::find($t->invoice_number)->details;

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

        $product = ShopModel::find(Auth::id())->sells;

        return view('shop.trans', ["list" => $list, "promo" => $promo, "pg" => $promoG, "voucher" => $voucher, "details" => $details, "product" => $product]);
    }

    public function sendOrder(Request $request) {
        $trans = Transaction::find($request->invoice);

        $trans->order_status = "sent";
        $trans->save();

        return redirect()->back()->with('scskirim', 'Sukses mengirimkan pesanan !');
    }

    public function downloadSales(Request $request) {
        $request->validate([
            "product" => "required"
        ]);

        $product = Product::find($request->product);

        return Excel::download(new SalesExport($request->product), "sales_$product->product_name.xlsx");
    }

    public function downloadPenjualan(Request $request) {
        $request->validate([
            "first" => "required|lte:last|before:today",
            "last" => "required|gte:first|before:today",
        ]);

        return Excel::download(new PenjualanExport(Auth::id(), $request->first, $request->last), 'penjualan.xlsx');
    }

    public function logout() {
        Auth::guard('webshop')->logout();

        return redirect()->route('get-login');
    }
}
