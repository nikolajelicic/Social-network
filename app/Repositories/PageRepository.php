<?php 

namespace App\Repositories;

use App\Interfaces\PageInterface;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageRepository implements PageInterface{
    
    public function profilePage()
    {
        $userPosts = Post::where('user_id', Auth::id())
        ->withCount('likes')
        ->with(['comments' => function ($query) {
            $query->withCount('likesComment');
        }])
        ->with('likes.user')
        //->with('comment_likes.user')
        ->get();
        $userPosts = $this->buildCommentTree($userPosts);

        return ['userPosts'=>$userPosts];
    }

    protected function buildCommentTree($comments, $parentId = null)
    {
        $tree = [];

        foreach ($comments as $comment) {
            if ($comment->parent_id === $parentId && !$this->commentAlreadyInTree($tree, $comment->id)) {
                $comment->replies = $this->buildCommentTree($comments, $comment->id);
                $tree[] = $comment;
            }
        }

        return $tree;
    }

    protected function commentAlreadyInTree($tree, $commentId)
    {
        foreach ($tree as $node) {
            if ($node->id === $commentId) {
                return true;
            }
        
            if (!empty($node->replies) && $this->commentAlreadyInTree($node->replies, $commentId)) {
                return true;
            }
        }
    
        return false;
    }

    public function showEditPostPage(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        return $post;
    }

    public function showAddFriendsPage()
    {
        $users = User::where('id', '!=', auth()->id())
        ->whereDoesntHave('friends', function ($query) {
            $query->where('friend_id', auth()->id());
        })
        ->get();
        return $users;
    }
}