@extends('layouts.core')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Organization</div>

                <div class="panel-body">
                    <p>Status: {{ $organization->name }}</p>
                    <p><a href="{{ action( 'OrganizationsController@edit', $organization->id ) }}">Edit Organization</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection