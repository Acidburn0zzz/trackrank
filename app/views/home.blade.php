@extends('layouts.scaffold')

@section('content')

<div class="large-8 large-offset-2" ng-controller="QueryController">
  <form novalidate>
    <div class="row">
      <div class="large-5 columns">
        <input type="text" placeholder="Artist..." ng-model="query.artist">
      </div>
      <div class="large-5 columns">
        <input type="text" placeholder="Album..." ng-model="query.album">
      </div>
      <div class="large-2 columns">
        <button class="button postfix" ng-click="search(query)">Search</button>
      </div>
    </div>
  </form>
  <div class="panel" ng-repeat="data in output.data">
    <div class="row">
      <div class="large-2 columns text-center"><img src="@{{ data.image }}" /></div>
      <div class="large-10 columns"><a href="/@{{ output.type }}/@{{ data.mbid }}">
        <span ng-if="output.type == 'artist'">
          @{{ data.artist }}
        </span>
        <span ng-if="output.type == 'release'">
          @{{ data.artist }} - @{{ data.name }}<br />
          @{{ data.releasedate }}<br />
        </span>
      </a></div>
    </div>
  </div>
</div>

@stop
