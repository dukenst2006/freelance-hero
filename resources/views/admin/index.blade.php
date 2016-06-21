@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Portal</div>

                <div class="panel-body">
                    @if ( count($users) > 0 )
                        @foreach ( $users as $user )
                            <p>Name: {{ $user->first_name }} {{ $user->last_name }}</a></p>
                        @endforeach
                    @else
                        <p>No active users.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection