@extends('layouts.core')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Active Work Sessions</div>

                <div class="panel-body">
                    @if ( $work_session )
                        <p>Name: {{ $work_session->project->name }}</p>
                    @else
                        <p>No active work sessions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection