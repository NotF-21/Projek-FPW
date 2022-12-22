@extends('layout.customer')
@section('title', 'Daftar Transaksi')

@section('content')
    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">History Transaksi</span>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Nomor Nota</th>
                        <th>Tanggal Transaksi</th>
                        <th>Toko</th>
                        <th>Total</th>
                        <th>Detail</th>
                        <th>Status (Apakah Anda sudah menerima pesanan Anda ?)</th>
                    </thead>
                    <tbody>
                        @foreach ($list as $key=>$trans)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$trans->invoice_number}}</td>
                                <td>{{date('F j, Y, g:i a',strtotime($trans->trans_date))}}</td>
                                <td>{{$shops[$key]->shop_name}}</td>
                                <td>Rp{{number_format($trans->trans_total,0,',','.')}}</td>
                                <td>
                                    <button tag="{{$trans->invoice_number}}" class="btn btn-primary btn-detail">Detail</button>
                                </td>
                                <td>
                                    @if ($trans->order_status=="waiting")
                                    Menunggu
                                    @elseif ($trans->order_status=="confirmed")
                                    Terkonfirmasi
                                    @elseif ($trans->order_status=="sent")
                                    Dalam Pengiriman
                                    <a href="{{url("customer/receive/$trans->invoice_number")}}" class="btn btn-success">Klik jika sudah menerima pesanan !</a>
                                    @elseif ($trans->order_status="received")
                                    Sudah Sampai
                                    @else
                                    Dibatalkan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal" tabindex="-1" id="modalReview">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Review Transaksi</h5>
                </div>
                <div class="modal-body">
                    <p>Pilih rating yang sesuai untuk transaksi ini</p>
                    <form action="/customer/review" method="post">
                        @csrf
                        <input type="hidden" name="shop" value="0">
                        <div class="row mt-3 px-3">
                            <div class="col-md-12">
                                <input type="number" max="5" min="0" step="1" name="rating" class="form-control" placeholder="Rating">
                            </div>
                        </div>
                        <div class="row mt-3 px-3">
                            <div class="col-md-12">
                                <input type="text" name="review" class="form-control" placeholder="Review Anda">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($list as $key=>$t)
        <div class="modal modalTrans" tabindex="-1" id="modal_{{$t->invoice_number}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Transaksi</h5>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details[$key] as $detail)
                                    <tr>
                                        <td>{{$detail->product->product_name}}</td>
                                        <td>Rp{{number_format($detail->product->product_price,0,',','.')}}</td>
                                        <td>{{$detail->product_number}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <p>Promo yang dipakai : @if ($promo[$key]=="empty")
                                Tidak ada
                                @else
                                {{$promo[$key]->promo_name}}
                            @endif</p>
                        </div>
                        <div class="row">
                            <p>Promo yang dipakai : @if ($pg[$key]=="empty")
                                Tidak ada
                                @else
                                {{$pg[$key]->promo_global_name}}
                            @endif</p>
                        </div>
                        <div class="row">
                            <p>Voucher yang dipakai : @if ($voucher[$key]=="empty")
                                Tidak ada
                                @else
                                {{$voucher[$key]->voucher_name}}
                            @endif</p>
                        </div>
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
         $(".btn-detail").on("click", function (e) {
            var id = "#modal_" + $(this).attr("tag");
            $(id).modal("show");
        });
    </script>

    <script>
        @if (Session::has('rev'))
            $("input[name=shop]").val("{{Session::get('rev')}}");
            $("#modalReview").modal("show");
        @endif
    </script>
@endsection
