@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Session {{ $work_session->id }}</div>

                <div class="panel-body">
                    <p>Project: {{ $work_session->project->name }}</p>
                    <p>Start: {{ $work_session->start_time }}</p>
                    <p>End: {{ $work_session->end_time }}</p>

                    {!! Form::model($work_session, array('action' => array('WorkSessionsController@update', $work_session->id), 'class' => 'form-horizontal text-left', 'role' => 'form', 'method' => 'PUT')) !!}
                    <div class="form-group{{ $errors->has('total_hours') ? ' has-error' : '' }}">
                        <div class="col-sm-3">
                            {!! Form::label('total_hours', 'Total Hours', ['class' => 'control-label']) !!}
                            {!! Form::text('total_hours', null, ['class' => 'form-control']) !!}
                            @if ($errors->has('total_hours'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('total_hours') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            {!! Form::submit('Update Session', ['class' => 'btn btn-primary']) !!}
                         </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection