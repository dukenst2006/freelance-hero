@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Project</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/projects') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}

                            <div class="col-md-6">
                                    {!! Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive'), 'Active', ['class' => 'form-control']); !!}

                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Start Date</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="start_date" value="{{ old('start_date') }}">

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('target_end_date') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Target End Date</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="target_end_date" value="{{ old('target_end_date') }}">

                                @if ($errors->has('target_end_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('target_end_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('organization_id') ? 'has-error' : '' }}">
                            {!! Form::label('organization_id', 'Organization', ['class' => 'col-md-4 control-label']) !!}

                            <div class="col-md-6">
                                    {!! Form::select('organization_id', $organization_list, null, ['placeholder' => 'No Organization', 'class' => 'form-control']); !!}

                                @if ($errors->has('organization_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('organization_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
