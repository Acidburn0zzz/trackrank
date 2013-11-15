@extends('layouts.scaffold')

@section('content')
<div class="panel" ng-controller="ReleaseController" ng-show="loaded" ng-cloak>
  <div class="row">
    <div class="large-2 columns"><img src='@{{ release_data.image_medium}}' /></div>
    <div class="large-10 columns"><h1>@{{ release_data.album }}</h1><h3>@{{ release_data.artist }}, Released: @{{ release_data.date }}</h3></div>
  </div>
  <div class="ratings-row" ng-if="loaded">
    <canvas id="canvas" width="500px" height="300px" style="background: #fff;" ratings-grid ng-show="loaded" ></canvas>
  </div>
  <div class="tracklist-row">
    <div class="panel">
      <h3>Tracklist</h3>
      <ul class="no-bullet">
        <li ng-repeat="track in release_data.tracks.track"><b>@{{ ($index + 1) }}.</b> @{{ track.name }}</li>
      </ul>
    </div>
  </div>
</div>
@stop
