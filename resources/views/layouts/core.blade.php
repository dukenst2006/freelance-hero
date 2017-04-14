<!DOCTYPE html>
<html>
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
        <link rel="stylesheet" href="/css/bulma.css">
        <link rel="stylesheet" href="/css/app.css">
        @if(! App::environment('production') )
            <!-- <link rel="stylesheet" href="/css/{{ App::environment() }}.css"> -->
        @endif
    </head>
    <body id="app-layout">
        @if( Session::has('flash_error_message') )
            <div class="alert alert-danger">{{ Session::get('flash_error_message') }}</div>
        @endif

        <nav class="nav has-shadow" id="top">
            <div class="container">
                <div class="nav-left">
                    <a class="nav-item" href="{{ url('/') }}">
                        <h1 class="title is-4">Freelance Hero</h1>
                    </a>
                    <a class="{{ (preg_match( '/HomeController/', Route::getCurrentRoute()->getActionName())) ? 'nav-item is-tab is-active' : 'nav-item is-tab' }}" href="{{ url('/home') }}">
                        Home
                    </a>
                    <a class="{{ (preg_match( '/OrganizationsController/', Route::getCurrentRoute()->getActionName())) ? 'nav-item is-tab is-active' : 'nav-item is-tab' }}" href="{{ url('/organizations') }}">
                        Organizations
                    </a>
                    <a class="{{ (preg_match( '/ProjectsController/', Route::getCurrentRoute()->getActionName())) ? 'nav-item is-tab is-active' : 'nav-item is-tab' }}" href="{{ url('/projects') }}">
                        Projects
                    </a>
                    @if (Auth::user()->isAdmin())
                    <a class="{{ (preg_match( '/AdminController/', Route::getCurrentRoute()->getActionName())) ? 'nav-item is-tab is-active' : 'nav-item is-tab' }}" href="{{ url('/admin') }}">
                        Admin
                    </a>
                    @endif
                </div>
                <span class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <div class="nav-right nav-menu">
                    <a class="{{ (preg_match( '/UsersController/', Route::getCurrentRoute()->getActionName())) ? 'nav-item is-tab is-active' : 'nav-item is-tab' }}" href="{{ url('/profile') }}">
                        Profile
                    </a>
                    <a class="nav-item is-tab" href="{{ url('/logout') }}">
                        Logout
                    </a>
                </div>
            </div>
        </nav>
        <div id="app">
            @yield('content')
        </div>

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
        <script src="/js/app.js"></script>
        <script async type="text/javascript" src="/js/bulma.js"></script>
    </body>
</html>