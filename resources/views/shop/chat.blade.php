@extends('layout.shop')
@section('title', "Chat $customer")

@section('css')
    <style>
        .chat
        {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li
        {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #B3A9A9;
        }

        .chat li.left .chat-body
        {
            margin-left: 60px;
        }

        .chat li.right .chat-body
        {
            margin-right: 60px;
        }


        .chat li .chat-body p
        {
            margin: 0;
            color: #777777;
        }

        .panel .slidedown .glyphicon, .chat .glyphicon
        {
            margin-right: 5px;
        }

        .panel-body
        {
            overflow-y: scroll;
            height: 250px;
        }

        ::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #555;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Chat
            </div>
            <div class="panel-body">
                <ul class="chat">
                    @foreach ($chats as $chat)
                        @if ($chat->chat_sender=="shop")
                            <li class="right clearfix">
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <small class=" text-muted">{{date('F j, Y, g:i a',strtotime($chat->created_at))}}</small>
                                        <a href="{{url("shop/chat/delete/$chat->chat_id")}}" class="btn btn-danger btn-fill btn-sm rounded-0" title="Delete"><i class="fa fa-trash"></i></a>
                                        <strong class="pull-right primary-font">Me</strong>
                                    </div>
                                    <p>
                                        {{$chat->chat_content}}
                                    </p>
                                </div>
                            </li>
                        @else
                            <li>
                                <div class="chat-body">
                                    <div class="header">
                                        <strong class="primary-font">{{$customer}}</strong> <small class="pull-right text-muted">{{date('F j, Y, g:i a',strtotime($chat->created_at))}}</small>
                                    </div>
                                    <p>
                                        {{$chat->chat_content}}
                                    </p>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="panel-footer">
                <form action="/shop/chat/send" method="post">
                    @csrf
                    <input type="hidden" name="room" value="{{$room}}">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" name="content" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat">
                                Send</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
