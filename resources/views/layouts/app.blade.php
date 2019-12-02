<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'What the hack') }}</title>

    <!-- Scripts
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Original laravel scripts
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

    <!-- MDB Scripts -->
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="{{ URL::asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="{{ URL::asset('js/mdb.min.js') }}"></script>
    <!-- Template JavaScript-->
    <script type="text/javascript" src ="{{ URL::asset('js/freelancer.min.js') }}"></script>
    <!-- DataTables addon -->
    <script type="text/javascript" src="{{ URL::asset('js/addons/datatables.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ URL::asset('js/addons/datatables-select.min.js') }}"></script> -->
    <script src="{{ asset('js/actions.js') }}"></script>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <!-- Template CSS file -->
    <link rel="stylesheet" href="{{ URL::asset('css/freelancer.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/addons/datatables.min.css') }}">
    <!-- CSS file for customization -->
    <link rel="stylesheet" href="{{ URL::asset('css/custom-styles.css') }}">
    <!-- <link rel="stylesheet" href="{{ URL::asset('css/addons/datatables-select.min.css') }}"> -->


</head>
<body>

    <div id="content">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="navbar-toggle">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                            <i class="fas fa-align-left"></i>
                            <span class="navbar-toggler-icon"></span>
                        </button>

                    </div>
                </nav>
            </div>
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'What the hack') }}
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <!--
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user())
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

        </main>
    </div>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">

            <div id="dismiss">
                <i class="fas fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <h4>WhatTheHack</h4>
            </div>

            <ul class="list-unstyled components">
                <!-- ACCOUNT -->
                <li>
                    <a href="#accountSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        @if (Auth::user())
                            {{ Auth::user()->username }} <span class="caret"></span>
                        @else
                            Account
                        @endif
                    </a>
                    <ul class="collapse list-unstyled" id="accountSubmenu">
                        <li>
                            @if (Auth::user())
                                <a href="{{ route('profile.show') }}">Profile</a>
                        <li>
                            <a  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                    </ul>
                </li>

                <!-- ADMIN VIEW -->
                @if (Auth::user())
                    @if(Auth::user()->hasRole("admin"))
                        <li>
                            <a href="#challengeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Challenges</a>
                            <ul class="collapse list-unstyled" id="challengeSubmenu">
                                <li>
                                    <a href="/challenges">Show Challenges</a>
                                </li>
                                <li>
                                    <a href="challenges/create">Create Challenge</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#classroomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Classroom</a>
                            <ul class="collapse list-unstyled" id="classroomSubmenu">
                                <li>
                                    <a href="/classroom">Show Classroom</a>
                                </li>
                                <li>
                                    <a href="classroom/create">Create Classroom</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/manage/users">User Management</a>
                        </li>
                        @else
                        <li>
                            <a href="/challenges">Challenges</a>
                        </li>
                    @endif
                @endif

                <li>
                    <a href="#aboutSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">About</a>
                    <ul class="collapse list-unstyled" id="aboutSubmenu">
                        <li>
                            <a href="/contact">Contact</a>
                        </li>
                        <li>
                            <a href="/agb">Terms of use</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>


    </div>
 @yield('content')

    @if($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif

</body>
</html>
