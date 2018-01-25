<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TelegramIntegration;
use App\User;
use App\Transaction;
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
        if(isset($this->update["callback_query"])){
            preg_match("/([a-z]+\.[a-z]+)_?(.*)/",$this->update["callback_query"]['data'],$match);
            $command = $match[1];
            $this->message($command);
            $arg = $match[2];
            switch($command){
                case 'disposal.reject':
                    $check = Transaction::where('id',$arg);
                    if($check->exists() && $check->first()->getOriginal('status') == 'paid'){
                        $this->message('Yakin akan tolak pesanan?',$this->inlineQuestion('disposal.reject.confirm_'.$arg));
                    }
                    break;
                case 'disposal.reject.confirm':
                    $check = Transaction::where('id',$arg);
                    if($check->exists() && $check->first()->getOriginal('status') == 'paid'){
                        $check = $check->first();
                        $check->status = 'reject';
                        $check->save();

                        $check->user->notifiy('invoice.show',['invoice' => $disposal->invoice->invoiceId],'Pesanan kamu telah ditolak');
                    }
                    break;
                case 'cancel':
                    $this->tg->post('editMessageText',[
                        'chat_id' => $this->update["callback_query"]["message"]["chat"]["id"],
                        'message_id' => $this->update["callback_query"]["message"]["message_id"],
                        'text' => 'Dibatalkan'
                    ]);
                    break;
            }
        }elseif(isset($this->update["message"]["text"])){
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

    public function message($text,$replyMarkup='{}'){
        if(isset($this->update["callback_query"])){
            $chat_id = $this->update["callback_query"]["message"]["chat"]["id"];
        }else{
            $chat_id = $this->update["message"]["chat"]["id"];
        }

        $this->tg->sendMessage([
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $replyMarkup
        ]);
    }

    public function inlineQuestion($callback){
        return json_encode([
            'inline_keyboard' => [
                [
                    [
                        'text' => '✅',
                        'callback_data' => $callback
                    ],[
                        'text' => '❌',
                        'callback_data' => 'cancel'
                    ]
                ]
            ]
        ]);
    }
}
