<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramIntegration extends Model
{
    protected $table = 'telegramintegration';

    public $timestamps = false;

    protected $date = [
        'expired',
    ];

    protected $fillable = ['user_id'];

    public function setUserIdAttribute($value){
        $this->attributes['user_id'] = $value;
        $this->attributes['token'] = str_random(10);
        $this->attributes['expired'] = (new \Carbon\Carbon())->addHours(24);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
