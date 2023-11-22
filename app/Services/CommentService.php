<?php 

namespace App\Services;

use App\Http\Requests\CreateNewPostRequest;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentService {

    private $commentRepository;

    public function __construct(CommentRepository $commentRepository) 
    {
        $this->commentRepository = $commentRepository;
    }

    public function deleteComment(Request $request, $id)
    {
        $this->commentRepository->deleteComment($request, $id);
    }

    public function newComment(Request $request)
    {
        $this->commentRepository->newComment($request);
    }
}