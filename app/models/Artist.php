<?php

class Artist extends EloquentValidation {
	protected $guarded = array();

	protected $rules = array(
    "mbid" => "required|unique:artists",
    "name" => "required",
  );
}
