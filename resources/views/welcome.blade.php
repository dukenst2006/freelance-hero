@extends('layouts.app')

@section('content')
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
        <p class="title">Get started today!</p>
      </div>
    </nav>
  </div>
  <div class="section main">
    <div class="container">
      <div class="columns">
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-bar-chart icon-block"></i></p>
              <br>
              <p>Keep track of all your projects and their progress by setting start and target completion dates.</p>
            </div>
          </div>
        </div>
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-clock-o icon-block"></i></p>
              <br>
              <p>Track each work session with a built in timer, and view billing summaries across any timeframe you want.</p>
            </div>
          </div>

        </div>
        <div class="column is-4">
          <div class="panel">
            <div class="panel-block section">
              <p class="has-text-centered"><i class="fa fa-users icon-block"></i></p>
              <br>
              <p>Manage your clients and create and send invoices based on work done on the various projects for each.</p>
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
  @endsection