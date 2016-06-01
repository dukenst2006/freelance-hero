@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">All Projects</div>

                <div class="panel-body">
                    @if ( count($projects) > 0 )
                        @foreach ( $projects as $project )
                            <p>Name: {{ $project->name }}</p>
                        @endforeach
                    @else
                        <p>No active projects.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection