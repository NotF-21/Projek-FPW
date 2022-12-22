@extends('layout.admin')
@section('title', 'Daftar Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Daftar Transaksi</h4>
                    <p class="category">Di sini Anda bisa melihat daftar seluruh transaksi yang pernah dilakukan</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>#</th>
                            <th>Nomor Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status Pembayaran</th>
                            <th>Status Transaksi</th>
                            <th>Alamat Pengiriman</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>
                            @foreach ($list as $key=>$trans)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$trans->invoice_number}}</td>
                                    <td>{{date('F j, Y',strtotime($trans->trans_date))}}</td>
                                    <td>{{$trans->customer->customer_name}}</td>
                                    <td>Rp{{number_format($trans->trans_total,0,',','.')}}</td>
                                    <td>@if ($trans->payment_status=="paid")
                                        Sudah Dibayar
                                        @elseif ($trans->payment_status=="expired")
                                        Kedaluwarsa
                                        @else
                                        Gagal Dibayar
                                    @endif</td>
                                    <td>
                                        @if ($trans->order_status=="waiting")
                                        Menunggu
                                        @elseif ($trans->order_status=="confirmed")
                                        Terkonfirmasi
                                        @elseif ($trans->order_status=="sent")
                                        Dalam Pengiriman
                                        @elseif ($trans->order_status=="received")
                                        Sudah Sampai
                                        @else
                                        Dibatalkan
                                        @endif
                                    </td>
                                    <td>{{$trans->shipping_address}}</td>
                                    <td>
                                        <button tag="{{$trans->invoice_number}}" class="btn btn-fill btn-primary btn-detail">Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">Download Daftar Transaksi</h4>
                    <p class="category">Di sini Anda bisa men-download daftar transaksi di aplikasi ini berdasarkan waktu dan toko penjual</p>
                </div>
                <div>
                    <form action="/admin/transaction/download" method="POST">
                        @csrf
                        <div class="row-p-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" name="first" placeholder="Tanggal awal">
                                    @error('first')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="last" placeholder="Tanggal akhir">
                                    @error('last')
                                        <label for="" class="text-danger">{{$message}}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Toko Penjual</label>
                                    <select name="shop" id="" class="form-control">
                                        <option value="0" disabled selected>Pilih---</option>
                                        @foreach ($shop as $s)
                                            <option value="{{$s->id}}">{{$s->shop_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-fill btn-primary pull-right">Download</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
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
                                @foreach ($t->details as $detail)
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
                        <p>Promo yang dipakai : @if ($promo[$key]=="empty")
                            Tidak ada
                            @else
                            {{$promo[$key]->promo_name}}
                        @endif</p><br>
                        <p>Promo yang dipakai : @if ($pg[$key]=="empty")
                            Tidak ada
                            @else
                            {{$pg[$key]->promo_global_name}}
                        @endif</p><br>
                        <p>Voucher yang dipakai : @if ($voucher[$key]=="empty")
                            Tidak ada
                            @else
                            {{$voucher[$key]->voucher_name}}
                        @endif</p><br>
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
            console.log($(this).attr("tag"));
            $(id).modal("show");
        });
    </script>
@endsection
