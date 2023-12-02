<?php

namespace App\Http\Controllers;

use App\Services\CommentLikeService;
use Illuminate\Http\Request;

class CommentLikesController extends Controller
{
    private $commentLikeService;

    public function __construct(CommentLikeService $commentLikeService)
    {
        $this->commentLikeService = $commentLikeService;
    }
    
    public function likeComment(Request $request, $id)
    {
        $this->commentLikeService->likeComment($request, $id);
        return redirect()->back();
    }

    public function unlikeComment(Request $request, $id)
    {
        $this->commentLikeService->unlikeComment($request, $id);
        return redirect()->back();
    }

    public function showWhoIsLikesComment(Request $request, $id)
    {
        $data = $this->commentLikeService->showWhoIsLikesComment($id);
        if($request->ajax()){
            return response()->json(['data' => $data]);
        }else{
            abort(404);
        }
    }
}
