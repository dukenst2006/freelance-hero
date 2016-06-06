<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}

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
        {!! Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive', 'Completed' => 'Completed'), 'Active', ['class' => 'form-control']); !!}

        @if ($errors->has('status'))
            <span class="help-block">
                <strong>{{ $errors->first('status') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
    {!! Form::label('start_date', 'Start Date', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('start_date', null, ['class' => 'form-control datepicker']) !!}

        @if ($errors->has('start_date'))
            <span class="help-block">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('target_end_date') ? ' has-error' : '' }}">
    {!! Form::label('target_end_date', 'Target End Date', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('target_end_date', null, ['class' => 'form-control datepicker']) !!}

        @if ($errors->has('target_end_date'))
            <span class="help-block">
                <strong>{{ $errors->first('target_end_date') }}</strong>
            </span>
        @endif
    </div>
</div>

@if ( isset($project) )
<div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
    {!! Form::label('end_date', 'End Date', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
        {!! Form::text('end_date', null, ['class' => 'form-control']) !!}

        @if ($errors->has('end_date'))
            <span class="help-block">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
    </div>
</div>
@endif

@if ( !isset($project) )
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
@endif

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
