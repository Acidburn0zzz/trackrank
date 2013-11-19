@extends('layouts.scaffold')

@section('content')

@if(Auth::check())
  <a href="/logout">Logout</a>
@endif

@stop