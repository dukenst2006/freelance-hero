@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $project->name }}</div>

                <div class="panel-body">
                    <p>Status: {{ $project->status }}</p>
                    <p>Start Date: {{ $project->start_date }}</p>
                    <p>Target End Date: {{ $project->target_end_date ?: "N/A" }}</p>
                    @if ( $project->end_date )
                    <p>Date Completed: {{ $project->end_date }}</p>
                    @else
                        <p>&nbsp;</p>
                        {!! Form::model($project, array('action' => array('ProjectsController@complete'), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST')) !!}
                            {!! Form::hidden('project_id', $project->id) !!}
                            {!! Form::submit('Complete Project', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    @endif
                    <p>&nbsp;</p>
                    <p><a href="{{ action( 'ProjectsController@edit', $project->id ) }}">Edit Project</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Sessions</div>

                <div class="panel-body">
                    @if ( count($work_sessions) > 0 )
                        <table class="table">
                        <?php $i = 1; ?>
                        @foreach ( $work_sessions as $work_session )
                            <tr class="{{ $i === 1 && Session::has('status') ? 'success' : null }}">
                                <td>
                                    {{ date_format( date_create($work_session->end_time), 'l, m/d/Y') }}, {{ $work_session->project->name }}: <strong>{{ $work_session->total_hours }}hr(s)</strong>
                                    &nbsp;&nbsp;&nbsp;<a href="{{ action( 'WorkSessionsController@show', $work_session->id ) }}"><i class="fa fa-btn fa-eye"></i></a>
                                    &nbsp;&nbsp;&nbsp;<a href="{{ action( 'WorkSessionsController@edit', $work_session->id ) }}"><i class="fa fa-btn fa-pencil"></i></a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        </table>
                        {{ $work_sessions->links() }}
                        <p><a href="{{ action( 'WorkSessionsController@report' ) }}">View Summary</a></p>
                    @else
                        <p>No completed work sessions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection