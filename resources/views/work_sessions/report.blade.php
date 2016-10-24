@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Work Sessions Report</div>
                <div class="panel-body">
                    <form method="GET" id="sessions-report">
                    <div class="row" id="preset-timeframe-selectors">
                        <div class="form-group col-sm-4">
                            <label for="timeframe">Timeframe</label>
                            <select id="timeframe" name="timeframe" class="form-control">
                                <option {{ ( Request::get('timeframe') == 'Weekly' ) ? 'selected' : null }}>Weekly</option>
                                <option {{ ( Request::get('timeframe') == 'Bimonthly' ) ? 'selected' : null }}>Bimonthly</option>
                                <option {{ ( Request::get('timeframe') == 'Monthly' ) ? 'selected' : null }}>Monthly</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="custom-timeframe-button">&nbsp;</label><br />
                            <button type="button" class="btn btn-default" id="custom-timeframe-button">Custom Timeframe</button>
                        </div>
                    </div>
                    <div class="row collapse" id="custom-timeframe-selectors">
                        <div class="form-group col-sm-3">
                            <label for="date_start">Timeframe</label>
                            <input id="date_start" class="form-control datepicker" name="date_start" type="text" placeholder="Start Date">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="date_end">&nbsp;</label>
                            <input id="date_end" class="form-control datepicker" name="date_end" type="text" placeholder="End Date">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="preset-timeframe-button">&nbsp;</label><br />
                            <button type="button" class="btn btn-default" id="preset-timeframe-button">Preset Timeframe</button>
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
                            <div id="result-container">
                            </div>
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