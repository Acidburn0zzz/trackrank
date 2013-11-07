<?php
namespace Helpers;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\Filters\ReleaseFilter;
use Guzzle\Http\Client;

class SearchHelper {
  protected $service;
  protected $brainz;
  protected $lastfm;

  function __construct() {
    $this->service = new \Discogs\Service(null, 20);
    $this->lastfm = new \Dandelionmood\LastFm\LastFm("a179ca871e578d4a0c51d406e14fbc54", "40c5c9863176992f7688afdc3c0abf35");
  }

  /**
   * Prettifys a lastfm api date
   * @return prettified date
   */
  public static function prettyDate($date) {
    return trim(str_replace(", 00:00", "", $date));
  }

  /**
   * Checks to see if a given musicbrainz id is valid
   * @return true if input is a valid MBID
   */
  public static function isValidMBID($mbid)
  {
    return preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $mbid);
  }

  /**
   * Search by artist, album or artist + album
   * @return json_object_of_results
   */
  public function search($query)
  {
    parse_str(strtolower($query), $query_str);
    $keys = array_keys($query_str);
    $search_query = [];
    $output_arr = [];
    $args = array("limit" => 75);
    if(isset($query_str["album"])) $args["album"] = $query_str["album"];
    if(isset($query_str["artist"])) $args["artist"] = $query_str["artist"];

    if(in_array("artist", $keys) && in_array("album", $keys)) {
      $result = $this->lastfm->album_getInfo($args);
      foreach($result as $album) {
        $output_arr[] = array(
          "name" => $album->name,
          "artist" => $album->artist,
          "mbid" => $album->mbid,
          "releasedate" => SearchHelper::prettyDate($album->releasedate),
          "image" => $album->image[1]->{"#text"},
          "genre" => $album->toptags->tag[0]->name
        );
      }
    }
    else if(in_array("artist", $keys)) {
      $result = $this->lastfm->artist_search($args);
      foreach($result->results->artistmatches->artist as $artist) {
        if($artist->mbid != null) {
          $output_arr[] = array(
            "artist" => $artist->name,
            "mbid" => $artist->mbid,
            "image" => $artist->image[1]->{"#text"}
          );
        }
      }
    }
    else if(in_array("album", $keys)) {
      $result = $this->lastfm->album_search($args);
      foreach($result->results->albummatches->album as $album) {
        if($album->mbid != null) {
          $output_arr[] = array(
            "name" => $album->name,
            "artist" => $album->artist,
            "mbid" => $album->mbid,
            "image" => $album->image[1]->{"#text"}
          );
        }
      }
    }

    return $output_arr;
  }

  /**
   * Get artist info and releases by mbid
   * @return json_object_of_artist_info_and_releases
   */
  public function getArtistById($mbid)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $args = array(
        "mbid" => $mbid,
        "autocorrect" => 1
      );
      $output_arr = []
      $artist = $this->lastfm->artist_getInfo($args);
      $releases = $this->lastfm->artist_getTopAlbums($args);
      var_dump($artist);
      $output_arr[] = array(
        "artist" => $artist->artist->name,
        "summary" => $artist->artist->bio->summary,
        "year" => $artist->artist->bio->yearformed,
        "place" => $artist->artist->bio->placeformed,
        "mbid" => $artist->artist->mbid,
        "image" => $artist->artist->image[3]->{"#text"}
      );
      return $artist;
    }
    return null;
    // $artist_arr = $this->service->getArtist($id)->toArray();
    // $releases_arr = $this->service->getReleases($artist_arr["id"]);
    // var_dump($releases_arr);
    // return $artist_arr;
  }
}

?>
