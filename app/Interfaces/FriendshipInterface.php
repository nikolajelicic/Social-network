<?php 

namespace App\Interfaces;

interface FriendshipInterface{

    public function sendFriendRequest($senderId, $receiverId); 

    public function acceptFriendRequest($senderId); 

    public function rejectFriendRequest($senderId, $receiverId); 

    public function unfriend($userId, $friendId);

    public function getFriends();

    public function getFriendsStatus($userId);

    public function deleteFriendRequest($senderId, $receiverId);

    public function friendRequests();

    public function sentRequests();
}