@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Organization</div>
                <div class="panel-body">
                    {!! Form::model($organization, array('action' => array('OrganizationsController@update', $organization->id), 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT')) !!}
                        @include('organizations._form', ['submitButtonText' => 'Update Organization'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
