@extends('layouts.app')

@section('content')
    @php
        //dd($notifications)
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="list-group">
                    @foreach ($notifications as $notification)
                        @php
                            $dateTime = Carbon\Carbon::parse($notification->created_at)
                        @endphp
                        @if ($notification->read == 0)
                            <div class="list-group-item list-group-item-action active" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ str_replace('_', ' ', $notification->notifiable_type) }}</h5>
                                    <small>{{ $dateTime->diffInDays() > 0 ? $dateTime->diffForHumans() : $dateTime->diffForHumans(['parts' => 2]) }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->message }}</p>
                            </div>
                        @else
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ str_replace('_', ' ', $notification->notifiable_type) }}</h5>
                                    <small>{{ $dateTime->diffInDays() > 0 ? $dateTime->diffForHumans() : $dateTime->diffForHumans(['parts' => 2]) }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->message }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
