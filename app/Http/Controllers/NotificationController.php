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
        $notifications = auth()->user()->notifications()->orderBy('updated_at','desc')->orderBy('viewed')->get();
        return view('backend.notifications.index', compact('notifications'));
    }

    public function show(Notification $notification){
        $notification->viewed = true;
        $notification->save();

        return redirect()->route($notification->action,json_decode($notification->data,true));
    }
}
