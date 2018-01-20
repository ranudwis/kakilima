<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id','user_id','status'];

    protected $dates = [
        'created_at',
        'updated_at',
        'paid_at',
        'sent_at',
        'done_at'
    ];

    public function item(){
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function getStatusAttribute($value){
        switch($value){
            case 'saved': return 'Menunggu proses';break;
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

    public function totalPriceCut(){
        $cut = $this->getOriginal('totalPrice') - $this->cutoffPrice;
        return 'Rp'.number_format($cut,0,',','.');
    }

    public function seller(){
        return $this->belongsTo(User::class);
    }

    public function calculateTotal(){
        $total = 0;
        foreach($this->item as $item){
            $total += $item->getOriginal('price') * $item->pivot->quantity;
        }
        return $total;
    }

    public function getTotalPriceAttribute($value){
        return 'Rp'.number_format($value,0,',','.');
    }
}
