@foreach($comments as $comment)
    <div class="comment mb-3 ml-3">
        Total number of comment likes: <button data-bs-target="#likesModal" data-bs-toggle="modal" class="commentLikes" data-comment-id="{{ $comment->id }}">{{ $comment->likes_comment_count  }}</button>
        @if($comment->likesComment->contains('user_id', auth()->id()))
            <form action="/unlikeComment{{ $comment->id }}" method="get">
                @csrf
                @method('delete')
                <p class="justify-content-start"><strong>{{ $comment->user->name }}</strong> | Post created: {{ \Carbon\Carbon::parse($comment->created_at)->format('D M j H:i:s') }} | <a class="link" href="/commentUnlike{{ $comment->id }}">Unlike</a></p>
            </form>
        @else
            <form action="/likeComment{{ $comment->id }}" method="get">
                @csrf
                <p class="justify-content-start"><strong>{{ $comment->user->name }}</strong> | Post created: {{ \Carbon\Carbon::parse($comment->created_at)->format('D M j H:i:s') }} | <a class="link" href="/commentLike{{ $comment->id }}">Like</a></p>
            </form>
        @endif
        <div class="row">
            <div class="col-xl-12">
                <form action="/delete-comment/{{ $comment->id }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete comment</button>
                </form>
                @if($comment->user_id == auth()->id())
                    <a class="btn btn-info" href="/edit-comment/{{ $comment->id }}">Edit commentt</a>
                @endif
            </div>
        </div>
        <p>{{ $comment->content }}</p>
        <hr>
        <form method="POST" class="d-flex" action="{{ route('profile.newComment') }}">
            @csrf
            <input placeholder="Enter your comment" type="text" name="comment" class="form-control">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <button class="btn btn-success">Post comment</button>
            @error('comment')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
        <hr>            
        @include('partials.comments', ['comments' => $comment->replies])
    </div>
@endforeach