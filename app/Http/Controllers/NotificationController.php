<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $notifications = auth()->user()->notification()->orderBy('viewed')->get();
        return view('user.notifications', compact('notifications'));
    }

    public function show(Notification $notification){
        $notification->viewed = true;
        $notification->save();

        return redirect()->route($notification->action,json_decode($notification->data,true));
    }

    public function read(){
        auth()->user()->notification()->update([
            'viewed' => '1',
        ]);
        return back();
    }
}
