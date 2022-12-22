<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Chatroom;
use App\Models\CustomerModel;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Promo;
use App\Models\PromoGlobal;
use App\Models\Review;
use App\Models\ShopModel;
use App\Models\Transaction;
use App\Models\Voucher;
use App\Models\VoucherBelonging;
use App\Rules\NoWhitespace;
use App\Services\Midtrans\CreateSnapTokenService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CustomerController extends Controller
{
    //
    public function getRegister() {
        return view('customer.register');
    }

    public function register(Request $request) {
        $rules = [
            "username" => ["required", "unique:customer,customer_username", "unique:shop,shop_username", "min:6", "alpha_num", new NoWhitespace()],
            "password" => "required|min:6|same:confirm",
            "confirm" => "required",
            "name" => "required|max:100",
            "address" => "required",
            "phonenumber" => "required|numeric|digits_between:8,14",
            "account" => "required|numeric|digits_between:8,16",
            "gender" => "required"
        ];

        $request->validate($rules);

        $res = CustomerModel::create([
            'customer_username' => $request->username,
            'customer_password' => Hash::make($request->password),
            'customer_name' => $request->name,
            'customer_address' => $request->address,
            'customer_phonenumber' => $request->phonenumber,
            'customer_gender' => $request->gender,
            'customer_accountnumber' => $request->account
        ]);

        if ($res) {
            return redirect()->route('get-login')->with('Message', 'Succesfully registered !');
        } else {
            return redirect()->back()->with('Message', 'Failed registering ! Please try again !');
        }
    }

    public function getHome() {
        $promos = count(PromoGlobal::where('promo_global_status', '=', '1')->get());

        $all = ShopModel::all();

        $shops = [];
        foreach($all as $s) {
            if (count($s->promos)) {
                $shops[] = $s;
            }
        }


        return view('customer.home', ['countp' => $promos, "shops" => collect($shops)]);
    }

    public function searchBelanja(Request $request) {
        $request->validate([
            'search' => 'required',
            'choice' => 'required',
        ]);

        return redirect("customer/search/$request->choice=$request->search");
    }

    public function goSearch(Request $request) {
        $reviews = [];
        if ($request->choice=="nama") {
            $shops = ShopModel::whereRaw('lower(shop_name) like ?', ["%$request->search%"])->where('shop_status', '=', 1)->get();
        } else {
            $shops = ShopModel::whereRaw('lower(shop_address) like ?', ["%$request->search%"])->where('shop_status', '=', 1)->get();
        }

        foreach($shops->chunk(3) as $key=>$chunk) {
            $reviews[] = [];
            foreach($chunk as $shop) {
                $list = $shop->reviews;
                $num = 0;
                if (count($list)) {
                    foreach($list as $r) {
                        $num+=intval($r->review_rating);
                    }
                    $num/=count($list);
                }
                $reviews[$key][] = $num;
            }
        }

        return view('customer.search', ["list" => $shops, "reviews" => $reviews]);
    }

    public function goShop(Request $request) {
        $shop = ShopModel::where('shop_name', '=', $request->name)->first();
        $products = $shop->sells;
        $category = ProductType::all();

        $fav = [];
        foreach($products->chunk(3) as $key=>$chunk) {
            $fav[] = [];
            foreach($chunk as $p) {
                if (count($p->favorite()->where("favorite_customer", '=', Auth::id())->get())) {
                    $fav[$key][] = "yes";
                } else {
                    $fav[$key][] = "no";
                }
            }
        }

        return view('customer.toko', ["cart" => CustomerModel::find(Auth::id())->cart, "shop" => $shop, "list" => $products, "kategori" => $category, 'fav' => $fav]);
    }

    public function searchProduct(Request $request) {
        $shop = ShopModel::where("shop_name", '=', $request->name)->first();
        $list = Product::where("shop_id", '=', $shop->id);
        $category = ProductType::all();

        if (isset($request->produk)) {
            $list = $list->whereRaw('lower(product_name) like ?', ["%$request->produk%"]);
        }
        if (isset($request->min)) {
            $request->validate([
                'min' => 'numeric',
            ],
            [
                'min.numeric' => 'Harga minimum harus dalam angka !'
            ]);
            $list = $list->where("product_price", ">=", intval($request->min));
        }
        if (isset($request->max)) {
            $request->validate([
                'max' => 'numeric',
            ],
            [
                'max.numeric' => 'Harga maksimum harus dalam angka !'
            ]);
            $list = $list->where("product_price", "<=", intval($request->max));
        }
        if (isset($request->category)) {
            $x = ProductType::where('Type_Name', '=', $request->category)->first();
            $list = $list->where("type_id", "=", $x->id);
        }
        if (isset($request->stok)) {
            if ($request->stok=="available") {
                $list = $list->where("product_stock", "!=", 0);
            }
        }
        $products = $list->get();

        $fav = [];
        foreach($products->chunk(3) as $key=>$chunk) {
            $fav[] = [];
            foreach($chunk as $p) {
                if (count($p->favorite()->where("favorite_customer", '=', Auth::id())->get())) {
                    $fav[$key][] = "yes";
                } else {
                    $fav[$key][] = "no";
                }
            }
        }

        return view('customer.toko', ["cart" => CustomerModel::find(Auth::id())->cart,"shop" => $shop, "list" => $products, "kategori" => $category, "fav" => $fav]);
    }

    public function addFavorit(Request $request) {
        $ip = $request->id;
        $cust = Auth::id();

        if (count(DB::table('favorit')->where('favorite_customer', '=', $cust)->where('favorite_product', '=', $ip)->get())) {
            $product = Product::find($ip);
            $cust = CustomerModel::find(Auth::id());

            $cust->favorite()->detach($product);

            return json_encode(array("act" => "del"));
        } else {
            $product = Product::find($ip);
            $cust = CustomerModel::find(Auth::id());

            $cust->favorite()->attach($product);

            return json_encode(array("statusCode" => 200,"act" => "add"));
        }
    }

    public function getProfile() {
        $acc = [];
        $list = DB::table('switch')->where('switch_customer_1', '=', Auth::id())->get();
        foreach($list as $x) {
            $acc[] = CustomerModel::find($x->switch_customer_2);
        }
        return view('customer.profile', ["list" => $list, 'acc' => $acc]);
    }

    public function addCart(Request $request) {
        $request->validate([
            "number" => "required|numeric|min:1",
        ],
        [
            "number.required" => "Angka harus diisi !",
            "number.numeric" => "Input harus berupa angka !",
            "number.min" => "Pesanan minimal 1 !",
        ]);

        $cart = DB::table('cart')->where("customer_id", "=", Auth::id())->get();
        $customer = CustomerModel::find(Auth::id());

        if (count($cart)) {
            $shop = Product::find($request->id)->shop->id;
            foreach($cart as $c) {
                $product = Product::find($c->product_id);
                if ($product->shop->id!=$shop) {
                    $customer->cart()->detach($product->product_id);
                }
            }
        }

        $isThere = DB::table('cart')->where("customer_id", "=", Auth::id())->where("product_id", "=", $request->id)->get();

        if (count($isThere)) {
            $num = DB::table('cart')->where("customer_id", "=", Auth::id())->where("product_id", "=", $request->id)->first();
            $customer->cart()->updateExistingPivot($request->id, [
                "amount" => $num->amount+$request->number,
            ]);
        } else {
            $customer->cart()->attach($request->id, [
                "amount" => $request->number,
            ]);
        }

        return redirect()->back()->with('scscart', 'Sukses menambahkan ke keranjang !');
    }

    public function getKeranjang() {
        $cart = CustomerModel::find(Auth::id())->cart;
        $promoGlobal = PromoGlobal::all();
        $vouchers = VoucherBelonging::where('voucher_customer_customer', '=', Auth::id())->get();
        $shop = "";

        $product = [];
        $amount = [];
        $total = 0;

        foreach($cart as $c) {
            $product[] = Product::find($c->product_id);
            $shop = Product::find($c->product_id)->shop->id;
            $amount[] = DB::table('cart')->where('customer_id', '=', Auth::id())->where('product_id', '=', $c->product_id)->first()->amount;
            $total += Product::find($c->product_id)->product_price*DB::table('cart')->where('customer_id', '=', Auth::id())->where('product_id', '=', $c->product_id)->first()->amount;
        }
        $promo = Promo::where('promo_sourceshop', '=', $shop)->get();
        $product = collect($product);
        $amount = collect($amount);

        return view('customer.keranjang', ["cart" => $product, "amount" => $amount, "voucher" => $vouchers, "promoGlobal" => $promoGlobal, "promo" => $promo, "total" => $total]);
    }

    public function deleteCart(Request $request) {
        $customer = CustomerModel::find(Auth::id());
        $customer->cart()->detach($request->id);

        return redirect()->route('cust-keranjang')->with('scsdel', 'Sukses dihapus dari keranjang !');
    }

    public function bayar(Request $request) {
        $cart = CustomerModel::find(Auth::id())->cart;

        $total = 0;

        foreach($cart as $c) {
            $total += Product::find($c->product_id)->product_price*DB::table('cart')->where('customer_id', '=', Auth::id())->where('product_id', '=', $c->product_id)->first()->amount;
        }

        $name = Auth::user()->customer_name;
        $pieces = explode(' ', $name);
        $last_word = array_pop($pieces);

        array_unshift($pieces, $last_word);

        $new_string = implode(' ', $pieces);

        $today = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $code = 'TR'. $today->format('d') . $today->format('m'). $today->format('y');

        $num = "";

        $num = DB::table('H_Trans')->whereRaw('invoice_number like ?', ["%$code%"])->get();
        $val = "";

        if (count($num)) {
            $num = DB::table('H_Trans')->where('invoice_number', 'like', "%$code%")->orderBy('invoice_number', 'desc')->first();
            $c = intval(substr($num->invoice_number,8,3))+1;
            $val = str_pad($c,3,"0",STR_PAD_LEFT);
            $code = $code. $val;
        } else {
            $code = $code . "001";
        }

        if ($request->promo!="0" && $request->promo!="empty") $p = Promo::find($request->promo)->promo_amount;
        else $p = 0;
        if ($request->promog!="0" && $request->promog!="empty") $pg = PromoGlobal::find($request->promog)->promo_global_amount;
        else $pg = 0;
        if ($request->voucher!="0" && $request->voucher!="empty") $v = VoucherBelonging::find($request->voucher)->voucher->voucher_amount;
        else $v = 0;

        if ($request->promo!="0" && $request->promo!="empty" && Promo::find($request->promo)->type->promo_type_name=="Diskon") $p = $total*$p/100;
        if ($request->promog!="0" && $request->promog!="empty" && PromoGlobal::find($request->promog)->type->promo_type_name=="Diskon") $pg = $total*$pg/100;
        if ($request->voucher!="0" && $request->voucher!="empty" && VoucherBelonging::find($request->voucher)->voucher->type->promo_type_name=="Diskon") $v = $total*$v/100;

        $total = $total - $p - $pg - $v;

        $trans = Transaction::create([
            'invoice_number' => $code,
            'trans_date' => $today,
            'trans_total' => $total,
            'trans_customer' => Auth::id(),
            'trans_token' => null,
            'payment_status' => "waiting",
            'order_status' => "waiting",
            'shipping_address' => $request->alamat,
        ]);

        if ($request->promo!="0" && $request->promo!="empty") {
            DB::table('Transaction_Promo')->insert([
                "invoice_number" => $code,
                "promo_id" => $request->promo,
            ]);
        }

        if ($request->promog!="0" && $request->promog!="empty") {
            DB::table('Transaction_PromoGlobal')->insert([
                "invoice_number" => $code,
                "promo_id" => $request->promog,
            ]);
        }

        if ($request->voucher!="0" && $request->voucher!="empty") {
            DB::table('Transaction_Voucher')->insert([
                "invoice_number" => $code,
                "promo_id" => $request->voucher,
            ]);
        }

        foreach($cart as $c) {
            DB::table('D_Trans')->insert([
                "invoice_number" => $code,
                "product_id" => $c->product_id,
                "product_number" => DB::table('cart')->where('customer_id', '=', Auth::id())->where('product_id', '=', $c->product_id)->first()->amount,
            ]);
        }

        $midtrans = new CreateSnapTokenService($trans);
        $snapToken = $midtrans->getSnapToken();

        $trans->trans_token = $snapToken;
        $trans->save();

        return json_encode(array("token" => $snapToken));
    }

    public function getChatroom(){
        $rooms = Chatroom::where("Chatroom_customer", '=', Auth::id())->get();

        return view('customer.chatroom', ["rooms" => $rooms]);
    }

    public function getChat(Request $request) {
        $chats = Chat::where('room_id', '=', $request->room)->get();
        $shopname = ShopModel::find(Chatroom::find($request->room)->Chatroom_shop)->shop_name;

        return view('customer.chat', ["chats" => $chats, "shopname" => $shopname, "room" => $request->room]);
    }

    public function chat(Request $request) {
        Chat::create([
            'chat_content' => $request->content,
            'chat_sender' => "customer",
            'room_id' => $request->room,
        ]);

        return redirect()->back();
    }

    public function deleteChat(Request $request) {
        $chat = Chat::find($request->id);
        $chat->delete();

        return redirect()->back();
    }

    public function updateProfile(Request $request) {
        if (!isset($request->new)) {
            $request->validate([
                "username" => 'required',
                "name" => "required",
                'address' => 'required',
                "phonenumber" => "required",
                "accountnumber" => "required|numeric|digits_between:8,16",
                'password' => "required|"
            ]);

            if (Hash::check($request->password,Auth::user()->customer_password)) {
                $user = CustomerModel::find(Auth::id());
                $user->customer_username = $request->username;
                $user->customer_name = $request->name;
                $user->customer_accountnumber = $request->accountnumber;
                $user->customer_address = $request->address;
                $user->customer_phonenumber = $request->phonenumber;
                $user->save();

                return redirect()->back()->with('msg', 'Sukses update profile !');
            } else {
                return redirect()->back()->withErrors(['password' => ['Password tidak cocok !']]);
            }
        } else {
            $request->validate([
                "username" => 'required',
                "name" => "required",
                'address' => 'required',
                "phonenumber" => "required",
                "accountnumber" => "required|numeric|digits_between:8,16",
                'password' => "required",
                'new' => 'required',
                'new-confirm' => 'required|same:new'
            ],[
                'new-confirm.same' => 'Konfirmasi password baru harus cocok !',
            ]);

            if (Hash::check($request->password,Auth::user()->customer_password)) {
                $user = CustomerModel::find(Auth::id());
                $user->customer_username = $request->username;
                $user->customer_name = $request->name;
                $user->customer_accountnumber = $request->accountnumber;
                $user->customer_address = $request->address;
                $user->customer_phonenumber = $request->phonenumber;
                $user->customer_password = Hash::make($request->new);
                $user->save();

                return redirect()->back()->with('msg', 'Sukses update profile !');
            } else {
                return redirect()->back()->withErrors(['password' => ['Password tidak cocok !']]);
            }
        }
    }

    public function switchAccount(Request $request) {
        $cust = CustomerModel::find($request->id);

        Auth::guard('webcust')->login($cust);

        return redirect()->route('cust-home');
    }

    public function loginSwitch(Request $request) {
        $request->validate([
            'usernamel' => 'required',
            'passwordl' => 'required',
        ]);

        $id = Auth::id();
        $credential = [
            'customer_username' => $request->usernamel,
            'password' => $request->passwordl,
        ];

        if (Auth::guard('webcust')->attempt($credential)) {
            $customer = CustomerModel::where('customer_username', '=', $request->usernamel)->first();

            $x = DB::table('switch')->where('switch_customer_1', '=', $id)->where('switch_customer_2', '=', $customer->id)->get();
            if (!count($x)) {
                DB::table('switch')->insert([
                    'switch_customer_1' => $id,
                    'switch_customer_2' => $customer->id,
                ]);
                DB::table('switch')->insert([
                    'switch_customer_1' => $customer->id,
                    'switch_customer_2' => $id,
                ]);
            }
            Auth::guard('webcust')->login($customer);
            return redirect()->route('cust-profile');
        } else {
            return redirect()->route('cust-profile')->withErrors(['msgSL' => 'Username atau password salah !'] );
        }
    }

    public function getPromo() {
        $all = ShopModel::all();

        $shops = [];
        foreach($all as $s) {
            if (count($s->promos)) {
                $shops[] = $s;
            }
        }

        $promos = PromoGlobal::where('promo_global_status', '=', '1')->get();

        $warning = [];
        $vouchers = VoucherBelonging::where('voucher_customer_customer', '=', Auth::id())->get();
        foreach($vouchers as $v) {
            $today = new DateTime("now");
            $expire = new DateTime($v->voucher->voucher_expiredate);

            $interval = $today->diff($expire);
            if ($interval->days<=14) {
                $warning[] = "yes";
            } else {
                $warning[] = "no";
            }
        }

        return view('customer.promo', ["shops" => collect($shops), "vouchers" => $vouchers, "warning" => $warning, "promos" => $promos]);
    }

    public function getTransaksi() {
        $list = Transaction::where('trans_customer', '=', Auth::id())->where('order_status', '!=', 'cancelled')->get();

        $shop = [];
        $details = [];
        $promo = [];
        $promoG = [];
        $voucher = [];

        foreach($list as $x) {
            $shop[] = DB::table('shop')->join('product', 'product.shop_id', '=', 'id')->join('d_trans', 'd_trans.product_id', '=', 'product.product_id')
            ->where('d_trans.invoice_number', '=', $x->invoice_number)->select(
                'shop.shop_name as shop_name'
            )->first();

            $details[] = $x->details;

            $a = DB::table('Transaction_Promo')->where('invoice_number', '=', $x->invoice_number)->first();
            if ($a==null) {
                $promo[] = "empty";
            } else {
                $promo[] = Promo::find($x->promo_id);
            }

            $pg = DB::table('Transaction_PromoGlobal')->where('invoice_number', '=', $x->invoice_number)->first();
            if ($pg==null) {
                $promoG[] = "empty";
            } else {
                $promoG[] = PromoGlobal::find($pg->promo_global_id);
            }

            $v = DB::table('Transaction_Voucher')->where('invoice_number', '=', $x->invoice_number)->first();
            if ($v==null) {
                $voucher[] = "empty";
            } else {
                $voucher[] = VoucherBelonging::find($v->voucher_id)->voucher;
            }
        }

        $shop = collect($shop);

        return view('customer.transaksi', ["list" => $list, "shops" => $shop, "details" => $details, "promo" => $promo, "pg" => $promoG, "voucher" => $voucher]);
    }

    public function receiveOrder(Request $request) {
        $trans = Transaction::find($request->order);

        $trans->order_status = "received";
        $trans->save();

        return redirect()->back()->with('rev', $request->order);
    }

    public function review(Request $request) {
        $request->validate([
            'rating' => "required"
        ]);

        $shop = DB::table('shop')->join('product', 'product.shop_id', '=', 'shop.id')->join('d_trans', 'd_trans.product_id','=', 'product.product_id')
        ->where('d_trans.invoice_number', '=', $request->shop)->select([
            'shop.id'
        ])->first();

        Review::create([
            'review_rating' => $request->rating,
            'review_review' => $request->review,
            'review_shop' => $shop->id,
            'review_customer' => Auth::id(),
        ]);

        return redirect()->back();
    }

    public function goWishlist() {
        $favs = CustomerModel::find(Auth::id())->favorite;

        return view('customer.wishlist', ["favs" => $favs]);
    }

    public function logout() {
        Auth::guard('webcust')->logout();
        return redirect()->route('get-login');
    }
}
