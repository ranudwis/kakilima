<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['user_id','id','category'];

    public function user(){
        return $this->belongsTo(User::class);
    } 

    public function vavorites(){
        return $this->belongsToMany(Vavorite::class);
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

    public function setPhotoAttribute($value){
        $store = [];
        foreach($value as $val){
            $store[] = $val->store('public/images');
        }
        $this->attributes['photo'] = serialize($store);
    }

    public function setConditionAttribute($value){
        $this->attributes['condition'] = $value == 'old' ? false : true;
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = rand(0,1000).'-'.str_slug($value,'-');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getConditionAttribute($value){
        return $value ? "baru" : "bekas";
    }

    public function getPhotoAttribute($value){
        return unserialize($value);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function calculateStars(){
        $count = 0;
        $total = 0;
        foreach($this->reviews as $review){
            $total += $review->stars;
            $count++;
        }
        $count = $count == 0 ? 1 : $count;
        return round($total/$count,1);
    }
}