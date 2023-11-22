<?php

namespace App\Http\Controllers;

use App\Repositories\LikeRepository;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {   
        $this->likeRepository = $likeRepository;
    }

    public function likePost(Request $request, $id)
    {
        $this->likeRepository->likePost($request, $id);
        return redirect()->back();
    }

    public function unlikePost(Request $request, $id)
    {
        $this->likeRepository->unlikePost($request, $id);
        return redirect()->back();
    }
}
