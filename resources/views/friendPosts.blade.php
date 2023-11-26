@extends('layouts.app')

@section('content')
@foreach ($data['posts'] as $post)
    <section style="background-color: #eee;">
        <div class="container my-5 py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                          <div class="d-flex flex-start align-items-center">
                            <img class="rounded-circle shadow-1-strong me-3"
                              src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="60"
                              height="60" />
                            <div>
                              <h6 class="fw-bold text-primary mb-1">{{ $post->user->name }}</h6>
                              <p class="text-muted small mb-0">
                                Shared publicly - {{ $post->created_at }}
                              </p>
                            </div>
                          </div>
                        
                          <p class="mt-3 mb-4 pb-2">
                            {{ $post->content }}
                          </p>
                        
                          <div class="small d-flex justify-content-start">
                            <a href="#!" class="d-flex align-items-center me-3">
                              <i class="far fa-thumbs-up me-2"></i>
                              <p class="mb-0">Total likes: {{ $post->likes_count }}</p>
                            </a>
                            @php
                                $userLiked = $post->likes->contains('user_id', Auth::id());
                            @endphp
                            @if($userLiked)
                                <a href="/unlike{{ $post->id }}" class="d-flex align-items-center me-3">
                                    <i class="far fa-thumbs-up me-2"></i>
                                    <p class="mb-0">Unlike post</p>
                                </a>
                            @else
                                <a href="/like{{ $post->id }}" class="d-flex align-items-center me-3">
                                    <i class="far fa-thumbs-up me-2"></i>
                                    <p class="mb-0">Like post</p>
                                </a>
                            @endif
                            <form method="POST" class="d-flex" action="{{ route('profile.newComment') }}">
                                @csrf
                                <input placeholder="Enter your comment" type="text" name="comment" class="form-control">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button class="btn btn-success">Post comment</button>
                                @error('comment')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </form>
                          </div>
                        </div>
                        @foreach ($data['comments']->where('post_id', $post->id)->where('parent_id', null) as $comment)
                          <div class="card mb-3 ml-4">
                              <div class="card-body">
                                  <h6 class="h6">Comment ovner: <a href="/friend-profile">{{ $comment->user->name }}</a></h6>
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
                                    @foreach ($data['comments']->where('parent_id', $comment->id) as $subcomment)
                                        <div class="card mb-2 ml-4">
                                            @if($subcomment->user_id == auth()->id())    
                                                <div class="card-body">
                                                  <h6 class="h6">Comment ovner: <a href="/friend-profile">{{ $subcomment->user->name }}</a></h6>
                                                  <form action="/delete-comment/{{ $subcomment->id }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Delete comment</button>
                                                </form>
                                                <a class="btn btn-info" href="/edit-comment/{{ $subcomment->id }}">Edit comment</a>
                                            @endif
                                                  <p class="card-text">{{ $subcomment->content }}</p>
                                                  <form method="POST" class="d-flex" action="{{ route('profile.newComment') }}">
                                                    @csrf
                                                    <input placeholder="Enter your comment" type="text" name="comment" class="form-control">
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                    <button class="btn btn-success">Post comment</button>
                                                    @error('comment')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </form>
                                              </div>
                                        </div>
                                    @endforeach
                              </div>
                          </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach
@endsection