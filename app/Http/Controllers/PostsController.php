<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewPostRequest;
use Illuminate\Http\Request;
use App\Services\PostService;

class PostsController extends Controller
{
    private $postService;
    
    public function __construct(PostService $postService) 
    {
        $this->postService = $postService;
    }

    public function createNewPost(CreateNewPostRequest $request)
    {
        $this->postService->createNewPost($request);
        return redirect()->back()->with('message','Post successfully created!');
    }

    public function editPost(CreateNewPostRequest $request)
    {
        $this->postService->editPost($request);
        return redirect()->route('profile.profilePage')->with('message', 'Post updated successfully!');
    }

    public function deletePost(Request $request, $id)
    {
        $this->postService->deletePost($request, $id);
        return redirect()->back()->with('message', 'Post deleted successfully!');
    }

    public function getPostBySlug(Request $request, $slug)
    {
        $this->postService->getPostBySlug($request, $slug);
        return view('posts.show-post');
    }
}
