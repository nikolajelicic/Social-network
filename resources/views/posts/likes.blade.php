@extends('layouts.app')

@section('content')
    @foreach ($likes as $like)
        {{ $like->user->name }}
    @endforeach
@endsection