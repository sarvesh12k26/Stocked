<?php use App\User;?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{asset('js1/Chart.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Styles -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css1/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css1/bootstrap-reset.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
      <!--right slidebar-->
      <link href="{{asset('css1/slidebars.css')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('css1/style.css')}}" rel="stylesheet">
    <link href="{{asset('css1/style-responsive.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-datetimepicker/css/datetimepicker.css')}}" />
    <script src="{{asset('js1/jquery.js')}}"></script>
    <link href="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{asset('css1/owl.carousel.css')}}" type="text/css">
    <link href="{{asset('css1/style.css')}}" rel="stylesheet">
    <link href="{{asset('css1/style-responsive.css')}}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
    <div id="app">
        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <i class="fa fa-bars"></i>
                </div>
                <!--logo start-->
                <a href="index.html" class="logo" >Stock<span>ed</span></a>
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                </div>
                <div class="top-nav ">
                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="{{asset('img/avatar1_small.jpg')}}">
                            <span class="username">{{(User::find(Auth::id()))->name}}</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                                <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-key"></i> Log Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>

                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="http://localhost:8080/codes_r1/public/home">
                                <i class="fa fa-dashboard"></i>
                                <span>Stock PortFolio</span>
                            </a>
                        </li>
      
                        <li class="sub-menu">
                            <a href="http://localhost:8080/codes_r1/public/stock_buy">
                                <i class="fa fa-laptop"></i>
                                <span>Add Stocks</span>
                            </a>
                        </li>

                        <li>
                            <a href="http://localhost:8080/codes_r1/public/forex_home">
                                <i class="fa fa-dashboard"></i>
                                <span>Forex PortFolio</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="http://localhost:8080/codes_r1/public/forex_buy">
                                <i class="fa fa-laptop"></i>
                                <span>Add Forex Trades</span>
                            </a>
                        </li>

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper site-min-height">
                <main class="py-4">
                    @yield('content')
                </main>
                </section>
            </section>
            <!--main content end-->
            <!-- Right Slidebar start -->
            
            <!-- Right Slidebar end -->
            <!--footer start-->
            <!--footer end-->
        </section>
        
    </div>

        <script src="{{asset('js1/jquery.js')}}"></script>
        <script src="{{asset('js1/bootstrap.min.js')}}"></script>
        <script class="include" type="text/javascript" src="{{asset('js1/jquery.dcjqaccordion.2.7.js')}}"></script>
        <script src="{{asset('js1/jquery.scrollTo.min.js')}}"></script>
        <script src="{{asset('js1/jquery.nicescroll.js')}}" type="text/javascript"></script>
        <script src="{{asset('js1/respond.min.js')}}" ></script>
        <script src="{{asset('js1/jquery.sparkline.js')}}" type="text/javascript"></script>


        <!--right slidebar-->
        <script src="{{asset('js1/slidebars.min.js')}}"></script>

        <!--common script for all pages-->
        <script src="{{asset('js1/common-scripts.js')}}"></script>

        <script src="{{asset('js1/sparkline-chart.js')}}"></script>
        <script src="{{asset('js1/easy-pie-chart.js')}}"></script>
        <script src="{{asset('js1/count.js')}}"></script>
        <script src="{{asset('js1/owl.carousel.js')}}" ></script>
        <script src="{{asset('js1/jquery.customSelect.min.js')}}" ></script>
        <script src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
        <script src="{{asset('js1/jquery-ui-1.9.2.custom.min.js')}}"></script>
        <script src="{{asset('js1/jquery-migrate-1.2.1.min.js')}}"></script>


  
    <!--this page plugins-->

        <script type="text/javascript" src="{{asset('assets/fuelux/js/spinner.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-daterangepicker/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/jquery-multi-select/js/jquery.quicksearch.js')}}"></script>

  <!--select2-->
        <script type="text/javascript" src="{{asset('assets/select2/js/select2.min.js')}}"></script>

        <!--summernote-->
        <script src="{{asset('assets/summernote/dist/summernote.min.js')}}"></script>

        <!--right slidebar-->


        <!--this page  script only-->
        <script src="{{asset('js1/advanced-form-components.js')}}"></script>

        <!--bootstrap-switch-->
        <script src="{{asset('assets/bootstrap-switch/static/js/bootstrap-switch.js')}}"></script>

        <!--bootstrap-switch-->
        <script src="{{asset('assets/switchery/switchery.js')}}"></script>

        <!--common script for all pages-->
        <script>

                //owl carousel
          
                $(document).ready(function() {
                    $("#owl-demo").owlCarousel({
                        navigation : true,
                        slideSpeed : 300,
                        paginationSpeed : 400,
                        singleItem : true,
                        autoPlay:true
          
                    });
                });
          
                //custom select box
          
                $(function(){
                    $('select.styled').customSelect();
                });
          
                $(window).on("resize",function(){
                    var owl = $("#owl-demo").data("owlCarousel");
                    owl.reinit();
                });
          
            </script>

        <script>

            jQuery(document).ready(function(){

                $('.summernote').summernote({
                    height: 200,                 // set editor height

                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor

                    focus: true                 // set focus to editable area after initializing summernote
                });
            });

        </script>

            <!--select2-->
        <script type="text/javascript">

            $(document).ready(function () {
                $(".js-example-basic-single").select2();

                $(".js-example-basic-multiple").select2();
            });
        </script>

        <!--bootstrap swither-->
        <script type="text/javascript">
            $(document).ready(function () {
                // Resets to the regular style
                $('#dimension-switch').bootstrapSwitch('setSizeClass', '');
                // Sets a mini switch
                $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-mini');
                // Sets a small switch
                $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-small');
                // Sets a large switch
                $('#dimension-switch').bootstrapSwitch('setSizeClass', 'switch-large');


                $('#change-color-switch').bootstrapSwitch('setOnClass', 'success');
                $('#change-color-switch').bootstrapSwitch('setOffClass', 'danger');
            });
        </script>

        <!-- swithery-->
        <script type="text/javascript">
            $(document).ready(function () {
                //default
                var elem = document.querySelector('.js-switch');
                var init = new Switchery(elem);


                //small
                var elem = document.querySelector('.js-switch-small');
                var switchery = new Switchery(elem, { size: 'small' });

                //large
                var elem = document.querySelector('.js-switch-large');
                var switchery = new Switchery(elem, { size: 'large' });


                //blue color
                var elem = document.querySelector('.js-switch-blue');
                var switchery = new Switchery(elem, { color: '#7c8bc7', jackColor: '#9decff' });

                //green color
                var elem = document.querySelector('.js-switch-yellow');
                var switchery = new Switchery(elem, { color: '#FFA400', jackColor: '#ffffff' });

                //red color
                var elem = document.querySelector('.js-switch-red');
                var switchery = new Switchery(elem, { color: '#ff6c60', jackColor: '#ffffff' });


            });
        </script>
</body>
</html>
