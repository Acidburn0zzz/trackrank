<?php

class Album extends EloquentValidation {
  protected $guarded = array();

  protected $rules = array(
    "mbid" => "required|unique:albums"
  );
}
