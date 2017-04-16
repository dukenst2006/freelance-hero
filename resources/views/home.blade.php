@extends('layouts.core')

@section('content')

<section class="hero is-small">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Dashboard</h1>
        </div>
    </div>
    <div class="hero-foot">
        <nav class="level">
            <div class="level-item has-text-centered">
                <p class="heading">Projects</p>
                <p class="title">{{ count($projects) }}</p>
            </div>
            <div class="level-item has-text-centered">
                <p class="heading">Organizations</p>
                <p class="title">{{ count($organizations) }}</p>
            </div>
            <div class="level-item has-text-centered">
                <p class="heading">Total Hours (YTD)</p>
                <p class="title">{{ $ytd_hours->total_hours }}</p>
            </div>
        </nav>
    </div>
</section>
<section class="section">
    <div class="columns is-mobile is-multiline">
        <div class="column is-one-third-desktop is-full-mobile">
            <section class="panel">
                <p class="panel-heading">Projects</p>
                <div class="panel-block">
                    <div id="chart1" style="height: 250px;"></div>
                </div>
                <div class="panel-block">
                    <button class="button is-default is-outlined is-fullwidth">View Data</button>
                </div>
            </section>
        </div>
        <div class="column is-one-third-desktop is-full-mobile">
            <section class="panel">
                <p class="panel-heading">Organizations</p>
                <div class="panel-block">
                    <div id="chart2" style="height: 280px;"></div>
                </div>
                <div class="panel-block">
                    <button class="button is-default is-outlined is-fullwidth">View Data</button>
                </div>
            </section>
        </div>
        <div class="column is-one-third-desktop is-full-mobile">
            <section class="panel">
                <p class="panel-heading">Recent Work Sessions</p>
                <div class="panel-block">
                    <div id="chart3" style="height: 280px;"></div>
                </div>
                <div class="panel-block">
                    <button class="button is-default is-outlined is-fullwidth">View Data</button>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection
