<?php

namespace LastfmHelper;

class LastfmHelper 
{

  protected $lastfmService;

  public function __construct() 
  {
    $this->lastfmService = new \Dandelionmood\LastFm\LastFm("a179ca871e578d4a0c51d406e14fbc54", "40c5c9863176992f7688afdc3c0abf35");
  }

  public function albumGetInfo($args) 
  {
    $album = $this->lastfmService->album_getInfo($args);
    $album_model = new \LastfmHelper\Models\Album($album);
    return $album_model;
  }

  public function artistGetInfo($args)
  {
    $artist = $this->lastfmService->artist_getInfo($args);
    $artist_model = new \LastfmHelper\Models\Artist($artist);
    return $artist_model;
  }
}