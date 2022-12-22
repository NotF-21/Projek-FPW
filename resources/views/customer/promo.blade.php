@extends('layout.customer')
@section('title', 'Daftar Promo')

@section('content')
    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Promo yang berlaku sekarang !</span>
                </div>
            </div>
            <div class="col-12 p-4">
                @foreach ($promos as $key=>$p)
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <div class="card p-3">
                                <div class="card-block">
                                    <h4 class="card-title">{{$p->promo_global_name}}</h4>
                                    <h6 class="card-subtitle text-muted mb-3">{{$p->type->promo_type_name}} @if ($p->type->promo_type_name=="Potongan")
                                        Rp{{number_format($p->promo_global_amount,0,',','.')}}
                                    @else
                                        {{$p->promo_global_amount}}%
                                    @endif</h6>
                                    <h6 class="card-subtitle mb-3">{{date('F j, Y',strtotime($p->promo_global_expiredate))}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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

    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Voucher yang ada sekarang !</span>
                </div>
            </div>
            <div class="col-12 p-4">
                @foreach ($vouchers as $key=>$v)
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <div class="card p-3">
                                <div class="card-block">
                                    <h4 class="card-title">{{$v->voucher->voucher_name}}</h4>
                                    <h6 class="card-subtitle text-muted mb-3">{{$v->voucher->type->promo_type_name}} @if ($v->voucher->type->promo_type_name=="Potongan")
                                        Rp{{number_format($v->voucher->voucher_amount,0,',','.')}}
                                    @else
                                        {{$v->voucher->voucher_amount}}%
                                    @endif</h6>
                                    <h6 class="card-subtitle mb-3">{{date('F j, Y',strtotime($v->voucher->voucher_expiredate))}}</h6>
                                    @if ($warning[$key]=="yes")
                                        <h6 class="card-subtitle text-muted text-danger mb-3">Voucher ini akan berakhir kurang dari 2 minggu lagi !</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
