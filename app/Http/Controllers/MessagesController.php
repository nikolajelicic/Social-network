<?php

namespace App\Http\Controllers;

use App\Services\FriendshipService;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Services\NotificationService;

class MessagesController extends Controller
{
    private $messageService;
    private $friendshipService;
    private $notificationService;

    public function __construct(MessageService $messageService, FriendshipService $friendshipService, NotificationService $notificationService) {
        $this->middleware('auth');
        $this->messageService = $messageService;
        $this->friendshipService = $friendshipService;
        $this->notificationService = $notificationService;
    }

    public function showMessage(Request $request, $receiver_id)
    {
        $messages = $this->messageService->showMessage($receiver_id);
        $friends = $this->friendshipService->getFriends();
        foreach($messages as $message){
            if($message->receiver_id == auth()->id()){
                $this->messageService->markAsReadMessage($message->id);
            }
        }
        return view('chat', ['messages' => $messages, 'friends' => $friends, 'receiver_id' => $receiver_id]);
    }

    public function newMessage(Request $request)
    {
        $content = $request->input('content');
        $receiver_id = $request->input('receiver_id');

        $this->messageService->newMessage($content, $receiver_id);
        $this->notificationService->sendNotification($receiver_id, 'sent_you_a_message');

        return redirect()->back();
    }

    public function deleteMessage(Request $request)
    {
        $id = $request->input('message');

        $message = $this->messageService->deleteMessage($id);

        if($message == true){
            return redirect()->back();
        }else{
            return redirect()->back()->with('message','It is not possible to delete the message!');
        }
    }

    public function editMessage(Request $request)
    {
        $id = $request->input('messageId');
        $content = $request->input('content');

        $message = $this->messageService->editMessage($content, $id);

        if($message == true){
            return redirect()->back();
        }else{
            return redirect()->back()->with('message','It is not possible to update the message!');
        }
    }

    public function markAsReadMessage($id)
    {
        return $this->messageService->markAsReadMessage($id);
    }
}
