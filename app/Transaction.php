<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id','user_id','status'];

    public function item(){
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value){
        switch($value){
            case 'saved': return 'Disimpan';break;
            case 'wait': return 'Menunggu pembayaran';break;
            case 'paid': return 'Dibayar';break;
            case 'reject': return 'Ditolak';break;
            case 'sent': return 'Dikirim';break;
            case 'done': return 'Selesai';break;
        }
    }

    public function getCutoffPriceAttribute($value){
        return empty($value) ? 0 : $value;
    }

    public function seller(){
        return $this->belongsTo(User::class);
    }
}
