<?php 

namespace App\Services;

use App\Repositories\PageRepository;
use Illuminate\Http\Request;

class PageService {

    private $pageRepository;

    public function __construct(PageRepository $pageRepository) {
        $this->pageRepository = $pageRepository;
    }

    public function profilePage()
    {   
       return $this->pageRepository->profilePage();
    }

    public function showEditPostPage(Request $request, $id)
    {
        return $this->pageRepository->showEditPostPage($request, $id);
    }

    public function showAddFriendsPage()
    {
        return $this->pageRepository->showAddFriendsPage();
    }

    public function showFriendPostsPage()
    {
        return $this->pageRepository->showFriendPostsPage();
    }

    public function showChatPage()
    {
        return $this->pageRepository->showChatPage();
    }

    public function profilePageBySlug($slug)
    {
        return $this->pageRepository->profilePageBySlug($slug);
    }
}