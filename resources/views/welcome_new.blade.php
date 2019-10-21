@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">

            <ul class="list-unstyled components">

                <li>
                    <a href="#">Demopage 1</a>
                </li>
                <li>
                    <a href="#">Demopage 2</a>
                </li>
                <li>
                    <a href="#">Demopage 3</a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">About</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            <a href="#">Terms of use</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
        <!-- Page Content -->
        <div id="content">

            <!--<nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>
            </nav>
            -->
        </div>
        <div class="card">
            <div class="card-header">{{ __('Information') }}</div>

            <div class="card-body">
                This is a Demotext!
            </div>
        </div>
    </div>
@endsection
