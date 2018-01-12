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

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    public function disposals(){
        return $this->hasMany(Transaction::class,'seller_id');
    }

    public function cart(){
        return $this->belongsToMany(Item::class,'carts')->withPivot('quantity');
    }


    public function review(){
        return $this->hasMany(Review::class);
    }

    public function favorite(){
        return $this->belongsToMany(Item::class,'favorites');
    }

    public function isAdmin(){
        return $this->level == 1;
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function acceptPercentage(){
        $items = $this->disposals()->whereIn('status',['done','reject'])->selectRaw('count(*) as cnt')->groupBy('status')->orderBy('status')->get();
        $reject = $items[1]->cnt ?? 0;
        $done = $items[0]->cnt ?? 0;
        if($reject == 0){
            if($done == 0){
                $percentage = 0;
            }else{
                $percentage = 100;
            }
        }else{
            $done = $items[0]->cnt ?? 0;
            $percentage = ($done/($done+$reject))*100;
        }
        return compact('reject','done','percentage');
    }

    public function itemCount(){
        return $this->items->count();
    }
}
