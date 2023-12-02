<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CommentLikeInterface{

    public function likeComment(Request $request, $id);

    public function unlikeComment(Request $request, $id);

    public function showWhoIsLikesComment($id);
}