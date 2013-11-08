@extends('layouts.scaffold')

@section('content')
<div class="row">
  {{ var_dump($artist) }}
  <div class="large-2 columns"><img src='{{ $artist["image"] }}' /></div>

  <div class="large-10 columns">
    <h2 class="header">{{ $artist["artist"] }}</h2>
    <h5 class="header">From {{ $artist["place"] }}, formed in {{ $artist["year"] }}</h5>
  </div>
</div>

<div class="row">
  <div class="large-12 columns">
    {{ $artist["summary"] }}
  </div>
</div>

<div class="row">
  <div class="section-container vertical-tabs" data-section="vertical-tabs">
    @foreach($artist["releases"] as $album)
      <section>
        <p class="title" data-section-title><a href="#">{{ $album["name"] }}</a></p>
        <div class="content" data-section-content>
          <p><img src="{{ $album['image']}}" /></p>
        </div>
      </section>
    @endforeach
  </div>
</div>
@stop
