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
                            <?php
                                $last_logged_in = $user->last_logged_in ? new Carbon\Carbon($user->last_logged_in) : null;
                                $last_seen = $last_logged_in ? $last_logged_in->diffForHumans() : 'Never';
                            ?>
                            <p>Name: {{ $user->first_name }} {{ $user->last_name }}, Last seen: {{ $last_seen }}</p>
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