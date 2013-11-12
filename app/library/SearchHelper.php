<?php
namespace Helpers;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\Filters\ArtistFilter;
use MusicBrainz\Filters\ReleaseFilter;
use Guzzle\Http\Client;

/**
 * Checks whether an object property exists, if not return empty string
 * @param $obj Reference to object property
 * @param $nullValue (OPTIONAL) what the value will be set to if property not found, default null
 * @return object_property if exists, empty string otherwise
 */
function issetOrNull(&$obj, $nullValue = null) {
  return isset($obj) ? $obj : $nullValue;
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
   * @param $date lastfm date
   * @return prettified date
   */
  public static function prettyDate($date) {
    return trim(str_replace(", 00:00", "", $date));
  }

  /**
   * Checks to see if a given musicbrainz id is valid
   * @param $mbid MusicBrainz id of artist
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
          "name" =>         issetOrNull($album->name),
          "artist" =>       issetOrNull($album->artist),
          "mbid" =>         issetOrNull($album->mbid),
          "releasedate" =>  SearchHelper::prettyDate(issetOrNull($album->releasedate)),
          "image" =>        issetOrNull($album->image[1]->{"#text"}),
          "genre" =>        issetOrNull($album->toptags->tag[0]->name)
        );
      }
    }
    else if(in_array("artist", $keys)) {
      $result = $this->lastfm->artist_search($args);
      foreach($result->results->artistmatches->artist as $artist) {
        if($artist->mbid != null) {
          $output_arr[] = array(
            "artist" => issetOrNull($artist->name),
            "mbid" =>   issetOrNull($artist->mbid),
            "image" =>  issetOrNull($artist->image[1]->{"#text"})
          );
        }
      }
    }
    else if(in_array("album", $keys)) {
      $result = $this->lastfm->album_search($args);
      foreach($result->results->albummatches->album as $album) {
        if($album->mbid != null) {
          $output_arr[] = array(
            "name" =>   issetOrNull($album->name),
            "artist" => issetOrNull($album->artist),
            "mbid" =>   issetOrNull($album->mbid),
            "image" =>  issetOrNull($album->image[1]->{"#text"})
          );
        }
      }
    }

    return $output_arr;
  }

  /**
   * Get artist info and releases by mbid
   * @param $mbid MusicBrainz id of artist
   * @return json_object_of_artist_info_and_releases
   */
  public function getArtistById($mbid)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $artist_args = array(
        "mbid" => $mbid,
        "autocorrect" => 1
      );
      $artist = $this->lastfm->artist_getInfo($artist_args);
      return array(
        "artist" =>       issetOrNull($artist->artist->name),
        "summary" =>      issetOrNull($artist->artist->bio->summary),
        "year" =>         issetOrNull($artist->artist->bio->yearformed),
        "place" =>        issetOrNull($artist->artist->bio->placeformed),
        "mbid" =>         issetOrNull($artist->artist->mbid),
        "image_small" =>  issetOrNull($artist->artist->image[1]->{"#text"}),
        "image_medium" => issetOrNull($artist->artist->image[2]->{"#text"}),
        "image_large" =>  issetOrNull($artist->artist->image[3]->{"#text"}),
        "releases" =>     issetOrNull($releases_arr)
      );
    }
    return null;
  }

  /**
   * Returns an array of an artist's releases with pagination
   * @param $mbid MusicBrainz id of artist
   * @param $page (OPTIONAL) page number
   * @param $limit (OPTIONAL) results per page
   * @return array_of_artists_releases_by_page
   */
  public function getReleasesByArtistId($mbid, $page = 1, $limit = 6)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $album_args = array(
        "mbid" => $mbid,
        "autocorrect" => 1,
        "limit" => $limit,
        "page" => $page
      );
      $releases = $this->lastfm->artist_getTopAlbums($album_args);
      $releases_arr = [];
      $pagination_arr = array(
        "page_limit" =>  $limit,
        "page_number" => issetOrNull($releases->topalbums->{"@attr"}->page, 1),
        "page_total" =>  issetOrNull($releases->topalbums->{"@attr"}->totalPages, 1)
      );
      foreach($releases->topalbums->album as $album) {
        $releases_arr[] = array(
          "mbid" =>         issetOrNull($album->mbid),
          "name" =>         issetOrNull($album->name),
          "image_small" =>  issetOrNull($album->image[1]->{"#text"}),
          "image_medium" => issetOrNull($album->image[2]->{"#text"}),
          "image_large" =>  issetOrNull($album->image[3]->{"#text"})
        );
      }
      $output_arr = array_merge($pagination_arr, array("releases" => $releases_arr));
      return $output_arr;
    }
    return null;
  }
}

?>
