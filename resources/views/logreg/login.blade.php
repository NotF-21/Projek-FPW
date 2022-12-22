@extends('layout.logreg')

@section('image', url('css/login.jpg'))
@section('title', 'Login')

@section('content')
    <h5>Login</h5>
    @if (Session::has('Message'))
        <label for="" class="text-danger" style="font-weight: bold">{{Session::get('Message')}}</label>
    @endif
    <form action="#" method="post">
        @csrf
        <div class="inputs">
            <input type="text" placeholder="Enter your username" name="username" value="{{old('username', '')}}">
            @error('username')
                <p style="color: red">{{$message}}</p>
            @enderror
            <input type="password" placeholder="Enter your password" name="password">
            @error('password')
                <p style="color: red">{{$message}}</p>
            @enderror
        </div>
        <br>
        <div class="remember-me--forget-password">
            <input type="checkbox" name="" id="" style="display: inline-block">
            <label for="">Remember me</label>
        </div>
        <p>Don't have an account? <br><a style="display: inline; margin-bottom:2%" href="/register/customer">Create Your Account (for customer)</a> <br> <a style="display: inline;" href="/register/shop">Create Your Account (for shop)</a></p>
        <button>Login</button>
    </form>
@endsection
