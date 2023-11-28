<?php 

namespace App\Repositories;

use App\Http\Requests\CreateNewPostRequest;
use App\Interfaces\PostInterface;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostRepository implements PostInterface{

    public function createNewPost($content)
    {
        $limitedContent = Str::limit($content, 26, '');
        $slug = Str::slug($limitedContent);
        $existingSlug = Post::where('slug', $slug)->first();
        if ($existingSlug) {
            $slug = $slug . '-' . uniqid();
        }

        $post = new Post();
        $post->insert([
            'content' => $content,
            'slug' => $slug,
            'user_id' => Auth::id(),
            'created_at'=>now()
        ]);
    }

    public function editPost(CreateNewPostRequest $request)
    {
        $post = Post::findOrFail($request->input('id'));
        $content = $request->input('content');

        $limitedContent = Str::limit($content, 26, '');
        $slug = Str::slug($limitedContent);

        if($post){
            $post->update([
                'content' => $content,
                'slug' => $slug,
                'updated_at' => now()
            ]);
        }
    }

    public function deletePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
    }

    public function getPostBySlug(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if($post){
            return $post;
        }
    }

    public function showLikes($postId)
    {
        $likes = Like::where('post_id', $postId)
        ->with('user')
        ->get();

        return $likes;
    }
}