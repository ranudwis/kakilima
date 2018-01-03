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
            case 'saved': return 'Disimpan';break;
            case 'paid': return 'Dibayar';break;
            case 'reject': return 'Ditolak';break;
            case 'wait': return 'Menunggu pembayaran';break;
        }
    }

    public function getPayPriceAttribute($value){
        return $value;
    }

    public function getTotalPriceAttribute($value){
        return $value;
    }

    public function getCutoffPriceAttribute($value){
        $value = empty($value) ? 0 : $value;
        return $value;
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
