<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>@yield('title')</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{asset('css/admin/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{asset('css/admin/animate.min.css')}}" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{asset('css/admin/light-bootstrap-dashboard.css')}}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{asset('css/admin/pe-icon-7-stroke.css')}}" rel="stylesheet" />

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    @yield('css')
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    Welcome, {{Auth::user()->shop_username}}
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="{{url('shop/home')}}">
                        <i class="pe-7s-user"></i>
                        <p>Master Product</p>
                    </a>
                </li>
                <li>
                    <a href="{{url('shop/promo')}}">
                        <i class="pe-7s-id"></i>
                        <p>Master Promo</p>
                    </a>
                </li>
                <li>
                    <a href="{{url('shop/chatroom')}}">
                        <i class="pe-7s-cart"></i>
                        <p>Chat Room</p>
                    </a>
                </li>
                <li>
                    <a href="{{url('shop/transaction')}}">
                        <i class="pe-7s-note2"></i>
                        <p>Daftar Transaksi</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">@yield('title')</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{url('shop/logout')}}">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>

@yield('modal')

</body>

    <!--   Core JS Files   -->
    <script src="{{asset('css/admin/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('css/admin/bootstrap.min.js')}}" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="{{asset('css/admin/chartist.min.js')}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{asset('css/admin/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{{asset('css/admin/light-bootstrap-dashboard.js')}}"></script>

    <script src="{{asset('css/admin/demo.js')}}"></script>

	@yield('script')

</html>
