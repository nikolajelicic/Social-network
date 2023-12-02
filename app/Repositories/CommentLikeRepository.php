<?php 

namespace App\Repositories;

use App\Interfaces\CommentLikeInterface;
use App\Models\Comment_like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeRepository implements CommentLikeInterface{

    public function likeComment(Request $request, $id)
    {
        $existingLike = Comment_like::where('user_id',  Auth::id())
                            ->where('comment_id', $id)
                            ->first();

        if(!$existingLike){
            $like = new Comment_like([
                'comment_id' => $request->id,
                'user_id' => Auth::id(),
                'created_at' => now()
            ]);
    
            return $like->save();
        }
    }

    public function unlikeComment(Request $request, $id)
    {   
        $existingLike = Comment_like::where('user_id',  Auth::id())
                        ->where('comment_id', $id)
                        ->firstOrFail();
        if($existingLike){
            $existingLike->delete();
        }
    }

    public function showWhoIsLikesComment($id)
    {
        $likes = Comment_like::where('comment_id', $id)
        ->with('user')
        ->get();

        return $likes;
    }
}