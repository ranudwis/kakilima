<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TelegramIntegration;

class TelegramController extends Controller
{
    public function integrate(){
        $check = TelegramIntegration::where('user_id',auth()->id())->first();
        if(is_null($check)){
            $check = TelegramIntegration::create([
                'user_id' => auth()->id()
            ]);
        }

        return redirect('https://t.me/'.config('telegram.bot_username').'?start='.$check->token);
    }

    public function confirm($code){
        if(auth()->user()->telegram->token == $code){
            
        }
    }
}
