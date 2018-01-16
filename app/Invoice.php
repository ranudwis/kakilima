<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id','status'];

    public function getRouteKeyName(){
        return 'invoiceId';
    }

    public function getStatusAttribute($value){
        switch($value){
            case 'saved': return 'Menunggu proses';break;
            case 'paid': return 'Dibayar';break;
            case 'reject': return 'Ditolak';break;
            case 'wait': return 'Menunggu pembayaran';break;
        }
    }

    public function getCutoffPriceAttribute($value){
        $value = empty($value) ? 0 : $value;
        return $value;
    }

    public function totalPriceCut(){
        if($this->getOriginal('status') == 'saved'){
            $cut = $this->getOriginal('totalPrice') - $this->cutoffPrice;
        }else{
            return 'Rp'.number_format($this->payPrice,3,',','.');
        }
        return 'Rp'.number_format($cut,0,',','.');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getTotalPriceAttribute($value){
        return 'Rp'.number_format($value,0,',','.');
    }
}
