
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                @if (session('message'))
                    <div class="div alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{ route('post.new') }}" method="POST">
                    @csrf
                    <textarea class="form-control" name="content" cols="30" rows="10"></textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-submit">Post</button>
                </form>
            </div>
        </div>
        <h2>My post</h2>
        @foreach($data['userPosts'] as $post)
            <div class="row bg-light mt-3">
                <div class="col-xl-6 offset-xl-3 mt-5">
                    @php
                        $userLiked = $post->likes->contains('user_id', Auth::id());
                    @endphp
                    @if($userLiked)
                        <form action="/unlike{{ $post->id }}" method="get">
                            @csrf
                            @method('DELETE')
                            <p class="justify-content-start">
                                <strong>{{ Auth::user()->name }}</strong> 
                                | Post created: {{ \Carbon\Carbon::parse($post->created_at)->format('D M j H:i:s') }} 
                                | Total likes: {{ $post->likes_count }} | <a class="link" href="/unlike{{ $post->id }}">Unlike</a> 
                            </p>
                        </form>
                        <button class="btn btn-info"><a href="/edit-post/{{ $post->id }}">Edit</a></button>
                        <form action="{{ route('profile.deletePost', ['id' => $post->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"><a href="">Delete</a></button>
                        </form>
                    @else
                        <form action="/like{{ $post->id }}" method="get">
                            @csrf
                            <p class="justify-content-start">
                                <strong>{{ Auth::user()->name }}</strong> 
                                | Post created: {{ \Carbon\Carbon::parse($post->created_at)->format('D M j H:i:s') }} 
                                | Total likes: {{ $post->likes_count }} | <a class="link" href="/like{{ $post->id }}">Like</a> 
                            </p>
                        </form>
                        <div class="row">
                            <div class="col-xl-12 d-flex">
                                <button class="btn btn-info"><a href="/edit-post/{{ $post->id }}">Edit</a></button>
                                <form action="{{ route('profile.deletePost', ['id' => $post->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <p>{{ $post->content }}</p>
                    <hr>
                    <form method="POST" class="d-flex" action="{{ route('profile.newComment') }}">
                        @csrf
                        <input placeholder="Enter your comment" type="text" name="comment" class="form-control">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class="btn btn-success">Post comment</button>
                        @error('comment')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </form>
                    @include('partials.comments', ['comments' => $post->comments])
                </div>
            </div>
        @endforeach
    </div>
@endsection