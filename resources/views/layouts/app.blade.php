<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Freelance Hero</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- favicon - hero face by Ariel Kotzer from the Noun Project -->
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="/favicon/favicon-192.png">
    <link rel="icon" type="image/png" sizes="160x160" href="/favicon/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16.png">
    <link rel="apple-touch-icon" href="/favicon/favicon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/favicon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/favicon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/favicon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/favicon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/favicon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/favicon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/favicon-180.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/favicon/favicon-144.png">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <!-- ****** faviconit.com favicons ****** -->

    <!-- Styles -->
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="/css/app.css">
    @if( App::environment('local') )
        <link rel="stylesheet" href="/css/local.css">
    @endif

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
                @if (!Auth::guest())
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Freelance Hero
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    Freelance Hero
                </a>
                @endif
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">
                    @if (!Auth::guest())
                        <li {{ (preg_match( '/HomeController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/home') }}">Dashboard</a></li>
                        <li {{ (preg_match( '/OrganizationsController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/organizations') }}">Organizations</a></li>
                        <li {{ (preg_match( '/ProjectsController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/projects') }}">Projects</a></li>
                        @if (Auth::user()->isAdmin())
                            <li {{ (preg_match( '/AdminController/', Route::getCurrentRoute()->getActionName())) ? 'class=active' : null }} ><a href="{{ url('/admin') }}">Admin</a></li>
                        @endif
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
