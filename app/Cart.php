<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function item(){
        return $this->belongsToMany(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
