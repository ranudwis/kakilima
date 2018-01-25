<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TelegramIntegration;
use App\User;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    private $update = [];

    private $tg;

    public function __construct(Api $tg){
        $this->tg = $tg;
    }

    public function integrate(){
        $check = TelegramIntegration::where('user_id',auth()->id())->first();
        if(is_null($check)){
            $check = TelegramIntegration::create([
                'user_id' => auth()->id()
            ]);
        }

        return redirect('https://t.me/'.config('telegram.bot_username').'?start='.$check->token);
    }

    public function disintegrate(){
        $user = auth()->user();
        $user->telegram_id = null;
        $user->save();

        return back()->with('cm','Hubungan diputus');
    }

    public function update(){
        $this->update = request()->all();
        if(isset($this->update["message"]["text"])){
            $text = $this->update["message"]["text"];
            if(preg_match("/\/(\S+) ?(.*)?/",$text,$match)){
                $arg = $match[2];
                switch($match[1]){
                    case "start":
                        $from_id = $this->update["message"]["from"]["id"];

                        if(empty($arg)){
                            $user = User::where('telegram_id',$from_id);
                            if($user->exists()){
                                $user = $user->first();
                                $this->message("Akun Telegram ini terhubung dengan akun ".$user->name
                                    ."\nKamu akan mendapatkan notifikasi melalui akun Telegram ini");
                            }else{
                                $this->message("Akun Telegram ini tidak terhubung, masuk ke pengaturan akun untuk menghubungkan akun dan mendapat notifikasi melalui Telegram");
                            }
                            return;
                        }

                        TelegramIntegration::where('expired','<',new \Carbon\Carbon())->delete();
                        $code = TelegramIntegration::where('token',$arg)->with('user')->first();
                        if(is_null($code)){
                            $this->message("Tautan tidak valid atau sudah kaldaluwarsa");
                            return;
                        }

                        $check = User::where('telegram_id',$from_id)->first();
                        if(!is_null($check)){
                            $this->message("Kamu sudah terkait dengan akun lain");
                            return;
                        }

                        $user = $code->user;
                        $user->telegram_id = $from_id;
                        $user->save();

                        $this->message("Kamu telah berhasil terkait dengan akun ".$user->name);
                        $code->delete();
                        break;
                }
            }
        }
    }

    public function message($text){
        $chat_id = $this->update["message"]["chat"]["id"];

        $this->tg->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text
        ]);
    }
}
