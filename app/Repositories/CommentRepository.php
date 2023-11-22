<?php 

namespace App\Repositories;

use App\Http\Requests\CreateNewPostRequest;
use App\Interfaces\CommentInterface;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentRepository implements CommentInterface{

    public function newComment(Request $request)
    {
        $comment = new Comment;
        $parent_id = null;
        if($request->has('parent_id')){
            $parent_id = $request->input('parent_id');
        }

        $comment->create([
            'post_id' => $request->input('post_id'),
            'user_id' => Auth::id(),
            'content' => $request->input('comment'),
            'parent_id' => $parent_id
        ]);
    }

    public function editComment(Request $request, $id)
    {
        
    }

    public function deleteComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }
}