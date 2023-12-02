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

        return $messages;
    }

    public function newMessage($content, $receiver_id)
    {
        //dd($receiver_id);
        $messages = new Message;
        $messages->content = $content;
        $messages->sender_id = auth()->id();
        $messages->receiver_id = $receiver_id;
        $messages->isReaded = false;
        $messages->created_at = now();
        $messages->save();
    }

    public function editMessage($content, $id)
    {
        $message = Message::where('sender_id', auth()->id())
        ->where('id', $id)
        ->first();

        if($message){
            $message->update([
                'content' => $content,
                'updated_at' => now()
            ]);

            return true;
        }

        return false;
    }

    public function deleteMessage($id)
    {
        $messages = Message::where('sender_id', auth()->id())
        ->where('id', $id)
        ->first();

        if($messages){
            $messages->delete();

            return true;
        }
        
        return false;
    }

    public function markAsReadMessage($id)
    {
        $message = Message::findOrFail($id);

        if($message && $message->isReaded == 0) {
            $message->update([
                'isReaded' => 1
            ]);
        }
            return false;
    }
}