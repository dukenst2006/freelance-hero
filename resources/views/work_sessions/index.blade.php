@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Sessions</div>
                <div class="panel-body">
                    <p><a href="{{ action( 'WorkSessionsController@past' ) }}">Recent Work Sessions</a></p>
                    <p><a href="{{ action( 'WorkSessionsController@report' ) }}">Weekly Work Session Report</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection