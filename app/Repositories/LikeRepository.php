<?php 

namespace App\Repositories;

use App\Interfaces\LikeInterface;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeRepository implements LikeInterface{

    public function likePost(Request $request, $id)
    {
        $existingLike = Like::where('user_id',  Auth::id())
                            ->where('post_id', $id)
                            ->first();

        if(!$existingLike){
            $like = new Like([
                'post_id' => $request->id,
                'user_id' => Auth::id(),
                'created_at' => now()
            ]);
    
            return $like->save();
        }
    }

    public function unlikePost(Request $request, $id)
    {   
        $existingLike = Like::where('user_id',  Auth::id())
                        ->where('post_id', $id)
                        ->firstOrFail();
        if($existingLike){
            $existingLike->delete();
        }
    }
}