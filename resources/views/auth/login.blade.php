@extends('layouts.app')

@section('content')
  <section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column is-4 is-offset-4">
            <h1 class="title">
              Login
            </h1>
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="box">
                  <label class="label">Email Address</label>
                  <p class="control">
                    <input type="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                  </p>
                  <label class="label">Password</label>
                  <p class="control">
                    <input type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password">
                    @if ($errors->has('password'))
                        <span class="help is-danger">{{ $errors->first('password') }}</span>
                    @endif
                  </p>
                  <div class="field">
                    <p class="control">
                      <label class="checkbox">
                        <input type="checkbox"> Remember me
                      </label>
                    </p>
                  </div>
                  <hr>
                  <p class="control">
                    <button type="submit" class="button is-primary">Login</button>
                    <a href="{{ url('/') }}" class="button is-default">Cancel</a>
                  </p>
                </div>
            </form>
            <p class="has-text-centered">
              <a href="{{ url('/register') }}">Register an Account</a>
              | 
              <a href="{{ url('/password/reset') }}">Forgot password</a>
            </p>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection
