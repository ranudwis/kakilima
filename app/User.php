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

    public function disposal(){
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

    public function notification(){
        return $this->hasMany(Notification::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function acceptPercentage(){
        $items = $this->disposal()->whereIn('status',['done','reject'])->selectRaw('count(*) as cnt')->groupBy('status')->orderBy('status')->get();
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
            $percentage = round(($done/($done+$reject))*100,1);
        }
        return compact('reject','done','percentage');
    }

    public function itemCount(){
        return $this->items->count();
    }

    public function telegram(){
        return $this->hasOne(TelegramIntegration::class);
    }

    public function notify($action,$data,$text,$type = '',$object = []){
        $notification = new Notification();
        $notification->user_id = $this->id;
        $notification->text = $text;
        $notification->action = $action;
        $notification->data = json_encode($data);
        $notification->save();
        if(!is_null($this->telegram_id)){
            switch($type){
                case 'new_order':
                    $text = "#".$object->id
                        ."\nPesanan baru oleh ".$object->user->name
                        ."\n\n--------------------";
                    foreach($object->item as $item){
                        $text .= "\n".str_limit($item->name,20)." x ".$item->pivot->quantity;
                    }
                    $text .= "\n--------------------"
                        ."\n\nTotal: ".$object->totalPrice;

                    $inline = [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '📎 Tampilkan',
                                    'url' => route('notification.show',['notification' => $notification->id])
                                ]
                            ]
                        ]
                    ];
                    break;
                default:
                    $inline = [
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '📎 Tampilkan',
                                    'url' => route('notification.show',['notification' => $notification->id])
                                ]
                            ]
                        ]
                    ];
            }

            $tg = new \Telegram\Bot\Api();
            $tg->sendMessage([
                'chat_id' => $this->telegram_id,
                'text' => $text,
                'reply_markup' => json_encode($inline),
            ]);
        }
    }
}
