<?php

namespace App\Http\Controllers;

use App\UseCases\User\User;
use App\UseCases\Messages\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct(User $user,Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function index(Request $request){

        $users = $this->user->getUser();
        [$firstUser] = $users;
        $id = $request->user;

        if($id != ""){
            $id = base64_decode($id);
            $firstUser = $this->user->getUserById($id);
        }
        session()->put('chat_user',$firstUser->id);
        $userMessageList = $this->message->getUserMessages($firstUser->id);
        return view('dashboard',compact('users','firstUser','userMessageList'));
    }

    public function store(Request $request)
    {
        return $this->message->sendMessage($request->all());
    }

    public function fetchMessagesByUser(Request $request){
        $receiverId = $request->receiver_id;
        return $this->message->fetchMessagesByUser($receiverId);
    }

    public function delete(Request $request)
    {
        $messageId = $request->message_id;
        return $this->message->deleteMessage($messageId);
    }
}
