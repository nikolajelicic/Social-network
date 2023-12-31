<?php 

namespace App\Repositories;

use App\Interfaces\PageInterface;
use App\Models\Comment;
use App\Models\Friendship;
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


        $numberOfFriends = Friendship::where(function ($query){
            $query->where('user_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->orWhere(function ($query){
            $query->where('friend_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->count();

        return ['userPosts' => $userPosts, 'numberOfFriends' => $numberOfFriends];
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
        //Display of all users who are not friends of the registered user, and who have not been sent a friend request
        $friendIds = Friendship::where('user_id', auth()->id())
        ->orWhere('friend_id', auth()->id())
        ->where('status', 'accepted')
        ->pluck('friend_id');

        $users = User::where('id', '!=', auth()->id())
            ->whereNotIn('id', $friendIds)
            ->whereDoesntHave('friendships', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->where('user_id', auth()->id())
                        ->orWhere('friend_id', auth()->id());
                });
            })
            ->get();

        return $users;
    }

    public function showFriendPostsPage()
    {
        $friends = Friendship::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->orWhere(function ($query) {
            $query->where('friend_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->get();
        
        $friendIds = collect();
        
        foreach($friends as $friend){
            if($friend->user_id != auth()->id()){
                $friendIds = $friendIds->merge([$friend->user_id]);
            }else{
                $friendIds = $friendIds->merge([$friend->friend_id]);
            }
        }
        
        $friendIds = $friendIds->unique(); // To remove any duplicate values

        $posts = Post::whereIn('user_id', $friendIds)
        ->withCount('likes')
        ->with('user')
        ->get();

        $commentIds = Comment::whereIn('post_id', $posts->pluck('id'))->pluck('id');

        $comments = Comment::whereIn('id', $commentIds)
        ->withCount('likesComment')
        ->get();

        return compact('posts', 'comments');
    }

    public function showChatPage()
    {
        
    }

    public function profilePageBySlug($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $numberOfFriends = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'accepted');
        })
        ->orWhere(function ($query) use ($user) {
            $query->where('friend_id', $user->id)
                ->where('status', 'accepted');
        })
        ->count();

        $friend = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', auth()->id())
                ->where('friend_id', $user->id);
        })
        ->orWhere(function ($query) use ($user) {
            $query->where('friend_id', auth()->id())
                ->where('user_id', $user->id);
        })
        ->first();
        
        $isFriend = 0;

        if($friend){
            if($friend->status == 'accepted'){
                 if($friend->user_id !== auth()->id()){
                     $friendId = $friend->user_id;
                 }else{
                     $friendId = $friend->friend_id;
                 }
                
                 $posts = Post::where('user_id', $friendId)
                     ->withCount('likes')
                     ->with('user')
                     ->get();
                
                 $commentIds = Comment::whereIn('post_id', $posts->pluck('id'))->pluck('id');
                
                 $comments = Comment::whereIn('id', $commentIds)
                 ->withCount('likesComment')
                 ->get();
                 $isFriend = 1;
                 
                 return compact('posts', 'comments','user', 'isFriend','numberOfFriends');
            }else{
                $status = 'pending';
                $isFriend = 2;

                return compact('status', 'user', 'isFriend','numberOfFriends');
            }
        }else{
            return compact('user', 'isFriend','numberOfFriends');
        }
    }
}