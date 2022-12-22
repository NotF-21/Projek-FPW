@extends('layout.admin')

@section('title', 'Master Promo')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Daftar Promo Penjual</h4>
                <p class="category">Di sini Anda bisa melihat daftar seluruh promo yang dibuat penjual</p>
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tipe Promo</th>
                        <th>Besar Promo</th>
                        <th>Toko Penjual</th>
                        <th>Tanggal Ekspirasi</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($promo as $key=>$p)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$p->promo_name}}</td>
                                <td>{{$p->type->promo_type_name}}</td>
                                <td>
                                    @if ($p->type->promo_type_name=="Potongan")
                                        Rp{{number_format($p->promo_amount,0,',','.')}}
                                    @else
                                        {{$p->promo_amount}}%
                                    @endif
                                </td>
                                <td>
                                    {{$p->shop->shop_name}}
                                </td>
                                <td>{{date('F j, Y',strtotime($p->promo_expiredate))}}</td>
                                <td>
                                    @if ($p->promo_status==1)
                                        AKTIF
                                    @else
                                        NONAKTIF
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="header">
                <p class="category">Di sini Anda bisa melihat daftar seluruh promo yang berlaku di semua toko penjual. Anda bisa melakukan aktivasi atau deaktivasi promo.</p>
                @if (Session::has('scsdpact'))
                    <label for="" class="text-success">{{Session::get('scsdpact')}}</label>
                @endif
                @if (Session::has('scspact'))
                    <label for="" class="text-success">{{Session::get('scspact')}}</label>
                @endif
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tipe Promo</th>
                        <th>Jumlah</th>
                        <th>Tanggal Ekspirasi</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($promoGlobal as $key=>$p)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$p->promo_global_name}}</td>
                                <td>{{$p->type->promo_type_name}}</td>
                                <td>
                                    @if ($p->type->promo_type_name=="Potongan")
                                        Rp{{number_format($p->promo_global_amount,0,',','.')}}
                                    @else
                                        {{$p->promo_global_amount}}%
                                    @endif
                                </td>
                                <td>{{date('F j, Y',strtotime($p->promo_global_expiredate))}}</td>
                                <td>
                                    @if ($p->promo_global_status==1)
                                        AKTIF <br>
                                        <a href="{{url('admin/promo/deactivate/'. $p->promo_global_id)}}" class="btn btn-danger btn-fill">DEAKTIVASI</a>
                                    @else
                                        NONAKTIF <br>
                                        <a href="{{url('admin/promo/activate/'. $p->promo_global_id)}}" class="btn btn-success btn-fill">AKTIVASI</a>
                                    @endif
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
                <h4 class="title">Buat Promo</h4>
                <p class="category">Di sini Anda bisa membuat promo yang akan berlaku untuk semua toko di dalam aplikasi</p>
                @if (Session::has('Success'))
                    <p class="text-success">{{Session::get('Success')}}</p>
                @endif
            </div>
            <div>
                <form action="" method="POST">
                    @csrf
                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Promo</label>
                                <input type="text" class="form-control" placeholder="Nama Promo" name="name" value="{{old('name', '')}}">
                                @error('name')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Promo Type</label>
                                <select name="type" id="" class="form-control">
                                    @foreach ($type as $t)
                                        <option value="{{$t->promo_type_id}}">{{$t->promo_type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Promo Amount</label>
                                <input type="text" class="form-control" placeholder="Promo Amount" name="amount" value="{{old('amount', '')}}">
                                @error('amount')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Promo Expiration Date</label>
                                <input type="date" class="form-control" placeholder="Promo Expiration Date" name="date" value="{{old('date', '')}}">
                                @error('date')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info btn-fill pull-right">Create Promo</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Vouchers</h4>
                <p class="category">Here you can see all of our vouchers, you may make them inactive according to their status</p>
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $key=>$v)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$v->voucher_name}}</td>
                                <td>{{$v->type->promo_type_name}}</td>
                                <td>
                                    @if ($v->type->promo_type_name=="Potongan")
                                        Rp{{number_format($v->voucher_amount,0,',','.')}}
                                    @else
                                        {{$v->voucher_amount}}%
                                    @endif
                                </td>
                                <td>{{date('F j, Y',strtotime($v->voucher_expiredate))}}</td>
                                <td>
                                    @if ($v->voucher_status==1)
                                        ACTIVE <br>
                                        <a href="{{url('admin/voucher/deactivate')}}" class="btn btn-danger">DEACTIVATE</a>
                                    @else
                                        NON-ACTIVE <br>
                                        <a href="{{url('admin/voucher/activate')}}" class="btn btn-success">ACTIVATE</a>
                                    @endif
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
                <h4 class="title">Make a Voucher</h4>
                <p class="category">Here you can make a voucher for the customers</p>
                @if (Session::has('Successv'))
                    <p class="text-success">{{Session::get('Successv')}}</p>
                @endif
            </div>
            <div>
                <form action="/admin/voucher/make" method="POST">
                    @csrf
                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Voucher Name</label>
                                <input type="text" class="form-control" placeholder="Voucher Name" name="namev" value="{{old('namev', '')}}">
                                @error('namev')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Voucher Type</label>
                                <select name="typev" id="" class="form-control">
                                    @foreach ($type as $t)
                                        <option value="{{$t->promo_type_id}}">{{$t->promo_type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Voucher Amount</label>
                                <input type="text" class="form-control" placeholder="Promo Amount" name="amountv" value="{{old('amountv', '')}}">
                                @error('amountv')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Voucher Expiration Date</label>
                                <input type="date" class="form-control" placeholder="Promo Expiration Date" name="datev" value="{{old('datev', '')}}">
                                @error('datev')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info btn-fill pull-right">Create Voucher</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Give Vouchers</h4>
                <p class="category">Here you can give a voucher to the customers</p>
                @if (Session::has('Successvg'))
                    <p class="text-success">{{Session::get('Successvg')}}</p>
                @endif
            </div>
            <div>
                <form action="/admin/voucher/give" method="POST">
                    @csrf
                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vouchers</label>
                                <select name="voucher" id="" class="form-control">
                                    @foreach ($voucher as $v)
                                        <option value="{{$v->voucher_id}}">{{$v->voucher_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customers to Give</label>
                                <select name="customer" id="customerSelect" class="form-control" onchange="showDiv('numberInput', this)">
                                    <option value="all">All Customers</option>
                                    <option value="topbuy">Customer with Most Transactions</option>
                                    <option value="random">Random Customers</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Numbers of Vouchers to Give</label>
                                <input type="number" class="form-control" placeholder="Number of voucher(s) to give" name="vnumber" value="{{old('number', 1)}}" min="1">
                                @error('vnumber')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4" id="numberInput" style="display:none;">
                            <div class="form-group">
                                <label>Number of Customers to Give Vouchers to</label>
                                <input type="number" class="form-control" placeholder="Number of customers to give" name="number" max="{{$sumCust}}" value="{{old('number', '')}}" min="1">
                                @error('number')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <button type="submit" class="btn btn-info btn-fill pull-right">Give Voucher</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDiv(divId, element) {
        document.getElementById(divId).style.display = element.value == "all" ? 'none' : 'block';
    }
</script>
@endsection
