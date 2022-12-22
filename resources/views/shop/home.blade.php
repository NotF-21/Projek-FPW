@extends('layout.shop')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">List of Products</h4>
                <p class="category">Here you can see all of our registered products, both active and inactive</p>
                @if (Session::has('Message'))
                    <label for="" class="text-success">{{Session::get('Message')}}</label>
                @endif
                @if (Session::has('scsaddp'))
                    <label for="" class="text-success">{{Session::get('scsaddp')}}</label>
                @endif
                @if (Session::has('scsupl'))
                    <label for="" class="text-success">{{Session::get('scsupl')}}</label>
                @endif
                @if (Session::has('scse'))
                    <label for="" class="text-success">{{Session::get('scse')}}</label>
                @endif
                @error('namee')
                    <label for="" class="text-danger">{{$message}}</label>
                @enderror
                @error('desce')
                    <label for="" class="text-danger">{{$message}}</label>
                @enderror
                @error('pricee')
                    <label for="" class="text-danger">{{$message}}</label>
                @enderror
            </div>
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Key</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Stock</th>
                        <th>Product Description</th>
                        <th>Product Type</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($product as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->product_name}}</td>
                                <td>{{$item->product_price}}</td>
                                <td>{{$item->product_stock}}</td>
                                <td>{{$item->product_desc}}</td>
                                <td>{{$item->type->Type_Name}}</td>
                                <td>
                                    <button value="{{$item->product_id}}" @if ($item->deleted_at!=null)
                                        disabled
                                    @endif class="btn btn-warning btn-fill btnEdit">Edit Product</button>
                                    @if ($item->deleted_at==null)
                                        <a href="{{url("shop/product/delete/$item->product_id")}}" class="btn btn-danger btn-fill">Delete</a>
                                    @else
                                        <a href="{{url("shop/product/delete/$item->product_id")}}" class="btn btn-success btn-fill">Recover</a>
                                    @endif
                                    <button value="{{$item->product_id}}" @if ($item->deleted_at!=null)
                                        disabled
                                    @endif class="btn btn-primary btn-fill btnUpload">Upload Image</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="category">Here you can download all of the data into an Excel spreadsheet</p>
                <a href="/shop/product/download" class="btn btn-success btn-fill">Download</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Product Adding Form</h4>
                <p class="category">Here you can add a new product to sell in your shop</p>
                @if (Session::has('Message'))
                    <label for="" class="text-success">{{Session::get('Message')}}</label>
                @endif
            </div>
            <div>
                <form action="{{url("/shop/product/make")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" placeholder="Product Name" name="namep" value="{{old('namep', '')}}">
                                @error('namep')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Description</label>
                                <input type="textarea" class="form-control" placeholder="Product Description" name="descp" value="{{old('descp', '')}}">
                                @error('descp')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product Type</label>
                                <select name="typep" id="" class="form-control">
                                    @foreach ($type as $t)
                                        <option value={{$t->id}}>{{$t->Type_Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" class="form-control" placeholder="Product Price" name="pricep" value="{{old('pricep', '')}}">
                                @error('pricep')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product Stock</label>
                                <input type="text" class="form-control" placeholder="Product Stock" name="stockp" value="{{old('stockp', '')}}">
                                @error('stockp')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product Image</label>
                                <input type="file" class="form-control" placeholder="Product Image" name="imagep" value="{{old('imagep', '')}}">
                                @error('imagep')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info btn-fill pull-right">Create Product</button>
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
                <h4 class="title">Product Restocking Form</h4>
                <p class="category">Here you restock your product in your shop</p>
                @if (Session::has('scsr'))
                    <label for="" class="text-success">{{Session::get('scsr')}}</label>
                @endif
            </div>
            <div>
                <form action="/shop/product/restock" method="POST">
                    @csrf
                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product</label>
                                <select name="productr" id="" class="form-control">
                                    @foreach ($product as $p)
                                        <option value="{{$p->product_id}}">{{$p->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row-p-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Restock Number</label>
                                <input type="text" class="form-control" placeholder="Restock Number" name="restn" value="{{old('restn', '')}}">
                                @error('restn')
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-fill pull-right">Restock Product</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal" tabindex="-1" id="modalUpload">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload File</h5>
        </div>
        <div class="modal-body">
            <p>Upload your image here</p>
            <form action='{{url('shop/product/upload')}}' method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="idUploadProduct">
                <div class="col-6">
                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" class="form-control" placeholder="Product Image" name="uploadp" value="{{old('uploadp', '')}}">
                        @error('uploadp')
                            <label for="" class="text-danger">{{$message}}</label>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn-primary btn btn-fill">Upload</button>
            </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" id="modalEdit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product</h5>
        </div>
        <div class="modal-body p-5">
            <form action='{{url('shop/product/edit')}}' method="post">
                @csrf
                <input type="hidden" name="ide" id="idEditProduct">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" id="nameEdit" class="form-control" placeholder="Product Name" name="namee">
                </div>
                <div class="form-group">
                    <label>Product Description</label>
                    <input type="text" id="descEdit" class="form-control" placeholder="Product Description" name="desce">
                </div>
                <div class="form-group">
                    <label>Product Price</label>
                    <input type="text" id="priceEdit" class="form-control" placeholder="Product Price" name="pricee">
                </div>
                <button type="submit" class="btn-primary btn btn-fill">Edit Product</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
        $(".btnUpload").on('click', function (e) {
            document.getElementById("idUploadProduct").value = e.target.value;
            $("#modalUpload").modal("show");
        });

        $(".btnEdit").on('click', function (e) {
            document.getElementById('idEditProduct').value = e.target.value;

            $("#modalEdit").modal('show');
        });
    </script>
@endsection
