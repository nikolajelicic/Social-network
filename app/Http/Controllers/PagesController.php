<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\FriendshipsController;
use App\Services\NotificationService;

class PagesController extends Controller
{
    private $pageService;
    private $notificationService;
    private $friendshipsController;
    
    public function __construct(PageService $pageService, NotificationService $notificationService, FriendshipsController $friendshipsController) 
    {
        $this->pageService = $pageService;
        $this->notificationService = $notificationService;
        $this->friendshipsController = $friendshipsController;
    }

    public function profilePage()
    {
        $data = $this->pageService->profilePage();
        return view('profile', ['data' => $data]);
    }

    public function showEditPostPage(Request $request, $id)
    {
        $post = $this->pageService->showEditPostPage($request, $id);
        return view('editPost', ['post' => $post]);
    }

    public function showAddFriendsPage()
    {
        $users = $this->pageService->showAddFriendsPage();
        $friends = $this->friendshipsController->getFriends();
        $requests = $this->friendshipsController->friendRequests();
        $sentRequests = $this->friendshipsController->sentRequests();
        return view('addFriends', ['users' => $users, 'friends' => $friends, 'requests' => $requests, 'sentRequests' => $sentRequests]);
    }

    public function notificationPage()
    {
        $count = $this->notificationService->countNotification();
        $notications = $this->notificationService->getNotification();

        foreach($notications as $notication){
            if($notication->read == 0){
                $this->notificationService->markAsRead($notication->id);
            }
        }
        return view('notification',['count' => $count, 'notifications' => $notications]);
    }

    public function showFriendPostsPage()
    {
        $data = $this->pageService->showFriendPostsPage();
        //dd($data);
        return view('friendPosts', ['data' => $data]);
    }
}
