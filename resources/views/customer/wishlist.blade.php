@extends('layout.customer')
@section('title', 'Wishlist')

@section('content')
    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Daftar Favorit</span>
                </div>
            </div>
        </div>
    </div>

    @foreach ($favs->chunk(3) as $i=>$chunk)
    <div class="row mt-2 px-2">
        @foreach ($chunk as $j=>$p)
            <div class="card p-3 bg-white mx-4">
                <div class="about-product text-center mt-2 mb-2"><img src="{{asset("storage/imgProduct/product_$p->product_id")}}" width="300" height="300">
                    <div>
                        <h4>{{$p->product_name}}</h4>
                        <h6 class="mt-0 text-black-50">{{$p->product_desc}}</h6>
                    </div>
                </div>
                <div class="stats mt-2">
                    <div class="d-flex justify-content-between p-price"><span>Kategori</span><span>{{$p->type->Type_Name}}</span></div>
                    @if ($p->product_stock==0)
                        <div class="d-flex justify-content-between p-price text-danger"><span>Habis !</span></div>
                    @endif
                </div>
                <div class="d-flex justify-content-between total font-weight-bold mt-4"><span>Harga</span><span>Rp{{number_format($p->product_price,0,',','.')}}</span></div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <a href="{{url("customer/toko=".$p->shop->shop_name)}}" class="btn btn-success">Lihat Toko</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endforeach
@endsection
