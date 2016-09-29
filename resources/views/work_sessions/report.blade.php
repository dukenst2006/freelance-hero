@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Weekly Reports</div>
                <div class="panel-body">
                    @if ( count($session_summaries) > 0 )
                        @foreach ( $session_summaries as $summary )
                            <p>{{ $summary->name }}: {{ $summary->total_time }} hr(s)
                        @endforeach
                    @else
                        <p>No completed work sessions.</p>
                    @endif
                    <p><a href="{{ action( 'WorkSessionsController@index' ) }}">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection