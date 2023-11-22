@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <form action="/editPost/" method="POST">
                    @csrf
                    @method('PUT')
                    <textarea class="form-control" name="content" cols="30" rows="10">
                        {{$post->content}}
                    </textarea>
                    <input type="hidden" name="id" value="{{ $post->id }}">
                    <button type="submit" class="btn btn-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection