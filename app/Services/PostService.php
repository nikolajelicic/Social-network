<?php 

namespace App\Services;

use App\Http\Requests\CreateNewPostRequest;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostService {

    private $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function createNewPost(CreateNewPostRequest $request)
    {   
        $this->postRepository->createNewPost($request);
    }

    public function editPost(CreateNewPostRequest $request)
    {
        $this->postRepository->editPost($request);
    }

    public function deletePost(Request $request, $id)
    {
        $this->postRepository->deletePost($request, $id);
    }

    public function getPostBySlug(Request $request, $slug)
    {
        return $this->postRepository->getPostBySlug($request, $slug);
    }
}