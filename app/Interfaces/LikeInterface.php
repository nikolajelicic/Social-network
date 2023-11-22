<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface LikeInterface{

    public function likePost(Request $request, $id);

    public function unlikePost(Request $request, $id);
}