<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function use(){
        $coupon = \App\Coupon::where('code',request('code'))->first();
        $invoice = \App\Invoice::find(request('invoice_id'));
        if(empty($coupon)){
            return back()->withError('code','Kode kupon tidak ditemukan');
        }elseif(empty($invoice)){
            return response("Tidak diizinkan",403);
        }

        $total = $invoice->totalPrice;
        $discount = ($coupon->discount/100)*$total;
        $discount = $discount < $coupon->maximum ? $discount : $coupon->maximum;
        if($total < $coupon->minimum){
            return back()->withError('code','Minimal transaksi adalah'.$coupon->minimum);
        }
        $invoice->update([
            'cutoffPrice' => $discount,
            'coupon_id' => $coupon->id
        ]);
        return back();
    }
}
