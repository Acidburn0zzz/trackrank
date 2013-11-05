<?php
namespace MusicBrainz;

class MusicBrainz() {

  protected $api_url;
  public function __construct() {
    $this->api_url = "http://musicbrainz.org/ws/2/";
  }
}


?>