<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MessageContent;

class Message extends Model
{
    use HasFactory;

    public function messageContent(){
       return $this->hasMany(MessageContent::class,'message_id','id')->orderBy('created_at','asc');
    }
}
