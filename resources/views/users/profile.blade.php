@extends('layouts.core')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">User Profile</div>

                <div class="panel-body">
                    <p>Name: {{ $user->first_name }} {{ $user->last_name }}</p>
                    <p>Email Address: {{ $user->email }}</p>
                    <p><a href="{{ url( '/profile/edit' ) }}">Edit Profile</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection