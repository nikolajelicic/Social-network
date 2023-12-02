<?php 

namespace App\Services;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessageService {

    private $messageRepository;

    public function __construct(MessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    public function showMessage($receiver_id)
    {
        return $this->messageRepository->showMessage($receiver_id);
    }

    public function newMessage($content, $receiver_id)
    {
        return $this->messageRepository->newMessage($content, $receiver_id);
    }

    public function deleteMessage($id)
    {
        return $this->messageRepository->deleteMessage($id);
    }

    public function editMessage($content, $id)
    {
        return $this->messageRepository->editMessage($content,$id);
    }

    public function markAsReadMessage($id)
    {
        return $this->messageRepository->markAsReadMessage($id);
    }
}