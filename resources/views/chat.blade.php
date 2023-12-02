@extends('layouts.app')
@php
    //dd($messages)
@endphp
@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">

    <!-- Page header start -->
    <div class="page-title">
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <h5 class="title">All Messages</h5>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> </div>
        </div>
    </div>
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card m-0">

                    <!-- Row start -->
                    <div class="row no-gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                            <div class="users-container">
                                <div class="chat-search-box">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-info">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="users">
                                    @foreach ($friends as $friend)
                                        @if (isset($friend->name))
                                            <li class="person" data-chat="person1">
                                                <a href="{{ $friend->id }}">
                                                    <div class="user">
                                                        <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                        <span class="status busy"></span>
                                                    </div>
                                                    <p class="name-time">
                                                        <span class="name">{{ $friend->name }}</span>
                                                        <span class="time">15/02/2019</span>
                                                    </p>
                                                </a>
                                            </li>
                                        @else
                                            @foreach ($friend as $user)
                                                <li class="person" data-chat="person1">
                                                    <a href="chat/{{ $user->id }}">
                                                        <div class="user">
                                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                            <span class="status busy"></span>
                                                        </div>
                                                        <p class="name-time">
                                                            <span class="name">{{ $user->name }}</span>
                                                            <span class="time">15/02/2019</span>
                                                        </p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @if ($messages != null)
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">
                                <div class="selected-user">
                                    @if ($messages != null && count($messages) > 0)
                                        @php
                                            $firstMessage = $messages[0];
                                        @endphp
                                        <span>To: <span class="name">{{ $firstMessage->user->name }}</span></span>
                                    @else
                                        <span>No messages available</span>
                                    @endif
                                    @if(Session::has('message'))
                                        <div  class="alert alert-info alert-dismissible fade show" role="alert">
                                            <strong>{{ Session::get('message') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="chat-container">
                                    <ul class="chat-box chatContainerScroll">
                                        @foreach ($messages as $message)
                                            @if ($message->sender_id == auth()->id())
                                                <li class="chat-right">
                                                    <div class="chat-avatar">
                                                        <img src="{{ asset('profile_images/' . Auth::user()->image)  }}" alt="Retail Admin">
                                                        <div class="chat-name">{{  Auth::user()->name }}</div>
                                                    </div>
                                                    <div class="chat-text">
                                                        {{ $message->content }}
                                                        <form action="{{ route('profile.deleteMessage') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="message" value="{{ $message->id }}">
                                                            <button type="submit" class="delete-message position-absolute top-0 end-0 text-danger pe-auto">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <button class="edit-message position-absolute top-0 start-0 text-info pe-auto" data-button-id="{{ $message->id }}" data-bs-toggle="modal" data-message="{{ $message->content }}" data-bs-target="#editMessageModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                            </svg>
                                                        </button>
                                                        @if($message->isReaded == 0)
                                                            <div class="position-absolute bottom-0 end-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="position-absolute bottom-0 end-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @else
                                                <li class="chat-left">
                                                    <div class="chat-avatar">
                                                        <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                        <div class="chat-name">{{ $message->user->name }}</div>
                                                    </div>
                                                    <div class="chat-text">
                                                        {{ $message->content }}
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <form class="form-group mt-3 mb-0 d-flex" method="POST" action="{{ route('profile.newMessage') }}">
                                        @csrf
                                        <textarea class="form-control" rows="3" placeholder="Type your message here..." name="content"> </textarea>
                                        <input type="hidden" name="receiver_id" value="{{  $receiver_id }}">
                                        <button class="btn btn-success">Send</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- Row end -->
                </div>

            </div>

        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>
<!-- Modal -->
<div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit message</h1>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <form action="{{ route('profile.editMessage') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input class="form-control" type="text" name="content" id="editMessageInput">
                    <input type="hidden" name="messageId" id="messageId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <script>
    jQuery(document).ready(function(){
        var button = $(".edit-message")
        button.click(function(){
            var messageId = this.getAttribute('data-button-id')
            var message = this.getAttribute('data-message')
            $('#editMessageInput').val(message);
            $('#messageId').val(messageId);
        })
    })
  </script>
@endsection