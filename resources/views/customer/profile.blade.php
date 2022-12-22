@extends('layout.customer')
@section('title', 'Profile')

@section('content')
<div class="card rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-6 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                {{-- <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"> --}}
                <span class="font-weight-bold">{{Auth::user()->customer_name}}</span>
                <span class="text-black-50">{{Auth::user()->customer_username}}</span>
                <button class="btn btn-primary" id="btnSwitch">Switch Account</button>
                @error('msgSL')
                    <label for="" class="text-danger">{{$message}}</label>
                @enderror
                {{-- <button id="btnPP" class="btn btn-primary">Switch Profile Picture</button> --}}
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                    @if (Session::has('msg'))
                        <label for="" class="text-success">{{Session::get('msg')}}</label>
                    @endif
                </div>
                <form action="/customer/profile/update" method="post">
                    @csrf
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" value="{{old('username', Auth::user()->customer_username)}}">
                            @error('username')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Nama Customer</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Customer" value="{{old('name', Auth::user()->customer_name)}}">
                            @error('name')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Alamat Customer</label>
                            <input type="text" name="address" class="form-control" placeholder="Alamat Customer" value="{{old('address', Auth::user()->customer_address)}}">
                            @error('address')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Nomor Telepon Customer</label>
                            <input type="text" name="phonenumber" class="form-control" placeholder="Nomor Telepon Customer" value="{{old('phonenumber', Auth::user()->customer_phonenumber)}}">
                            @error('phonenumber')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Nomor Rekening Customer</label>
                            <input type="text" name="accountnumber" class="form-control" placeholder="Nomor Rekening Customer" value="{{old('accountnumber', Auth::user()->customer_accountnumber)}}">
                            @error('accountnumber')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Password (Wajib)</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            @error('password')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Password Baru (Opsional)</label>
                            <input type="password" name="new" class="form-control" placeholder="Password Baru">
                            @error('new')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Konfirmasi Password Baru</label>
                            <input type="password" name="new-confirm" class="form-control" placeholder="Konfirmasi Password Baru">
                            @error('new-confirm')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal" tabindex="-1" id="modalSwitch">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Switch Account</h5>
            </div>
            <div class="modal-body">
                <p>Pilih salah satu akun Anda</p>
                @foreach ($list as $key=>$account)
                    <a href="{{url("customer/switch/$account->switch_customer_2")}}"><button class="btn btn-primary">{{$acc[$key]->customer_name}}</button></a><br>
                @endforeach
                <button id="btnLogin" class="btn btn-warning mt-4">Login</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalLogin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
            </div>
            <div class="modal-body">
                <p>Masukkan username dan password Anda</p>
                <form action="/customer/profile/login" method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Username</label>
                            <input type="text" name="usernamel" class="form-control" placeholder="Username" value="{{old("usernamel", "")}}">
                            @error('usernamel')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Password</label>
                            <input type="password" name="passwordl" class="form-control" placeholder="Password">
                            @error('passwordl')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3 ml-1">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $("#btnSwitch").on('click', function (e) {
            $("#modalSwitch").modal("show");
        });
        $("#btnLogin").on('click', function (e) {
            $("#modalSwitch").modal("hide");
            $("#modalLogin").modal("show");
        });
    </script>
@endsection
