<?php 

namespace App\Interfaces;

use App\Http\Requests\CreateNewPostRequest;
use Illuminate\Http\Request;

interface PostInterface{

    public function createNewPost(CreateNewPostRequest $request);
    
    public function deletePost(Request $request, $id);

    public function editPost(CreateNewPostRequest $request);

    public function getPostBySlug(Request $request, $slug);
}