<?php 

namespace App\Interfaces;

interface MessageInterface{

    public function showMessage($receiver_id);

    public function newMessage($content, $receiver_id);

    public function deleteMessage($id);

    public function editMessage($content, $id);
}