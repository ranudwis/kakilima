<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'minimum','discount','maximum'];

    public function setCodeAttribute($value){
        $this->attributes['code'] = strtoupper($value);
    }

    public function getMinimumAttribute($value){
        return 'Rp'.number_format($value,0,',','.');
    }

    public function getMaximumAttribute($value){
        return 'Rp'.number_format($value,0,',','.');
    }
}
