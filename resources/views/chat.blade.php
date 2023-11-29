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
                                                <a href="chat/{{ $friend->id }}">
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
                                    <span>To: <span class="name">Ime usera kojem se pise</span></span>
                                </div>
                                <div class="chat-container">
                                    <ul class="chat-box chatContainerScroll">
                                        @foreach ($messages as $message)
                                            @if ($message->sender_id == auth()->id())
                                                <li class="chat-right">
                                                    <div class="chat-avatar">
                                                        <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                        <div class="chat-name">{{  Auth::user()->name }}</div>
                                                    </div>
                                                    <div class="chat-text">{{ $message->content }}</div>
                                                </li>
                                            @else
                                                <li class="chat-left">
                                                    <div class="chat-avatar">
                                                        <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                        <div class="chat-name">{{ $message->user->name }}</div>
                                                    </div>
                                                    <div class="chat-text">{{ $message->content }}</div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <div class="form-group mt-3 mb-0">
                                        <textarea class="form-control" rows="3" placeholder="Type your message here..."></textarea>
                                    </div>
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
@endsection