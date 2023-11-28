<?php 

namespace App\Services;

use App\Repositories\FriendshipRepository;
use Illuminate\Http\Request;

class FriendshipService {

    private $friendshipRepository;

    public function __construct(FriendshipRepository $friendshipRepository) 
    {
        $this->friendshipRepository = $friendshipRepository;
    }

    public function sendFriendRequest($senderId, $receiverId)
    {
        return $this->friendshipRepository->sendFriendRequest($senderId, $receiverId);
    }

    public function getFriendsStatus($userId)
    {
        return $this->friendshipRepository->getFriendsStatus($userId);
    }

    public function deleteFriendRequest($senderId, $receiverId)
    {
        return $this->friendshipRepository->deleteFriendRequest($senderId, $receiverId);
    }

    public function getFriends()
    {
        return $this->friendshipRepository->getFriends();
    }

    public function acceptFriendRequest($senderId)
    {
        return $this->friendshipRepository->acceptFriendRequest($senderId);
    }

    public function friendRequests()
    {
        return $this->friendshipRepository->friendRequests();
    }

    public function sentRequests()
    {
        return $this->friendshipRepository->sentRequests();
    }
}