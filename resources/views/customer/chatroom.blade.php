@extends('layout.customer')
@section('title', 'Chatroom')

@section('content')
    @foreach ($rooms as $room)
        <div class="card ml-2" style="width: 90%;">
            <div class="card-body">
                <h5 class="card-title">{{$room->shop->shop_name}}</h5>
                <a href="{{url("/customer/chat/$room->Chatroom_id")}}" class="btn btn-success">Chat</a>
            </div>
        </div>
    @endforeach
@endsection
