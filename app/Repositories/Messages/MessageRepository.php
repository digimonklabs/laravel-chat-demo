<?php
namespace App\Repositories\Messages;

use App\Models\MessageContent;
use App\Repositories\Messages\MessageRepositoryInterface;
use App\Models\Message;
use DB;

class MessageRepository implements MessageRepositoryInterface
{
    public function getUserMessages($receiverId)
    {
        $userId = auth()->user()->id;

        $getMessage = DB::table('messages as m')
                    ->select('m.id','m.sender_id','m.receiver_id','mc.*','mc.id as mc_id','su.name as sender_name','ru.name as receiver_name')
                    ->join('message_contents as mc','mc.message_id','=','m.id')
                    ->join('users as su','su.id','=','m.sender_id')
                    ->join('users as ru','ru.id','=','m.receiver_id')
                    ->where(function($query)use($userId,$receiverId){
                        $query->where('m.sender_id',$userId)->orWhere('m.sender_id',$receiverId);
                    })
                    ->where(function($query) use($userId,$receiverId){
                        $query->where('m.receiver_id',$userId)->orWhere('m.receiver_id',$receiverId);
                    })
                    ->where('mc.is_deleted','no')
                    ->orderBy('mc.created_at','asc')
                    ->get();

//         for update message status
        $chatUser = session()->get('chat_user');

        $getMessageId = Message::where('sender_id','!=',$userId)->where('receiver_id',$chatUser)->orderBy('created_at','desc')->get();
        if($getMessageId->IsEmpty()){
            $getMessageId = Message::where('receiver_id',$userId)->where('sender_id',$chatUser)->orderBy('created_at','desc')->get();
        }

        if(!$getMessageId->IsEmpty()){
            foreach ($getMessageId as $message){
                $checkMessage = MessageContent::where('message_id',$message->id)->first();
                if($checkMessage){
                    $checkMessage->read_status = 'yes';
                    $checkMessage->save();
                }
            }

        }
        return $getMessage;
    }

    public function sendMessage($postData)
    {
        $messageId = "";
        $userId = auth()->user()->id;

        $createNewChat = new Message();
        $createNewChat->sender_id = $userId;
        $createNewChat->receiver_id = $postData['receiver_id'];
        if($createNewChat->save()){
            $messageId = $createNewChat->id;
        }

        if($messageId != ""){
            $createMessageContent = new MessageContent();
            $createMessageContent->message_id = $messageId;
            $createMessageContent->message = $postData['message'];
            if($createMessageContent->save()){
                return response()->json(["status" => "success", "message" => "Success! Message send successfully."]);
            }
        }

        return response()->json(["status" => "failed", "message" => "Something went wrong while sending message, Please try again or later."]);
    }

    public function fetchUserMessagesByAjax($receiverId){
        $getMessages = $this->getUserMessages($receiverId);
        return response()->json($getMessages);
    }

    public function deleteMessage($messageId)
    {
        $checkMessage = MessageContent::find($messageId);
        if($checkMessage){
            $checkMessage->is_deleted = 'yes';
            return $checkMessage->update();
        }
        return false;
    }
}
