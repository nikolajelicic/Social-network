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
    
    public function __construct(PageService $pageService, NotificationService $notificationService) 
    {
        $this->pageService = $pageService;
        $this->notificationService = $notificationService;
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
        $data = $this->pageService->showAddFriendsPage();
        $status = '';
        $dataForView = [];
        
        foreach($data as $user){
            $status = FriendshipsController::getFriendsStatus($user->id);
            $newData = ['userData' => $user, 'status' => $status];
            array_push($dataForView, $newData);
        }

        return view('addFriends', ['dataForView' => $dataForView]);
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
