@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Sessions Report</div>
                <div class="panel-body">
                    <form method="GET">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="timeframe">Timeframe</label>
                                <select id="timeframe" name="timeframe" class="form-control">
                                    <option {{ ( Request::get('timeframe') == 'Weekly' ) ? 'selected' : null }}>Weekly</option>
                                    <option {{ ( Request::get('timeframe') == 'Bimonthly' ) ? 'selected' : null }}>Bimonthly</option>
                                    <option {{ ( Request::get('timeframe') == 'Monthly' ) ? 'selected' : null }}>Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">View</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>&nbsp;</p>
                            @if ( count($session_summaries) > 0 )
                                @foreach ( $session_summaries as $summary )
                                    <p>{{ $summary->name }}: {{ $summary->total_time }} hr(s)</p>
                                @endforeach
                            @else
                                <p>No completed work sessions.</p>
                            @endif
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <p><a href="{{ action( 'ProjectsController@index' ) }}">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection