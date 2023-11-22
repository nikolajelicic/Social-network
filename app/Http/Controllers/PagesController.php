<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use Illuminate\Http\Request;
use App\Http\Controllers\FriendshipsController;


class PagesController extends Controller
{
    private $pageService;
    
    public function __construct(PageService $pageService) 
    {
        $this->pageService = $pageService;
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
}
