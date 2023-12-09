@extends('layouts.app')

@section('content')
    <div class="container">
        <section>
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-md-9 col-lg-7 col-xl-5">
                  <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                      <div class="d-flex text-black">
                        <div class="flex-shrink-0">
                            @if ($data['user']->image != null)
                                <img src= "{{ asset('storage/profile_images/' . $data['user']->image) }}"
                                alt="Profile image" class="img-fluid"
                                style="width: 180px; border-radius: 10px;">
                            @else
                                <img src="https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI="
                                alt="Profile image" class="img-fluid"
                                style="width: 180px; border-radius: 10px;">
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                          <h5 class="mb-1">{{ $data['user']->name }}</h5>
                          <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                            style="background-color: #efefef;">
                            <div>
                              <p class="small text-muted mb-1">Number of friends</p>
                              <p class="mb-0">{{ $data['numberOfFriends'] }}</p>
                            </div>
                          </div>
                          <div class="d-flex pt-1">
                            @if ($data['isFriend'] == 1)
                                <form action="{{ route('profile.deleteFriendRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $data['user']->id }}">
                                    <button type="submit" class="btn btn-outline-danger me-1 flex-grow-1">Delete friend</button>
                                </form>
                            @elseif ($data['isFriend'] == 2)
                                <form action="{{ route('profile.deleteFriendRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $data['user']->id }}">
                                    <button type="submit" class="btn btn-outline-danger me-1 flex-grow-1">Delete friend request</button>
                                </form>
                            @else
                                <form action="{{ route('profile.newFriendRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $data['user']->id }}">
                                    <button type="submit" class="btn btn-outline-success me-1 flex-grow-1">Add friend</button>
                                </form>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>   
        @if ($data['isFriend'] == 1)
            @foreach($data['posts'] as $post)
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
                                    <strong>{{ $post->user->name }}</strong> 
                                    | Post created: {{ \Carbon\Carbon::parse($post->created_at)->format('D M j H:i:s') }} 
                                    | Total likes: <a href="/showLikes/{{ $post->id }}">{{ $post->likes_count }}</a> 
                                    | <a class="link" href="/unlike{{ $post->id }}">Unlike</a> 
                                </p>
                            </form>
                        @else
                            <form action="/like{{ $post->id }}" method="get">
                                @csrf
                                <p class="justify-content-start">
                                    <strong>{{ $post->user->name }}</strong> 
                                    | Post created: {{ \Carbon\Carbon::parse($post->created_at)->format('D M j H:i:s') }} 
                                    | Total likes: <a href="/showLikes/{{ $post->id }}">{{ $post->likes_count }}</a> | <a class="link" href="/like{{ $post->id }}">Like</a> 
                                </p>
                            </form>
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
        @endif
    </div>
@endsection