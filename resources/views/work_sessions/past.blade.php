@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Previous Work Sessions</div>

                <div class="panel-body">
                    @if ( count($work_sessions) > 0 )
                        @foreach ( $work_sessions as $work_session )
                            <?php
                                $session_time = new Carbon\Carbon($work_session->total_time);
                                if ( $session_time->minute > 45 ) {
                                    $nearest_quarter = 0;
                                    $session_time->hour += 1;
                                } else {
                                    $nearest_quarter = $session_time->minute - ($session_time->minute % 15) + 15;
                                }
                                $session_time_string = $session_time->hour . "hr, " . $nearest_quarter . "min";
                            ?>
                            <p>{{ date_format( date_create($work_session->end_time), 'F jS, Y') }}, {{ $work_session->project->name }}: <strong>{{ $session_time_string }}</strong></p>
                        @endforeach
                    @else
                        <p>No active work sessions.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection