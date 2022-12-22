@extends('layout.shop')
@section('title', 'Chatroom')

@section('content')
    @foreach ($rooms as $room)
        <div class="card ml-2" style="width: 90%;">
            <div class="header">
                <h4 class="title">{{$room->customer->customer_name}}</h4>
            </div>
            <div class="card-body">
                <a href="{{url("shop/chat/$room->Chatroom_id")}}" class="btn btn-primary btn-fill pull-right">Chat</a>
                <div class="clearfix"></div>
            </div>
        </div>
    @endforeach
@endsection
