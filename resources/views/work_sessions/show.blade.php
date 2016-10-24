@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Session {{ $work_session->id }}</div>

                <div class="panel-body">
                    <p>Project: <a href="{{ action( 'ProjectsController@show', $work_session->project->id ) }}">{{ $work_session->project->name }}</a></p>
                    <p>Start: {{ $work_session->start_time }}</p>
                    <p>End: {{ $work_session->end_time }}</p>
                    <p>Total Hours: {{ $work_session->total_hours }} <i>{{ $work_session->adjusted ? '(manually adjusted)' : null }}</i></p>
                    <p>&nbsp;</p>
                    <p><a href="{{ action( 'WorkSessionsController@edit', $work_session->id ) }}">Edit Session</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection