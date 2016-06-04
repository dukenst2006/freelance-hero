@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <p>Your Application's Landing Page.</p>
                    <p>&nbsp;</p>
                    @if ( Session::has('active_work_session') )
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
