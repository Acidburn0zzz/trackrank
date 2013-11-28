<?php

namespace LastfmHelper\Models;

class Album extends AbstractModel
{

  public $name;
  public $artist;
  public $mbid;
  public $date;
  public $images;
  public $tags;
  public $summary;
  public $tracks;

  public function __construct($data)
  {
    $this->name = $this->issetOrNull($data->album->name);
    $this->artist = $this->issetOrNull($data->album->artist);
    $this->mbid = $this->issetOrNull($data->album->mbid);
    $this->date = $this->prettyDate($this->issetOrNull($data->album->releasedate));
    $this->images = array(
      "small" =>    $this->issetOrNull($data->album->image[1]->{"#text"}),
      "medium" =>   $this->issetOrNull($data->album->image[2]->{"#text"}),
      "large" =>    $this->issetOrNull($data->album->image[3]->{"#text"})
    );
    $this->tags = $this->issetOrNull($data->album->toptags);
    $this->summary = $this->issetOrNull($data->album->wiki->summary);
    $this->tracks = $this->issetOrNull($data->album->tracks);
  }
}