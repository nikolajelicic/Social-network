@extends('layouts.app')
@php
    //dd($users)
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <h1 class="h1">Add friends</h1>
                <ul class="list-group">
                    @foreach($users as $user)
                        <div class="d-flex">
                            <li class="list-group-item">{{ $user->name }}</li>
                            <form action="{{ route('profile.newFriendRequest') }}" method="POST">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-success">Add to friends</button>
                            </form>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="xol-xl-6 offset-xl-3">
                <ul class="list-group">
                        @foreach ($friends as $friend)
                            @if($friend != null)
                            <h1 class="h1 mt-5">My friends</h1>
                                @foreach ($friend as $user)
                                    <div class="d-flex">
                                        <li class="list-group-item">{{ $user->name }}</li>
                                        <form action="{{ route('profile.deleteFriendRequest') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-danger">Delete friend</button>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <h1 class="h1 mt-5">You don't have a friends</h1>
                            @endif
                        @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="xol-xl-6 offset-xl-3">
                <ul class="list-group">
                        @foreach ($requests as $request)
                            <h1 class="h1 mt-5">My friends</h1>
                                <div class="d-flex">
                                    <li class="list-group-item">{{ $request->user->name }}</li>
                                    <form action="{{ route('profile.acceptFriendRequest') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="senderId" value="{{ $request->user->id}}">
                                        <button type="submit" class="btn btn-danger">Accept request</button>
                                    </form>
                                </div>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection