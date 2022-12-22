@extends('layout.admin')

@section('title', 'Master User')

@section('message', 'Welcome back, admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Customers</h4>
                <p class="category">Here you can see all of our registered customers</p>
                @if (Session::has('scsact'))
                    <label for="" class="text-success">{{Session::get('scsact')}}</label>
                @elseif (Session::has('scsdact'))
                    <label for="" class="text-danger">{{Session::get('scsdact')}}</label>
                @endif
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Key</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($list as $key=>$cust)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$cust->customer_name}}</td>
                                <td>{{$cust->customer_username}}</td>
                                <td>{{$cust->customer_address}}</td>
                                <td>{{$cust->customer_phonenumber}}</td>
                                <td>
                                    @if ($cust->customer_status==1)
                                        <a href="/admin/home/deactivate/{{$cust->id}}" class="btn btn-danger btn-fill">Deactivate</a>
                                    @else
                                        <a href="/admin/home/activate/{{$cust->id}}" class="btn btn-success btn-fill">Activate</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="category">Here you can download all of the data into an Excel spreadsheet</p>
                <a href="/admin/home/download" class="btn btn-success btn-fill">Download</a>
            </div>
        </div>
    </div>
</div>
@endsection
