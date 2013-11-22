<?php

class Artist extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
    "mbid" => "required|unique",
    "name" => "required",
  );

  public function isValid()
  {
    dd(static::$rules);
    return Validator::make($this->toArray(), static::$rules)->passes();
  }
}
