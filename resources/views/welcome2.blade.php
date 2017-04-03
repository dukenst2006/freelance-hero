<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freelance Hero</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/bulma.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  <section class="hero is-primary is-large header-image">
    <div class="hero-head">
      <header class="nav">
        <div class="container">
          <div class="nav-left">
            <a class="nav-item title" href="{{ url('/') }}">
                <h1 class="title is-4">Freelance Hero</h1>
            </a>
          </div>
          <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
          </span>
          <div class="nav-right nav-menu">
            <a class="nav-item" href="{{ url('/login') }}">
              Login
            </a>
            <a class="nav-item" href="{{ url('/register') }}">
              Register
            </a>
          </div>
        </div>
      </header>
    </div>
    <div class="hero-body">
      <div class="container has-text-centered">
        <h1 class="title is-2">
          Freelance Hero
        </h1>
        <h2 class="subtitle is-5">
          Companion App for the Self-Employed.
        </h2>
        <p>
          <a class="button is-outlined" href="{{ url('/register') }}">
            <span>
              Sign Up
            </span>
          </a>
        </p>
      </div>
    </div>
  </section>
  <div class="hero-cta">
    <nav class="level">
      <div class="level-item has-text-centered">
        <p class="title">Get started today! <a class="button is-primary" href="{{ url('/register') }}"><span>Sign Up</span></a></p>
      </div>
    </nav>
  </div>
  <div class="section main">
    <div class="container">
      <div class="columns">
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-camera-retro icon-block"></i></p>
              <br>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
            </div>
          </div>
        </div>
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-bar-chart icon-block"></i></p>
              <br>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
            </div>
          </div>

        </div>
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-cloud icon-block"></i></p>
              <br>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet massa fringilla egestas. Nullam condimentum luctus turpis.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="container">
      <div class="content has-text-centered">
        <p>
            Copyright &copy; Freelance Hero 2017. All Rights Reserved.
        </p>
      </div>
    </div>
  </footer>
  <script async type="text/javascript" src="../js/bulma.js"></script>
</body>
</html>