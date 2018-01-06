<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','gender','address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $username = 'username';

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function getGenderAttribute($value){
        return $value == "M" ? "Laki-laki" : "Perempuan";
    }

    public function getPhotoAttribute($value){
        if(empty($value)){
            return url('images/dummyUser.png');
        }
        return url(\Storage::url($value));
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function addItem($req){
        $req["category_id"] = $req["category"];
        $query = $this->items()->create($req);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function disposals(){
        return $this->hasMany(Transaction::class,'seller_id');
    }

    public function cart(){
        return $this->belongsToMany(Item::class,'carts')->withPivot('quantity');
    }


    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favorites(){
        return $this->belongsToMany(Item::class,'favorites');
    }

    public function isAdmin(){
        return $this->level == 1;
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
