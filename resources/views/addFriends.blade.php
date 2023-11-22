@extends('layouts.app')

@section('content')
    @php
        //dd($friends)
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <h1 class="h1">All friends</h1>
                <ul class="list-group">
                    @foreach($dataForView as $item)
                        @php
                            //dd($item['userData'])
                        @endphp
                        @if ($item['status'] == 'accepted')
                            <div class="d-flex">
                                <li class="list-group-item">{{ $item['userData']->name }}</li>
                                <form action="{{ route('profile.deleteFriendRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $item['userData']->id }}">
                                    <button type="submit" class="btn btn-danger">Delete friend</button>
                                </form>
                            </div>
                        @elseif ($item['status'] == 'pending')
                        <div class="d-flex">
                            <li class="list-group-item">{{ $item['userData']->name }}</li>
                            <form action="{{ route('profile.deleteFriendRequest') }}" method="POST">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $item['userData']->id }}">
                                <button type="submit" class="btn btn-danger">Cancel request</button>
                            </form>
                        </div>
                        @elseif($item['status'] == 'declined' || $item['status'] == '')
                            <div class="d-flex">
                                <li class="list-group-item">{{ $item['userData']->name }}</li>
                                <form action="{{ route('profile.newFriendRequest') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $item['userData']->id }}">
                                    <button type="submit" class="btn btn-success">Add to friends</button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection