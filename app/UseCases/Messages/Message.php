<?php
namespace App\UseCases\Messages;

use App\Repositories\Messages\MessageRepository;



class Message
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function getUserMessages($receiverId)
    {
        return $this->message->getUserMessages($receiverId);
    }

    public function sendMessage($postData){
        return $this->message->sendMessage($postData);
    }

    public function fetchMessagesByUser($receiverId){
        return $this->message->fetchUserMessagesByAjax($receiverId);
    }

    public function deleteMessage($messageId){
        return $this->message->deleteMessage($messageId);
    }
}
