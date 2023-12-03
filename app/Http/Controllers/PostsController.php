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

    public function createNewPost(Request $request)
    {
        $content = $request->input('content');
        $this->postService->createNewPost($content);
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
        return view('posts.show-post'); //need to be implemented to view
    }

    public function showLikes(Request $request, $postId) //This will be updated to show only the ajax call, to return json and on the frontend it shows the modal and inside the modal who liked the post
    {
        $data = $this->postService->showLikes($postId);
        if($request->ajax()){
            return response()->json(['data' => $data]);
        }else{
            return view('posts.likes', ['data' => $data]);
        }   
    }
}
