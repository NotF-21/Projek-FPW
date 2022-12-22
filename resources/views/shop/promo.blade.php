@extends('layout.shop')

@section('title', 'Master Promo')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Universal Promos</h4>
                <p class="category">Here you can see all of universally available promos</p>
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Expiration Date</th>
                    </thead>
                    <tbody>
                        @foreach ($pg as $key=>$p)
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Your Promos</h4>
                <p class="category">Here you can see all of your registered promos, both active and inactive</p>
                @if (Session::has('Message'))
                    <label for="" class="text-success">{{Session::get('Message')}}</label>
                @endif
                @if (Session::has('scsdel'))
                    <label for="" class="text-danger">{{Session::get('scsdel')}}</label>
                @endif
                @if (Session::has('scsact'))
                    <label for="" class="text-success">{{Session::get('scsact')}}</label>
                @endif
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped" id="table-promo">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($ps as $key=>$p)
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
                                <td>{{date('F j, Y',strtotime($p->promo_expiredate))}}</td>
                                <td>
                                    @if ($p->promo_status==1)
                                        ACTIVE
                                    @else
                                        NON-ACTIVE
                                    @endif
                                </td>
                                <td>
                                    @if ($p->promo_status==1)
                                        <a href="{{url("shop/promo/delete/$p->promo_id")}}" class="btn btn-danger">Deactivate</a>
                                    @else
                                        <a href="{{url("shop/promo/delete/$p->promo_id")}}" class="btn btn-success">Activate</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Make a Promo</h4>
                <p class="category">Here you can make a promo applied to your shop.</p>
                @if (Session::has('Success'))
                    <p class="text-success">{{Session::get('Success')}}</p>
                @endif
            </div>
            <div>
                <input type="hidden" name="_token" value="{{Session::token()}}" id="csrf">
                <div class="row-p-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Promo Name</label>
                            <input type="text" class="form-control" placeholder="Promo Name" id="namep" name="name" value="{{old('name', '')}}">
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
                            <select name="type" id="typep" class="form-control">
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
                            <input type="text" class="form-control" placeholder="Promo Amount" name="amount" id="amountp" value="{{old('amount', '')}}">
                            @error('amount')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Promo Expiration Date</label>
                            <input type="date" class="form-control" placeholder="Promo Expiration Date" name="date" id="datep" value="{{old('date', '')}}">
                            @error('date')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-info btn-fill pull-right" id="btnCreateP">Create Promo</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#btnCreateP').on("click", function () {
            var name = $("#namep").val();
            var amount = $("#amountp").val();
            var type = $("#typep").val();
            var date = $("#datep").val();

            $.ajax({
                type: "POST",
                url: "/shop/promo/add",
                data: {
                    _token : $("#csrf").val(),
                    type : type,
                    name : name,
                    amount : amount,
                    date : date
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.statusCode==200) {
                        var p = res.new;
                        var num = res.num;
                        var type = res.type["promo_type_name"];
                        var date = res.date;
                        var n = "";
                        var status = "";
                        var btn = "";

                        var url = res.url;

                        if (type=="Potongan") {
                            n ="Rp" + p["promo_amount"].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                        } else {
                            n = (p["promo_amount"].toString()) + "%";
                        }

                        if (p["promo_status"]==1) status = "ACTIVE";
                        else status = "NON-ACTIVE";

                        if (p["promo_status"]==1) btn = "<a href='" + url +"' class='btn btn-danger'>Deactivate</a>";
                        else btn = "<a href='" + url + "' class='btn btn-success'>Activate</a>";

                        // console.log(res.new);
                        $("#table-promo tbody").append("<tr> <td>" + num + "</td><td>" + p["promo_name"] + "</td><td>" + type +"</td><td>"+n+"</td><td>"+date+"</td><td>"+status+"</td><td>"+btn+"</td></tr>");
                    } else {
                        alert("Error inserting new promo !");
                    }
                }
            });
        });
    });
</script>
@endsection
