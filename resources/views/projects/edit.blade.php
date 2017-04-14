@extends('layouts.core')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Project</div>
                <div class="panel-body">
                    {!! Form::model($project, array('action' => array('ProjectsController@update', $project->id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT')) !!}
                        @include('projects._form', ['submitButtonText' => 'Update Project'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
