<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('css/customer/font/style.css')}}">

        <link rel="stylesheet" href="{{asset('css/customer/owl.carousel.min.css')}}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('css/customer/bootstrap.min.css')}}">

        <!-- Style -->
        <link rel="stylesheet" href="{{asset('css/customer/style.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
        <link href="{{asset('css/admin/pe-icon-7-stroke.css')}}" rel="stylesheet" />

        <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-ZVGz1Svr2HbeewF7"></script>

        @yield('css')

        <title>@yield('title')</title>
    </head>
    <body>
        <header class="site-navbar js-sticky-header site-navbar-target" role="banner">
            <div class="container-fluid">
                <div class="row align-items-center position-relative">
                        <div class="site-logo">
                            <a href="{{url('customer/home')}}" class="text-black"><span class="text-primary">Dodol Roti</a>
                        </div>
                    <div class="col-12">
                        <nav class="site-navigation text-right ml-auto " role="navigation">
                            <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
                                <li><a href="{{url('customer/home')}}" class="nav-link">Home</a></li>
                                <li><a href="{{url('customer/promo')}}" class="nav-link">Promo</a></li>
                                <li><a href="{{url('customer/keranjang')}}" class="nav-link">Keranjang</a></li>
                                <li><a href="{{url('customer/chatroom')}}" class="nav-link">Chatroom</a></li>
                                <li><a href="{{url('customer/wishlist')}}" class="nav-link">Wishlist</a></li>
                                <li><a href="{{url('customer/transaksi')}}" class="nav-link">Transaksi</a></li>
                                <li><a href="{{url('customer/profile')}}" class="nav-link">Profile</a></li>
                                <li><a href="{{url('customer/logout')}}" class="nav-link text-danger">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
                </div>
            </div>
        </header>

        <div class="container">
            @yield('content')
        </div>

        @yield('modal')

        <script src="{{asset('css/admin/jquery.3.2.1.min.js')}}"></script>
        <script src="{{asset('css/customer/popper.min.js')}}"></script>
        <script src="{{asset('css/admin/bootstrap.min.js')}}"></script>
        <script src="{{asset('css/customer/jquery.sticky.js')}}"></script>
        <script src="{{asset('css/customer/main.js')}}"></script>

        @yield('script')
    </body>
</html>
