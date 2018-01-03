<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function setNameAttribute($value){
        $this->attributes['name'] = ucfirst($value);
    }
}
