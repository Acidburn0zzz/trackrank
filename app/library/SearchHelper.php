<?php

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
function issetOrNull(&$obj, $nullValue = "") {
  return isset($obj) ? $obj : $nullValue;
}

/**
 * Helper function used for sorting an array descending by a "date" field
 */
function sortByDate($a, $b) {
  return strcmp($a["date"], $b["date"]);
}

class SearchHelper {
  protected $service;
  protected $brainz;
  protected $lastfm;
  protected $cache;

  function __construct() {
    //$this->service = new \Discogs\Service(null, 20);
    $this->cache = new CacheHelper();
    $this->brainz = new MusicBrainz(new Client(), null, null);
    $this->lastfm = new \Dandelionmood\LastFm\LastFm("a179ca871e578d4a0c51d406e14fbc54", "40c5c9863176992f7688afdc3c0abf35");
  }

  /**
   * Prettifys a lastfm api date
   * @param $date lastfm date
   * @return prettified date
   */
  public static function prettyDate($date)
  {
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
      $artist_query = Artist::where('mbid', '=', $mbid)->get();
      if($artist_query->isEmpty()) {
        $artist_args = array(
          "mbid" => $mbid,
          "autocorrect" => 1
        );
        $artist = $this->lastfm->artist_getInfo($artist_args);
        $artist_arr = array(
          "name" =>         issetOrNull($artist->artist->name),
          "summary" =>      issetOrNull($artist->artist->bio->summary),
          "year" =>         issetOrNull($artist->artist->bio->yearformed),
          "place" =>        issetOrNull($artist->artist->bio->placeformed),
          "mbid" =>         issetOrNull($artist->artist->mbid),
          "img_small" =>    issetOrNull($artist->artist->image[1]->{"#text"}),
          "img_medium" =>   issetOrNull($artist->artist->image[2]->{"#text"}),
          "img_large" =>    issetOrNull($artist->artist->image[3]->{"#text"})
        );
        CacheHelper::cacheArtistData($artist_arr);
        return $artist_arr;
      } else {
        //dd($artist_query->toArray()[0]);
        return $artist_query->toArray()[0];
      }
    } else {
      $artist = Artist::where('name', '=', $mbid)->get();
      if(!$artist->isEmpty()) {
        return $artist->toArray()[0];
      }
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
  //TODO: Cache images, save by release MBID
  public function getReleasesByArtistId($mbid, $page = 1, $limit = 100)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $album_args = array(
        "mbid" => $mbid,
        "autocorrect" => 1,
        "limit" => $limit
      );
      $releases = $this->lastfm->artist_getTopAlbums($album_args);
      $releases_arr = [];
      $pagination_arr = array(
        "page_limit" =>  $limit,
        "page_number" => issetOrNull($releases->topalbums->{"@attr"}->page, 1),
        "page_total" =>  issetOrNull($releases->topalbums->{"@attr"}->totalPages, 1)
      );
      foreach($releases->topalbums->album as $album) {
        if(isset($album->mbid) && !empty($album->mbid)) {
          $releases_arr[] = array(
            "mbid" =>         issetOrNull($album->mbid),
            "name" =>         issetOrNull($album->name),
            "image_small" =>  issetOrNull($album->image[1]->{"#text"}),
            "image_medium" => issetOrNull($album->image[2]->{"#text"}),
            "image_large" =>  issetOrNull($album->image[3]->{"#text"})
          );
        }
      }
      $pagination_arr["results_total"] = sizeof($releases_arr);
      $output_arr = array_merge($pagination_arr, array("releases" => $releases_arr));
      return $output_arr;
    }
    return null;
  }

/**
   * Get a list of releases by an artist MBID from MusicBrainz
   * @return
   */
  public function getReleasesByArtistMBID($mbid)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $inc = array("release-groups");
      $releases = $this->brainz->lookup("artist", $mbid, $inc);
      $release_data = [];
      $releases_arr = array(
        "artist" =>      issetOrNull($releases["name"]),
        "artist_mbid" => issetOrNull($releases["id"])
      );
      foreach($releases["release-groups"] as $release) {
        $release_data[] = array(
          "title" => issetOrNull($release["title"]),
          "mbid" =>  issetOrNull($release["id"]),
          "date" =>  issetOrNull($release["first-release-date"]),
          "type" =>  issetOrNull($release["primary-type"])
        );
      }
      usort($release_data, "sortByDate");
      $releases_arr["releases"] = $release_data;
      $this->cache->cacheAlbumImages('test');
      return $releases_arr;
    }
    return null;
  }

  /**
   * MusicBrainz release data
   * @return
   */
  public function getReleaseByMBID($mbid)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $inc = array("recordings");
      $release = $this->brainz->lookup("release", $mbid, $inc);
      $release_arr = array(
        "album" => issetOrNull($release["title"]),
        "mbid" => $mbid,
        "date" => issetOrNull($release["date"]),
        "tracks" => issetOrNull($release["media"][0]["tracks"])
      );
      return $release_arr;
    }
    return null;
  }

  /**
   * LastFM release data
   * @return
   */
  public function getReleaseById($mbid)
  {
    if(SearchHelper::isValidMBID($mbid)) {
      $release_args = array(
        "mbid" => $mbid
      );
      $release = $this->lastfm->album_getInfo($release_args);
      $release_arr = array(
        "artist" => issetOrNull($release->album->artist),
        "album" =>  issetOrNull($release->album->name),
        "date" =>   SearchHelper::prettyDate(issetOrNull($release->album->releasedate)),
        "image_small" => issetOrNull($release->album->image[1]->{"#text"}),
        "image_medium" => issetOrNull($release->album->image[2]->{"#text"}),
        "image_large" => issetOrNull($release->album->image[3]->{"#text"})
      );
      $release_arr["tracks"] = $release->album->tracks;
      return $release_arr;
    }
    return null;
  }
}

?>
