@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Dashboard</h1>
            <hr>
            @if ( !Session::has('active_work_session') )
                <p class="lead"><a href="{{ action('WorkSessionsController@create') }}">Start Work Session</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
