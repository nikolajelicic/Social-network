<?php

namespace App\Http\Controllers;

use App\Services\FriendshipService;
use Illuminate\Http\Request;
use App\Services\MessageService;

class MessagesController extends Controller
{
    private $messageService;
    private $friendshipService;

    public function __construct(MessageService $messageService, FriendshipService $friendshipService) {
        $this->middleware('auth');
        $this->messageService = $messageService;
        $this->friendshipService = $friendshipService;
    }

    public function showMessage(Request $request, $receiver_id)
    {
        $messages = $this->messageService->showMessage($receiver_id);
        //dd($messages);
        $friends = $this->friendshipService->getFriends();
        return view('chat', ['messages' => $messages, 'friends' => $friends]);
    }
}
