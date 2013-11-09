<?php
namespace Helpers;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\Filters\ReleaseFilter;
use Guzzle\Http\Client;

/**
 * Checks whether an object property exists, if not return empty string
 * @param Reference to object property
 * @return object_property if exists, empty string otherwise
 */
function issetOrNull(&$obj) {
  return isset($obj) ? $obj : "";
}

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
   * @param lastfm date
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
   * Builds a JSON response checking each property inside the object for existence before it is added
   * @param object to test
   * @param array of {property_path_in_obj, name_for_output_array}
   * @return array of valid JSON
   */
  public static function buildJSONResponse($obj, $params) {
    $output_arr = [];
    var_dump($obj);
    foreach($params as $param) {
      $output_arr[$param[1]] = isset($obj->$param[0]) ? $obj->{$param[0]} : "";
      //$output_arr[$param] = property_exists($obj, $param) ? $obj->$param : "";
      // if(property_exists($obj, $param)) {
      //   $output_arr[$param] = $obj->$param;
      // } else {
      //   $output_arr[$param] = "";
      // }
    }
    var_dump ($output_arr);
    return $output_arr;
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
          "name" => isset($album->name) ? $album->name : "",
          "artist" => isset($album->artist) ? $album->artist : "",
          "mbid" => isset($album->mbid) ? $album->mbid : "",
          "releasedate" => isset($album->releasedate) ? SearchHelper::prettyDate($album->releasedate) : "",
          "image" => isset($album->image[1]->{"#text"}) ? $album->image[1]->{"#text"} : "",
          "genre" => isset($album->toptags->tag[0]->name) ? $album->toptags->tag[0]->name : ""
        );
        // $output_arr[] = array(
        //   "name" => $album->name,
        //   "artist" => $album->artist,
        //   "mbid" => $album->mbid,
        //   "releasedate" => SearchHelper::prettyDate($album->releasedate),
        //   "image" => $album->image[1]->{"#text"},
        //   "genre" => $album->toptags->tag[0]->name
        // );
      }
    }
    else if(in_array("artist", $keys)) {
      $result = $this->lastfm->artist_search($args);
      foreach($result->results->artistmatches->artist as $artist) {
        if($artist->mbid != null) {
          $output_arr[] = array(
            "a" => issetOrNull($artist->naasdasde),
            "artist" => isset($artist->name) ? $artist->name : "",
            "mbid" => isset($artist->mbid) ? $artist->mbid : "",
            "image" => isset($artist->image[1]->{"#text"}) ? $artist->image[1]->{"#text"} : ""
          );
          // $output_arr["artist"] = isset($artist->name) ? $artist->name : "";
          // $output_arr["mdib"] = isset($artist->mbid) ? $artist->mbid : "";
          // $output_arr["image"] = isset($artist->image[1]->{"#text"}) ? $artist->image[1]->{"#text"} : "";
          // $output_arr[] = array(
          //   "artist" => $artist->name,
          //   "mbid" => $artist->mbid,
          //   "image" => $artist->image[1]->{"#text"}
          // );
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
      $artist = $this->lastfm->artist_getInfo($args);
      $releases = $this->lastfm->artist_getTopAlbums($args);
      $releases_arr = [];
      foreach($releases->topalbums->album as $album) {
        $releases_arr[] = array(
          "mbid" => $album->mbid,
          "name" => $album->name,
          "image" => $album->image[3]->{"#text"}
        );
      }
      $output_arr = array(
        "artist" => $artist->artist->name,
        "summary" => $artist->artist->bio->summary,
        "year" => $artist->artist->bio->yearformed,
        "place" => $artist->artist->bio->placeformed,
        "mbid" => $artist->artist->mbid,
        "image" => $artist->artist->image[3]->{"#text"},
        "releases" => $releases_arr
      );
      return $output_arr;
    }
    return null;
    // $artist_arr = $this->service->getArtist($id)->toArray();
    // $releases_arr = $this->service->getReleases($artist_arr["id"]);
    // var_dump($releases_arr);
    // return $artist_arr;
  }
}

?>
