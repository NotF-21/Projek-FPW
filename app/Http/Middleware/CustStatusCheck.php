<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cust = Auth::guard('webcust')->user();
        if ($cust->customer_status==0) {
            Auth::guard('webcust')->logout();
            return redirect()->route('get-login')->with('Message', 'Status akun Anda non-aktif, silahkan hubungi admin untuk info lebih lanjut.');
        } else if ($cust->customer_status==1) {
            return $next($request);
        }
    }
}
