@extends('layouts.core')

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
                                $last_seen = $last_seen_times[$user->id] ? new Carbon\Carbon($last_seen_times[$user->id]) : null;
                                $last_seen_text = $last_seen ? $last_seen->diffForHumans() : 'Never';
                            ?>
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p>Email address: {{ $user->email }}</p>
                            @if ( $user->id != Auth::user()->id )
                            <p>Active:
                                @if ( $user->active )
                                    Yes <a href="{{ action( 'AdminController@deactivateUser', $user->id ) }}">deactivate</a>
                                @else
                                    No <a href="{{ action( 'AdminController@activateUser', $user->id ) }}">activate</a>
                                @endif
                            </p>
                            @endif
                            <p>Projects: {{ count( $user->projects )  }}</p>
                            <p>Last seen: {{ $last_seen_text }}</p>
                            <p>&nbsp;</p>
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