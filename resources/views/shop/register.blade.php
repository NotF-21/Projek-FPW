@extends('layout.logreg')

@section('title', 'Register Shop')
@section('image', url('css/login.jpg'))

@section('content')
    <h2>Register Shop</h2>
    <form action="#" method="post">
        @csrf
        <div class="inputs">
            <input type="text" placeholder="Enter your username" name="username" value="{{old('username', '')}}">
            @error('username')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="password" placeholder="Enter your password" name="password">
            @error('password')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="password" placeholder="Enter your confirmation" name="confirm">
            @error('confirm')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your shop name" name="name" value="{{old('name', '')}}">
            @error('name')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your shop address" name="address" value="{{old('address', '')}}">
            @error('address')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your email address" name="address" value="{{old('address', '')}}">
            @error('address')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your phone number" name="phonenumber" value="{{old('phonenumber', '')}}">
            @error('phonenumber')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your account number" name="account" value="{{old('account', '')}}">
            @error('account')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror

        </div>
        <br><br>
        <p>Already have an account ? <a style="display: inline;" href="/login">Login</a></p>
        <button>Register</button>
    </form>
@endsection
