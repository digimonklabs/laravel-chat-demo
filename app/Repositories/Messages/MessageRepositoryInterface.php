<?php
namespace App\Repositories\Messages;

use Illuminate\Database\Eloquent\Collection;


interface MessageRepositoryInterface{
    public function getUserMessages($receiverId);
    public function sendMessage($postData);
    public function fetchUserMessagesByAjax($receiverId);
    public function deleteMessage($messageId);
}

