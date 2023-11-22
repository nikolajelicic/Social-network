<?php 

namespace App\Services;

use App\Repositories\LikeRepository;
use Illuminate\Http\Request;

class LikeService {

    private $likeRepository;

    public function __construct(LikeRepository $likeRepository) {
        $this->likeRepository = $likeRepository;
    }

    public function likePost(Request $request, $id)
    {   
        $this->likeRepository->likePost($request, $id);
    }

    public function unlikePost(Request $request, $id)
    {   
        $this->likeRepository->unlikePost($request, $id);
    }
}