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
      <div class="row album-panel" ng-controller="AlbumPageController">
        <a href="#" ng-click="paginate(-1)">
          <div class="large-1 columns page-previous">
            <div class="inner"><img src="/img/leftarrow.png"></div>
          </div>
        </a>
        <div class="large-10 columns album-panel">
          <ul class="small-block-grid-3">
            <li class="album-box" ng-repeat="data in release_data.releases" ng-cloak>
              <a href="/releases/@{{ data.mbid }}" class="th"><div class="album-image"><img src="@{{ data.image_medium }}" style="album-image" /></div></a><br />
              <a href="/releases/@{{ data.mbid }}">@{{ data.name }}</a>
            </li>
          </ul>
        </div>
        <a href="#" ng-click="paginate(1)">
          <div class="large-1 columns page-next">
            <div class="inner-right"><img src="/img/leftarrow.png"></div>
          </div>
        </a>
      </div>

    </div>
  </div>
  <a href="/">Back to search</a>
</div>
@else
<div class="alert-error">No artist found!</div>
@endif

@stop
