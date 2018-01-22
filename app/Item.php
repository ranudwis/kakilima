<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['user_id','id','category'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function favorites(){
        return $this->belongsToMany(User::class,'favorites');
    }

    public function transactions(){
        return $this->belongsToMany(Transaction::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function cart(){
        return $this->belongsToMany(Cart::class);;
    }

    public function seller(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function setPhotoAttribute($value){
        $store = [];
        foreach($value as $val){
            $store[] = $val->store('public/images');
        }
        $this->attributes['photo'] = serialize($store);
    }

    public function setConditionAttribute($value){
        $this->attributes['condition'] = $value == 'used' ? false : true;
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = rand(0,1000).'-'.str_slug($value,'-');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getConditionAttribute($value){
        return $value == 1 ? "baru" : "bekas";
    }

    public function getPhotoAttribute($value){
        return unserialize($value);
    }

    public function reviews(){
        return $this->belongsToMany(User::class,'reviews')->withPivot(['stars','review']);
    }

    public function calculateStars(){
        return $this->reviews->pluck('pivot.stars')->avg();
    }

    public function getPriceAttribute($value){
        return 'Rp'.number_format($value,0,',','.');
    }

    public function calculateTotal(){
        return 'Rp'.number_format($this->getOriginal('price') * $this->pivot->quantity,0,',','.');
    }

    public function calculateTotalOriginal(){
        return $this->getOriginal('price') * $this->pivot->quantity;
    }

}
