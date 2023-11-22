<?php 

namespace App\Services;

use App\Repositories\CommentLikeRepository;
use Illuminate\Http\Request;

class CommentLikeService {

    private $commentLikeRepository;

    public function __construct(CommentLikeRepository $commentLikeRepository) {
        $this->commentLikeRepository = $commentLikeRepository;
    }

    public function likeComment(Request $request, $id)
    {   
        $this->commentLikeRepository->likeComment($request, $id);
    }

    public function unlikeComment(Request $request, $id)
    {   
        $this->commentLikeRepository->unlikeComment($request, $id);
    }
}