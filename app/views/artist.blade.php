@extends('layouts.scaffold')

@section('content')
<div class="row">
  {{ var_dump($artist) }}
  <div class="large-2 columns"><img src='{{ $artist["images"][0]["uri150"] }}' /></div>

  <div class="large-10 columns"><h3 class="subheader">{{ $artist["name"] }}</h3></div>
</div>
{{ $artist["id"] }}
@stop
