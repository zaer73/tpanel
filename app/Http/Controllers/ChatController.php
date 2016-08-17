<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use Redis, Auth;

class ChatController extends Controller
{
    public function postNewMessage(Request $request){
        $role = userRole(Auth::user());
        if($role == 'user') {
            $receiver = Auth::user()->agent_id;
        } elseif($role == 'agent') {
            $receiver = admin_id();
        } else {
            $receiver = $request->receiver;
        }

        $message = new Message;
        $message->text = $request->message;
        $message->user_id = Auth::id();
        $message->receiver_id = $receiver;
        $message->save();

        Redis::publish('notification', json_encode([
            'message' => $message->text,
            'user_id' => $message->receiver_id
        ]));

    }

    public function getChat($id){
        return Message::where(function($query) use ($id){
            $query->whereUserId(Auth::id())
                ->whereReceiverId($id);
        })->orWhere(function($query) use ($id){
            $query->whereReceiverId(Auth::id())
                ->whereUserId($id);
        })->lists('text');
    }

    public function getChats(){
        return Message::whereReceiverId(Auth::id())->groupBy('user_id')->get();
    }
}
