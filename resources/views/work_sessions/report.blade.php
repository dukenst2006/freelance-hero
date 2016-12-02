@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Sessions Report</div>
                <div class="panel-body">
                    <work-session-summary></work-session-summary>
                    <div class="col-sm-12 top-padding">
                        <p><a href="{{ action( 'ProjectsController@index' ) }}">Back</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection