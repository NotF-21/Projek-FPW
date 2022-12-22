@extends('layout.customer')
@section('title', 'Keranjang')

@section('content')
    @if (Session::has('scsdel'))
        <label for="" class="text-danger">{{Session::get('scsdel')}}</label>
    @endif
    @foreach ($cart->chunk(3) as $chunk)
        <div class="row mt-2 px-2">
            @foreach ($chunk as $key=>$product)
                <div class="card p-3 bg-white mx-4">
                    <div class="about-product text-center mt-2 mb-2"><img src="{{asset("storage/imgProduct/product_$product->product_id")}}" width="300">
                        <div>
                            <h4>{{$product->product_name}}</h4>
                        </div>
                    </div>
                    <div class="stats mt-2">
                        <div class="d-flex justify-content-between p-price"><span>Jumlah</span><span>{{$amount[$key]}}</span></div>
                    </div>
                    <div class="d-flex justify-content-between total font-weight-bold mt-4"><span>Harga</span><span>Rp{{number_format($product->product_price,0,',','.')}}</span></div>
                    <div class="rom mt-2">
                        <a href="{{url("customer/cart/delete/$product->product_id")}}" class="btn btn-danger">Hapus dari Keranjang</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <hr>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Alamat Pengantaran</span>
        </div>
        <input type="text" id="alamatp" name="addr" class="form-control" placeholder="Alamat Pengantaran" aria-label="Username" aria-describedby="basic-addon1" value="{{old('addr', Auth::user()->customer_address)}}">
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Promo</label>
        </div>
        <select class="custom-select" id="promoGSelect">
            @if (count($promoGlobal))
                <option selected value="0">Pilih...</option>
                @foreach ($promoGlobal as $p)
                        <option type="{{$p->type->promo_type_name}}" amount="{{$p->promo_global_amount}}" value="{{$p->promo_global_id}}">{{$p->promo_global_name}} - {{$p->type->promo_type_name}} @if ($p->type->promo_type_name=="Diskon")
                            {{$p->promo_global_amount}}%
                        @else
                            Rp{{number_format($p->promo_global_amount,0,',','.')}}
                        @endif</option>
                @endforeach
            @else
                <option selected value="empty">Tidak ada promo !</option>
            @endif
        </select>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Promo</label>
        </div>
        <select class="custom-select" id="promoselect">
            @if (count($promo))
                <option selected value="0">Pilih...</option>
                @foreach ($promo as $p)
                        <option type="{{$p->type->promo_type_name}}" amount="{{$p->promo_amount}}" value="{{$p->promo_id}}">{{$p->promo_name}} - {{$p->type->promo_type_name}} @if ($p->type->promo_type_name=="Diskon")
                            {{$p->promo_amount}}%
                        @else
                            Rp{{number_format($p->promo_amount,0,',','.')}}
                        @endif</option>
                @endforeach
            @else
                <option selected value="empty">Tidak ada promo !</option>
            @endif
        </select>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Voucher</label>
        </div>
        <select class="custom-select" id="voucherSelect">
            <option selected value="0">Pilih...</option>
            @foreach ($voucher as $v)
                    <option type="{{$v->voucher->type->promo_type_name}}" amount="{{$v->voucher->voucher_amount}}" value="{{$v->voucher_customer_id}}">{{$v->voucher->voucher_name}} - {{$v->voucher->type->promo_type_name}} @if ($v->voucher->type->promo_type_name=="Diskon")
                        {{$v->voucher->voucher_amount}}%
                    @else
                        Rp{{number_format($v->voucher->voucher_amount,0,',','.')}}
                    @endif</option>
            @endforeach
        </select>
    </div>

    <hr>

    <div class="row mt-2 px-2" style="display: block">
        <h5>Total</h5>
        <p style="text-align:right">
            <span style="float:left">Harga awal : </span>
            <span id="init">{{$total}}</span>
        </p>
    </div>
    <div class="row mt-2 px-2" style="display: block" id="promoGW">

    </div>
    <div class="row mt-2 px-2" style="display: block" id="promoW">

    </div>
    <div class="row mt-2 px-2" style="display: block" id="voucherW">

    </div>
    <div class="row mt-2 px-2" style="display: block" id="totalW">

    </div>
    <div class="row mt-2 px-2" style="display: block" id="totalP">
        <h5 style="text-align:right">
            <span style="float:left">Total : </span>
            <span id="tw">{{$total}}</span>
        </h5>
    </div>
    <div class="fixed" style="bottom: 0; width:100%; display:flex; justify-content:center;">
        <button id="btnBayar" class="btn btn-primary">Bayar</button>
    </div>
@endsection


@section('script')
    <script>
        $('#promoGSelect').on('change', function (e) {
            var init = {{$total}};
            var opt = $(this).find("option:selected");
            var type = opt.attr("type");
            var amount = opt.attr("amount");

            if (type!=null) {
                if (type=="Diskon") {
                    amount = amount*init/100;
                }
                document.getElementById("promoGW").innerHTML = "<p style='text-align:right'><span style='float:left'>Promo : </span><span id='tgw'>".concat(amount).concat("</span></p>");
            } else {
                document.getElementById("promoGW").innerHTML = "";
            }
            var tgw = 0;
            var tpw = 0;
            var tvw = 0;
            if (document.getElementById("tgw")!=null) tgw = document.getElementById("tgw").innerText;
            if (document.getElementById("tpw")!=null) tpw = document.getElementById("tpw").innerText;
            if (document.getElementById("tvw")!=null) tvw = document.getElementById("tvw").innerText;

            var total = parseInt(tgw) + parseInt(tpw) + parseInt(tvw);
            var final = parseInt(init) - parseInt(total);

            document.getElementById("totalW").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Potongan : </span><span id='tw'>".concat(total).concat("</span></h5>");
            document.getElementById("totalP").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Pembayaran : </span><span id='tw'>".concat(final).concat("</span></h5>");
        });
        $('#promoselect').on('change', function (e) {
            var init = {{$total}};
            var opt = $(this).find("option:selected");
            var type = opt.attr("type");
            var amount = opt.attr("amount");

            if (type!=null) {
                if (type=="Diskon") {
                    amount = amount*init/100;
                }

                document.getElementById("promoW").innerHTML = "<p style='text-align:right'><span style='float:left'>Promo : </span><span id='tpw'>".concat(amount).concat("</span></p>");
            } else {
                document.getElementById("promoW").innerHTML = "";
            }

            var tgw = 0;
            var tpw = 0;
            var tvw = 0;
            if (document.getElementById("tgw")!=null) tgw = document.getElementById("tgw").innerText;
            if (document.getElementById("tpw")!=null) tpw = document.getElementById("tpw").innerText;
            if (document.getElementById("tvw")!=null) tvw = document.getElementById("tvw").innerText;

            var total = parseInt(tgw) + parseInt(tpw) + parseInt(tvw);
            var final = parseInt(init) - parseInt(total);

            document.getElementById("totalW").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Potongan : </span><span id='tw'>".concat(total).concat("</span></h5>");
            document.getElementById("totalP").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Pembayaran : </span><span id='tw'>".concat(final).concat("</span></h5>");
        });
        $('#voucherSelect').on('change', function (e) {
            var init = {{$total}};
            var opt = $(this).find("option:selected");
            var type = opt.attr("type");
            var amount = opt.attr("amount");

            if (type!=null) {
                if (type=="Diskon") {
                    amount = parseInt(amount)*parseInt(init)/100;
                }

                document.getElementById("voucherW").innerHTML = "<p style='text-align:right'><span style='float:left'>Voucher : </span><span id='tvw'>".concat(amount).concat("</span></p>");
            } else {
                document.getElementById("voucherW").innerHTML = "";
            }
            var tgw = 0;
            var tpw = 0;
            var tvw = 0;
            if (document.getElementById("tgw")!=null) tgw = document.getElementById("tgw").innerText;
            if (document.getElementById("tpw")!=null) tpw = document.getElementById("tpw").innerText;
            if (document.getElementById("tvw")!=null) tvw = document.getElementById("tvw").innerText;

            var total = 0 + parseInt(tgw) + parseInt(tpw) + parseInt(tvw);
            var final = parseInt(init) - parseInt(total);

            document.getElementById("totalW").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Potongan : </span><span id='tw'>".concat(total).concat("</span></h5>");
            document.getElementById("totalP").innerHTML = "<h5 style='text-align:right'><span style='float:left'>Total Pembayaran : </span><span id='tw'>".concat(final).concat("</span></h5>");
        });

        var payButton = document.getElementById('btnBayar');
            payButton.addEventListener('click', function () {
                var valuepg = $('#promoGSelect').find(":selected").val();
                var valuep = $('#promoselect').find(":selected").val();
                var valuev = $('#voucherSelect').find(":selected").val();
                var alamat = $("#alamatp").val();

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('customer/bayar')}}",
                    data: {
                        _token : "{{ csrf_token() }}",
                        promog : valuepg,
                        promo : valuep,
                        voucher : valuev,
                        alamat : alamat,
                    },
                    success: function (response) {
                        var res = JSON.parse(response);
                        window.snap.pay(res.token);
                    },
                    error:function(xhr, status, error){
                        alert(xhr.responseText);
                    }
                });
            });
    </script>
@endsection
