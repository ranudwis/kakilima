<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function setNameAttribute($value){
        $this->attributes['name'] = ucfirst($value);
    }

    public function item(){
        return $this->hasMany(Item::class);
    }

    public function calculateTotal(){
        return $this->item->count();
    }
}
