@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Work Session</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/work_sessions') }}">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('project_id') ? 'has-error' : '' }}">
                            {!! Form::label('project_id', 'Organization', ['class' => 'col-md-4 control-label']) !!}

                            <div class="col-md-6">
                                    {!! Form::select('project_id', $project_list, null, ['placeholder' => 'Select Project...', 'class' => 'form-control']); !!}

                                @if ($errors->has('project_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Start Session</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
