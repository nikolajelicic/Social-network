<div class="card mb-3 ml-4">
    <div class="card-body">
        <h6 class="h6">Comment owner: <a href="/friend-profile/{{ $comment->user->slug }}">{{ $comment->user->name }}</a></h6>
        Total likes: <button data-bs-target="#likesModal" data-bs-toggle="modal" class="commentLikes" data-comment-id="{{ $comment->id }}">{{ $comment->likes_comment_count  }}</button>
        @if($comment->likesComment->contains('user_id', auth()->id()))
            <form action="/unlikeComment{{ $comment->id }}" method="get">
                @csrf
                @method('delete')
                <p class="justify-content-start">Comment created: {{ \Carbon\Carbon::parse($comment->created_at)->format('D M j H:i:s') }} | <a class="link" href="/commentUnlike{{ $comment->id }}">Unlike</a></p>
            </form>
        @else
            <form action="/likeComment{{ $comment->id }}" method="get">
                @csrf
                <p class="justify-content-start">Comment created: {{ \Carbon\Carbon::parse($comment->created_at)->format('D M j H:i:s') }} | <a class="link" href="/commentLike{{ $comment->id }}">Like</a></p>
            </form>
        @endif
        @if ($comment->user_id == auth()->id())
            <form action="/delete-comment/{{ $comment->id }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Delete comment</button>
            </form>
            <a class="btn btn-info" href="/edit-comment/{{ $comment->id }}">Edit comment</a>
        @endif
        <p class="card-text">{{ $comment->content }}</p>
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

        @if ($comment->replies->count() > 0)
            <div class="ml-4 mt-2">
                @foreach ($comment->replies as $reply)
                    @include('partials.comment', ['comment' => $reply])
                @endforeach
            </div>
        @endif
    </div>
</div>