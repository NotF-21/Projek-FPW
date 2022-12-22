@extends('layout.admin')

@section('title', 'Master Shop')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Shops</h4>
                <p class="category">Here you can see all of our registered shops, you may make them inactive according to their status</p>
                @if (Session::has('scsact'))
                    <label for="" class="text-success">{{Session::get('scsact')}}</label>
                @elseif (Session::has('scsdact'))
                    <label for="" class="text-danger">{{Session::get('scsdact')}}</label>
                @endif
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Alamat Email</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($list as $key=>$shop)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$shop->shop_name}}</td>
                                <td>{{$shop->shop_username}}</td>
                                <td>{{$shop->shop_address}}</td>
                                <td>{{$shop->shop_emailaddress}}</td>
                                <td>{{$shop->shop_phonenumber}}</td>
                                <td>
                                    @if ($shop->shop_status==1)
                                        <a href="/admin/shop/deactivate/{{$shop->id}}" class="btn btn-danger btn-fill">Deaktivasi</a>
                                    @else
                                        <a href="/admin/shop/activate/{{$shop->id}}" class="btn btn-success btn-fill">Aktivasi</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="category">Here you can download all of the data into an Excel spreadsheet</p>
                <a href="/admin/shop/download" class="btn btn-success btn-fill">Download</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Shops in Waiting List</h4>
                <p class="category">Here you can see all of currently waiting shops. You may either accept or reject them.</p>
                @if (Session::has('scsacpt'))
                    <label for="" class="text-success">{{Session::get('scsacpt')}}</label>
                @elseif (Session::has('scsrjt'))
                    <label for="" class="text-danger">{{Session::get('scsrjt')}}</label>
                @endif
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Key</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($waitinglist as $key=>$shop)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$shop->shop_name}}</td>
                                <td>{{$shop->shop_username}}</td>
                                <td>
                                    <a href="/admin/shop/accept/{{$shop->id}}" class="btn btn-success btn-fill">Terima</a>
                                    <a href="/admin/shop/reject/{{$shop->id}}" class="btn btn-danger btn-fill">Tolak</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
