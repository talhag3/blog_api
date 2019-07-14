<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Message;

class ChatController extends Controller
{
    //Create Thread 
    //Required Array of ids 
    public function createThread(Request $request){
        $thread = new Thread();
        if(count($request->users)>2){
            $type = '10';
            $thread->$type="group";
        }
        $thread->save();
        $thread->recipients()->sync($request->users);

        return ['thread'=>$thread];
    }

    //get user threads
    public function getThreads(Request $request ){
        $threads = Thread::whereHas('recipients',function($query) use($request){
            $query->where('user_id',$request->me->id);
        });
        $threads->with(['recipients'=>function($query) use($request){
            $query->select('users.id','name')->where('users.id','!=',$request->me->id);
        }]);
        return [
            'msg'=>'you threads',
            'status'=>'200',
            'threads' => $threads->get()
        ];
    }

    //get Thread 
    public function getThread(Request $request,Thread $thread){
        //$thread = Thread::findFirst($request->thread_id);
        $thread->load('recipients');
        return $thread;
    }

    public function getMessages(Request $request){
        
        $messages = Message::where('thread_id',$request->thread_id);

        return [
            'status'=>200,
            'messages'=>$messages->get()
        ];
    }

    public function saveMessage(Request $request){
        $message = new Message();
        $message->content = $request->content;
        $message->thread_id = $request->thread_id;
        $message->user_id = $request->me->id;
        $message->save();
        return [
            'status'=>200,
            'message'=>$message
        ];

    }

}
