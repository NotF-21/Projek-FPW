@extends('layout.customer')
@section('title', 'Home')

@section('content')
    <div class="card rounded bg-white mt-5 mb-5 p-3">
        <div class="row">
            <div class="col-12 mb-2">
                <span class="font-weight-normal">Terdapat {{$countp}} promo sekarang !</span>
            </div>
            <div class="row px-3">
                <div class="col-12">
                    <a href="{{url("customer/promo")}}" class="btn btn-primary">Lihat Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Cari Toko untuk Belanja !</span>
                </div>
            </div>
            <div class="col-12">
                <form action="/customer/search" method="post">
                    @csrf
                    <div class="row mt-3 px-3">
                        <div class="col-md-12">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                            @error('search')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="labels">Pilihan</label><br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" value="nama" name="choice" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline1">Nama Toko</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" value="lokasi" name="choice" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">Lokasi Toko</label>
                            </div>
                            @error('choice')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Toko yang memiliki promo sekarang !</span>
                </div>
            </div>
            <div class="col-12 p-4">
                @foreach ($shops->chunk(3) as $chunk)
                    <div class="row">
                        @foreach ($chunk as $shop)
                            <div class="col-md-4">
                                <div class="card p-3">
                                    <div class="card-block">
                                        <h4 class="card-title">{{$shop->shop_name}}</h4>
                                        <h6 class="card-subtitle text-muted mb-3">{{$shop->shop_address}}</h6>
                                        <a href="{{url("/customer/toko=$shop->shop_name")}}" class="btn btn-primary btn-fill">Lihat Toko</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
