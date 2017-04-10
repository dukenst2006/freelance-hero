@extends('layouts.app')

@section('content')
  <section class="hero is-fullheight is-dark is-bold">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column is-4 is-offset-4">
            <h1 class="title">
              Register an Account
            </h1>
            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="box">
                  <label class="label">First Name</label>
                  <p class="control">
                    <input type="text" class="input{{ $errors->has('first_name') ? ' is-danger' : '' }}" name="first_name" value="{{ old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="help is-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                  </p>
                  <label class="label">Last Name</label>
                  <p class="control">
                    <input type="text" class="input{{ $errors->has('last_name') ? ' is-danger' : '' }}" name="last_name" value="{{ old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="help is-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                  </p>
                  <label class="label">Email</label>
                  <p class="control">
                    <input type="email" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help is-danger">{{ $errors->first('email') }}</span>
                    @endif
                  </p>
                  <hr>
                  <label class="label">Password</label>
                  <p class="control">
                    <input type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password">
                    @if ($errors->has('password'))
                        <span class="help is-danger">{{ $errors->first('password') }}</span>
                    @endif
                  </p>
                  <label class="label">Confirm Password</label>
                  <p class="control">
                    <input type="password" class="input{{ $errors->has('password_confirmation') ? ' is-danger' : '' }}" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <span class="help is-danger">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                  </p>
                  <hr>
                  <p class="control">
                    <button type="submit" class="button is-primary">Register</button>
                    <a href="{{ url('/') }}" class="button is-default">Cancel</a>
                  </p>
                </div>
            </form>
            <p class="has-text-centered">
              <a href="{{ url('/login') }}">Login</a>
            </p>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection
