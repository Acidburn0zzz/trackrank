@extends('layouts.scaffold')

@section('content')
<div class="large-8 large-offset-2" ng-controller="QueryController">
  <script>
    window.init = { album: {{ '"' . $album . '"' }}, artist: {{ '"' . $artist . '"' }} };
  </script>
  <input type="hidden" name="album" value="{{ $album }}">
  <input type="hidden" name="artist" value="{{ $artist }}">

<!--   <form novalidate>
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
  </form> -->
    <div ng-show="isEmpty(output)" ng-cloak>Search something...</div>
    <div class="panel" ng-repeat="data in output.data" ng-cloak>
      <div class="row">
        <div class="large-2 columns text-center"><img ng-show="data.image" src="@{{ data.image }}" /></div>
        <div class="large-10 columns">
          <a href="/@{{ output.type }}/@{{ data.mbid }}" target="_self">
          <span ng-if="output.type == 'artist'">
            @{{ data.artist }}
          </span>
          <span ng-if="output.type == 'release'">
            @{{ data.artist }} - @{{ data.name }}<br />
            @{{ data.releasedate }}<br />
          </span>
          </a>
        </div>
      </div>
    </div>
</div>

@stop
