@extends('layouts.scaffold')

@section('content')

@if(isset($artist))
<div class="panel">
  <div class="row">
    <div class="large-2 columns"><img src='{{ $artist["image_large"] }}' /></div>

    <div class="large-10 columns">
      <h2 class="header">{{ $artist["artist"] }}</h2>
      <h5 class="header">From {{ $artist["place"] }}, formed in {{ $artist["year"] }}</h5>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns artist-summary">
      {{ $artist["summary"] }}
    </div>
  </div>

  <div class="row">
    <div class="panel callout-artist-releases">
      <div class="row" ng-controller="AlbumPageController">
        <div class="large-1 columns">
          <a href="#" ng-click="previousPage()">PREV</a>
        </div>
        <div class="large-10 columns">
          <ul class="small-block-grid-3">
            <li ng-repeat="data in release_data.releases" ng-cloak>
              <a href="/releases/@{{ data.mbid }}" class="th"><img src="@{{ data.image_medium }}" /></a><br />
              <a href="/releases/@{{ data.mbid }}">@{{ data.name }}</a>
            </li>
          </ul>
        </div>
        <div class="large-1 columns">
          <a href="#" ng-click="nextPage()">NEXT</a>
        </div>
      </div>

    </div>
  </div>
  <a href="/">Back to search</a>
</div>
@else
<div class="alert-error">No artist found!</div>
@endif

@stop
