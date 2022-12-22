@extends('layout.customer')
@section('title', $shop->shop_name)

@section('content')
    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-4">
                    <span class="font-weight-bold" style="font-size: 24pt">Filter Produk</span>
                </div>
            </div>
            <div class="col-12">
                <form action="/customer/toko={{$shop->shop_name}}/cari" method="get">
                    <div class="row mt-3 px-3">
                        <div class="col-md-12">
                            <input type="text" name="produk" class="form-control" placeholder="Nama Produk" value="{{old('nama', '')}}">
                            @error('nama')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3 px-3">
                        <div class="col-md-6">
                            <input type="text" name="min" class="form-control" placeholder="Minimum Harga">
                            @error('min')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="max" class="form-control" placeholder="Maksimum Harga">
                            @error('max')
                                <label for="" class="text-danger">{{$message}}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3 px-3">
                        <div class="col-md-6">
                            <select name="category" id="" class="form-control">
                                @foreach ($kategori as $k)
                                    <option value="{{$k->Type_Name}}">{{$k->Type_Name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="stok" id="" class="form-control">
                                <option value="">---</option>
                                <option value="all">Semua Produk</option>
                                <option value="available">Hanya yang Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3 mb-3 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (Session::has('scscart'))
        <label for="" class="text-success">{{Session::get('scscart')}}</label>
    @endif

    @foreach ($list->chunk(3) as $i=>$chunk)
        <div class="row mt-2 px-2">
            @foreach ($chunk as $j=>$p)
                <div class="card p-3 bg-white mx-4">
                    <div class="about-product text-center mt-2 mb-2"><img src="{{asset("storage/imgProduct/product_$p->product_id")}}" width="300">
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
                        <div class="col-md-2">
                            @if ($fav[$i][$j]=="yes")
                                <div id="star_{{$p->product_id}}" class="star" tag="{{$p->product_id}}" token="{{Session::token()}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                </div>
                            @else
                                <div id="star_{{$p->product_id}}" class="star" tag="{{$p->product_id}}" token="{{Session::token()}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <form action="/customer/cart/add/{{$p->product_id}}" method="post">
                                @csrf
                                <input type="text" class="form-control mb-2" name="number" id="inlineFormInputName2" placeholder="Jumlah">
                                @error("number")
                                    <label for="" class="text-danger">{{$message}}</label>
                                @enderror
                                <button type="submit" class="btn btn-primary mb-2">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="card rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <span class="font-weight-bold" style="font-size: 24pt">Daftar Review</span>
                </div>
            </div>
            @foreach ($shop->reviews as $review)
                <div class="col-12 mb-3">
                    <div class="card ml-2" style="width: 90%;">
                        <div class="card-body">
                            <h5 class="card-title">{{$review->customer->customer_name}}</h5>
                            <p>@for ($i=0; $i<$review->review_rating; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            @endfor
                            </p>
                            <p>{{$review->review_review}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (count($cart))
        <div class="fixed" style="position: fixed; bottom: 0; width:100%; display:flex; justify-content:center;">
            <a href="{{url("customer/keranjang")}}" class="btn btn-success"><h5>Keranjang {{count($cart)}}</h5></a>
        </div>
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.star').on('click', function(){
                var id = $(this).attr('tag');
                var token = $(this).attr('token');

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('customer/favorit/add')}}",
                    data: {
                        _token : "{{ csrf_token() }}",
                        id : id,
                    },
                    success: function (response) {
                        var res = JSON.parse(response);
                        var ids = "star_"+id;

                        if (res.act=="del") {
                            document.getElementById(ids).innerHTML = "<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>";
                        } else if (res.act=="add") {
                            document.getElementById(ids).innerHTML = "<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-star-fill' viewBox='0 0 16 16'><path d='M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z'/></svg>";
                        }
                    },
                    error:function(xhr, status, error){
                        alert(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
