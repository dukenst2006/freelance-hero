@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Previous Work Sessions</div>

                <div class="panel-body">
                    @if ( count($work_sessions) > 0 )
                        @foreach ( $work_sessions as $work_session )
                            <p>Project: {{ $work_session->project->name }}, Length: {{ $work_session->total_time }}</p>
                        @endforeach
                    @else
                        <p>No active work sessions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection