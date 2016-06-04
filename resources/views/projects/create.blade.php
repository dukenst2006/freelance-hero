@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Project</div>
                <div class="panel-body">
                    {!! Form::open(array('action' => 'ProjectsController@store', 'class' => 'form-horizontal', 'role' => 'form')) !!}
                        @include('projects._form', ['submitButtonText' => 'Create'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
