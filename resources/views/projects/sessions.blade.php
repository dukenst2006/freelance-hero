@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Previous Work Sessions for {{ $project->name }}</div>

                <div class="panel-body">
                    @if ( count($project->work_sessions) > 0 )
                        @foreach ( $project->work_sessions as $work_session )
                            <p>{{ date_format( date_create($work_session->end_time), 'l, m/d/Y') }}, {{ $work_session->project->name }}: <strong>{{ $work_session->total_hours }}hr(s)</strong></p>
                        @endforeach
                    @else
                        <p>No completed work sessions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection