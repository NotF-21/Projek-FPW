@extends('layout.logreg')

@section('title', 'Register Customer')
@section('image', url('css/login.jpg'))

@section('content')
    <h2>Register Customer</h2>
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
            <input type="text" placeholder="Enter your name" name="name" value="{{old('name', '')}}">
            @error('name')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
            <input type="text" placeholder="Enter your address" name="address" value="{{old('address', '')}}">
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
            <p class="mt-2">Choose your gender</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="male" style="width: auto">
                <label class="form-check-label" for="inlineRadio2">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="female" style="width: auto">
                <label class="form-check-label" for="inlineRadio3">Female</label>
            </div>
            @error('gender')
                <label for="" class="text-danger">{{$message}}</label>
            @enderror
        </div>
        <br><br>
        <p>Already have an account ? <a style="display: inline;" href="/login">Login</a></p>
        <button>Register</button>
    </form>
@endsection
