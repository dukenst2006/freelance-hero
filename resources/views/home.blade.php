@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Dashboard</h1>
            <hr>
            @if ( !Session::has('active_work_session') )
                <p class="lead"><a href="{{ action('WorkSessionsController@create') }}">Start Work Session</a></p>
            @endif
            <p>&nbsp;</p>
            <h3>Projects</h3>
            <hr>
	            @if ( count($projects) > 0 )
	                @foreach ( $projects as $project )
                        <?php
                            $timeline = false;
                            if ( $project->start_date && $project->target_end_date ) {
                                $project_start = new DateTime($project->start_date);
                                $project_end_date = new DateTime($project->target_end_date);
                                $current_date = new DateTime();
                                $project_length = date_diff($project_end_date, $project_start)->days;
                                $project_duration = date_diff($current_date, $project_start)->days;
                                $project_percent_complete = number_format( ($project_duration / $project_length) * 100, 0 );
                                $timeline = true;
                            }
                        ?>
	                    <div class="col-sm-8">
		                    <p><a href="{{ action( 'ProjectsController@show', $project->id ) }}">{{ $project->name }}</a></p>

		                    @if ( $timeline )
								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="{{$project_percent_complete}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$project_percent_complete}}%;">
										{{$project_percent_complete}}%
									</div>
								</div>
							@else
								<p><em>No timeline.</em></p>
							@endif
						</div>
	                @endforeach
	            @else
	                <p>No active projects.</p>
	            @endif
        </div>
    </div>
</div>
@endsection
