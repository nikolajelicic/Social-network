<?php 

namespace App\Interfaces;

use App\Http\Requests\CreateNewPostRequest;
use Illuminate\Http\Request;

interface CommentInterface{

    public function newComment(Request $request);

    public function editComment(CreateNewPostRequest $request, $id);

    public function deleteComment(CreateNewPostRequest $request, $id);
}