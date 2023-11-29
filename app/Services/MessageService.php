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
}