<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="/css/app.css">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Freelance Hero
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">
                    @if (!Auth::guest())
                        <li {{ (preg_match( '/HomeController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/home') }}">Dashboard</a></li>
                        <li {{ (preg_match( '/OrganizationsController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/organizations') }}">Organizations</a></li>
                        <li {{ (preg_match( '/ProjectsController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/projects') }}">Projects</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li {{ (preg_match( '/UsersController/', Route::getCurrentRoute()->getActionName())) ? 'class=active dropdown' : 'class=dropdown' }} >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if( Session::has('flash_error_message') )
        <div class="alert alert-danger">{{ Session::get('flash_error_message') }}</div>
    @endif

    @yield('content')


    @if ( Session::has('active_work_session') )
        <?php
            $current = new DateTime(date('Y-m-d h:i:s'));
            $start = new DateTime(Session::get('work_session_start_time'));
            $interval = date_diff($current, $start);
            $counter = sprintf('%02d', $interval->days * 24 + $interval->h) . $interval->format(':%I:%S');
        ?>
        <div id="work-session-panel">
            <div class="panel-body text-center">
                <p class="lead">Session Time</p>
                <h4 id="counter">{{ $counter }}</h4>
                <p>&nbsp;</p>
                {!! Form::open(array('action' => 'WorkSessionsController@end', 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    {!! Form::submit('End Session', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @endif

    <!-- JavaScripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
