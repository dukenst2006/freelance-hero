@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    @if ( Session::has('active_work_session') )
                        <p>&nbsp;</p>
                        {!! Form::open(array('action' => 'WorkSessionsController@end', 'class' => 'form-horizontal', 'role' => 'form')) !!}
                            {!! Form::submit('End Session', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
