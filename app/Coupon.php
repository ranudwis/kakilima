<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'minimum','discount','maximum'];

    public function setCodeAttribute($value){
        $this->attributes['code'] = strtoupper($value);
    }
}
