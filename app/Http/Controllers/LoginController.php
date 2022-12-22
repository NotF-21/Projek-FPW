<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CustomerModel;
use App\Models\ShopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PDO;

class LoginController extends Controller
{
    //
    public function getLogin(){
        return view('logreg.login');
    }

    public function login(Request $request) {
        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $message = [
            "username.required" => "Username wajib diisi !",
            "password.required" => "Password wajib diisi !"
        ];

        $request->validate($rules, $message);

        $credentialAdmin = [
            "admin_username" => $request->username,
            "password" => $request->password,
        ];

        $credentialShop = [
            'shop_username' => $request->username,
            'password' => $request->password,
        ];

        $credentialCustomer = [
            "customer_username" => $request->username,
            "password" => $request->password,
        ];

        if (Auth::guard('webadmin')->attempt($credentialAdmin)) {
            return redirect()->route('admin-home');
        } else if (Auth::guard('webshop')->attempt($credentialShop)) {
            return redirect()->route('shop-home');
        } else if (Auth::guard('webcust')->attempt($credentialCustomer)){
            return redirect()->route('cust-home');
        } else {
            return redirect()->back()->with('Message', 'User not found !');
        }
    }
}
