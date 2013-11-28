<?php

namespace LastfmHelper\Models;

class Artist extends AbstractModel
{
  public $mbid;
  public $name;
  public $content;
  public $summary;
  public $place;
  public $year;
  public $images;
  public $releases = array();

  public function __construct($data)
  {
    $this->name =     $this->issetOrNull($data->artist->name);
    $this->mbid =     $this->issetOrNull($data->artist->mbid);
    $this->content =  $this->issetOrNull($data->artist->bio->content);
    $this->summary =  $this->issetOrNull($data->artist->bio->summary);
    $this->place =    $this->issetOrNull($data->artist->bio->placeformed);
    $this->year =     $this->issetOrNull($data->artist->bio->yearformed);
    $this->images = array(
      "small" =>    $this->issetOrNull($data->artist->image[1]->{"#text"}),
      "medium" =>   $this->issetOrNull($data->artist->image[2]->{"#text"}),
      "large" =>    $this->issetOrNull($data->artist->image[3]->{"#text"})
    );


  }
}