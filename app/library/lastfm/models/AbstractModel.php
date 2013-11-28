<?php

namespace LastfmHelper\Models;

abstract class AbstractModel
{

  public function __construct()
  {

  }

  /**
  * Checks whether an object property exists, if not return empty string
  * @param $obj Reference to object property
  * @param $nullValue (OPTIONAL) what the value will be set to if property not found, default empty string
  * @return object_property if exists, empty string otherwise
  */
  public function issetOrNull(&$obj, $nullValue = "") 
  {
    return isset($obj) ? $obj : $nullValue;
  }

  /**
   * Prettifys a lastfm api date
   * @param $date lastfm date
   * @return prettified date
   */
  public function prettyDate($date)
  {
    return trim(str_replace(", 00:00", "", $date));
  }

  public function toArray()
  {
    return (array) $this;
  }
}