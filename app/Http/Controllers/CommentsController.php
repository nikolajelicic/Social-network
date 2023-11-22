<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewPostRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function deleteComment(Request $request, $id)
    {
        $this->commentService->deleteComment($request, $id);
        return redirect()->back();
    }

    public function newComment(Request $request)
    {
        $this->commentService->newComment($request);
        return redirect()->route('profile.profilePage')->with('message', 'Comment successfully created!');
    }
}
