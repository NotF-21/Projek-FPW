<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('get-login');
});

Route::get('login', [LoginController::class, 'getLogin'])->name('get-login');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('generate/link', function(){
    Artisan::call('storage:link');
    echo 'ok';
});

Route::prefix('register')->group(function(){
    Route::get('customer', [CustomerController::class, 'getRegister'])->name('get-cust-register');
    Route::post('customer', [CustomerController::class, 'register'])->name('cust-register');
    Route::get('shop', [ShopController::class, 'getRegister'])->name('get-shop-register');
    Route::post('shop', [ShopController::class, 'register'])->name('shop-register');
});

Route::group(['prefix' => 'customer', 'middleware' => ['auth:webcust', 'cust']],function(){
    Route::get('home', [CustomerController::class, 'getHome'])->name('cust-home');
    Route::get('belanja', [CustomerController::class, 'getBelanja'])->name('cust-belanja');
    Route::post('search', [CustomerController::class, 'searchBelanja'])->name('cust-search-belanja');
    Route::get('search/{choice}={search}', [CustomerController::class, 'goSearch'])->name('cust-search-toko');
    Route::get('toko={name}', [CustomerController::class, 'goShop'])->name('cust-toko');
    Route::get('toko={name}/cari', [CustomerController::class, 'searchProduct'])->name('cust-search-product');
    Route::post('favorit/add', [CustomerController::class, 'addFavorit'])->name('cust-add-favorit');
    Route::post('cart/add/{id}', [CustomerController::class, 'addCart'])->name('cust-add-cart');
    Route::get('keranjang', [CustomerController::class, 'getKeranjang'])->name('cust-keranjang');
    Route::get('cart/delete/{id}', [CustomerController::class, 'deleteCart'])->name('cust-delete-cart');
    Route::post('bayar', [CustomerController::class, 'bayar'])->name('cust-bayar');
    Route::get('promo', [CustomerController::class, 'getPromo'])->name('cust-daftar-promo');
    Route::get('chatroom' ,[CustomerController::class, 'getChatroom'])->name('cust-chatroom');
    Route::get('chat/{room}' ,[CustomerController::class, 'getChat'])->name('cust-chat');
    Route::post('chat/send', [CustomerController::class, 'chat'])->name('cust-chat-post');
    Route::get('chat/delete/{id}', [CustomerController::class, 'deleteChat'])->name('cust-delete-chat');
    Route::get('transaksi', [CustomerController::class, 'getTransaksi'])->name('cust-transaksi');
    Route::get('receive/{order}', [CustomerController::class, 'receiveOrder'])->name('cust-receive-order');
    Route::post('review', [CustomerController::class, 'review'])->name('cust-review');
    Route::get('profile', [CustomerController::class, 'getProfile'])->name('cust-profile');
    Route::post('profile/update', [CustomerController::class, 'updateProfile'])->name('update-profile');
    Route::post('profile/login', [CustomerController::class, 'loginSwitch'])->name('login-switch');
    Route::get('switch/{id}', [CustomerController::class, 'switchAccount'])->name('switch-account');
    Route::get('wishlist', [CustomerController::class, 'goWishlist'])->name('cust-wishlist');
    Route::get('logout', [CustomerController::class, 'logout'])->name('cust-logout');
});

Route::prefix('payments')->group(function(){
    Route::post('notification', [PaymentController::class, 'notification']);
    Route::get('completed', [PaymentController::class, 'completed']);
    Route::get('failed', [PaymentController::class, 'failed']);
    Route::get('unfinish', [PaymentController::class, 'unfinish']);
});

Route::group(['prefix' => 'shop', 'middleware' => ['auth:webshop', 'shop']], function(){
    Route::get('home', [ShopController::class, 'getHome'])->name('shop-home');
    Route::post('product/make', [ShopController::class, 'makeProduct'])->name('product-make');
    Route::post('product/edit', [ShopController::class, 'editProduct'])->name('product-make');
    Route::post('product/upload', [ShopController::class, 'uploadProduct'])->name('product-upload');
    Route::post('product/restock', [ShopController::class, 'restockProduct'])->name('product-restock');
    Route::get('product/delete/{id}', [ShopController::class, 'delete'])->name('product-delete');
    Route::get('product/download', [ShopController::class, 'downloadProduct'])->name('product-download');
    Route::get('promo', [ShopController::class, 'getPromo'])->name('shop-promo');
    Route::post('promo/add', [ShopController::class, 'addPromo'])->name('shop-promo-make');
    Route::get('promo/delete/{id}', [ShopController::class, 'deletePromo'])->name('shop-promo-delete');
    Route::get('chatroom', [ShopController::class, 'getChatroom'])->name('shop-chatroom');
    Route::get('chat/{id}', [ShopController::class, 'getChat'])->name('shop-chat');
    Route::post('chat/send', [ShopController::class, 'chat'])->name('shop-chat-post');
    Route::get('chat/delete/{id}', [ShopController::class, 'deleteChat'])->name('shop-delete-chat');
    Route::get('transaction', [ShopController::class, 'getTrans'])->name('shop-transaction');
    Route::get('kirim/{invoice}', [ShopController::class, 'sendOrder'])->name('shop-kirim-order');
    Route::post('penjualan/download', [ShopController::class, 'downloadPenjualan'])->name('shop-penjualan-download');
    Route::post('sales/download', [ShopController::class, 'downloadSales'])->name('shop-sales-download');
    Route::get('logout', [ShopController::class, 'logout'])->name('shop-logout');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:webadmin'],function(){
    Route::get('home', [AdminController::class, 'getHome'])->name('admin-home');
    Route::get('home/deactivate/{id}', [AdminController::class, 'deactivateUser'])->name('deactivate-user');
    Route::get('home/activate/{id}', [AdminController::class, 'activateUser'])->name('activate-user');
    Route::get('home/download', [AdminController::class, 'downloadUser'])->name('download-user');
    Route::get('shop', [AdminController::class, 'getShop'])->name('admin-shop-list');
    Route::get('shop/deactivate/{id}', [AdminController::class, 'deactivateShop'])->name('deactivate-shop');
    Route::get('shop/activate/{id}', [AdminController::class, 'activateShop'])->name('activate-shop');
    Route::get('shop/{choice}/{id}', [AdminController::class, 'acceptShop'])->name('accept-shop');
    Route::get('shop/download', [AdminController::class, 'downloadShop'])->name('download-shop');
    Route::get('promo', [AdminController::class, 'getPromo'])->name('admin-promo-list');
    Route::post('promo', [AdminController::class, 'makePromo'])->name('admin-promo-make');
    Route::get('promo/deactivate/{id}', [AdminController::class, 'deactivatePromo'])->name('deactivate-promo');
    Route::get('promo/activate/{id}', [AdminController::class, 'activatePromo'])->name('activate-promo');
    Route::post('voucher/make', [AdminController::class, 'makeVoucher'])->name('admin-voucher-make');
    Route::post('voucher/give', [AdminController::class, 'giveVoucher'])->name('admin-voucher-give');
    Route::get('transaction', [AdminController::class, 'getTransaction'])->name('admin-transaction');
    Route::post('transaction/download', [AdminController::class, 'downloadTrans'])->name('admin-transaction-download');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin-logout');
});
