<?php 

namespace App\Repositories;

use App\Interfaces\MessageInterface;
use App\Models\Message;

class MessageRepository implements MessageInterface{
    
    public function showMessage($receiver_id)
    {
        $messages = Message::where(function ($query) use ($receiver_id) {
                $query->where('sender_id', auth()->id())->where('receiver_id', $receiver_id);
            })
            ->orWhere(function ($query) use ($receiver_id) {
                $query->where('sender_id', $receiver_id)->where('receiver_id', auth()->id());
            })
            ->with('user')
            ->orderBy('created_at')
            ->get();

        //dd($messages); 

        return $messages;
    }

    public function newMessage($content, $receiver_id)
    {
        
    }

    public function editMessage($content, $id)
    {
        
    }

    public function deleteMessage($id)
    {
        
    }
}