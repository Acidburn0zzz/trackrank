<?php
namespace Helpers;

use MusicBrainz\MusicBrainz;
use MusicBrainz\Filters\RecordingFilter;
use MusicBrainz\Filters\ArtistFilter;
use Guzzle\Http\Client;

class SearchHelper {
  protected $service;
  protected $brainz;

  function __construct() {
    $this->service = new \Discogs\Service(null, 20);
    $this->brainz = new MusicBrainz(new Client(), 'username', 'password');
    $this->brainz->setUserAgent('TestAppName', '0.1', 'http://test.com');
  }

  /**
   * Search by artist, album or artist + album
   * @return json_array_of_results
   */
  public function search($query)
  {
    parse_str(strtolower($query), $query_str);
    $keys = array_keys($query_str);
    $search_query = [];
    $output_arr = [];

    $args = array(
      "artist" => "Danny Brown"
    );

    try {
      $artists = $this->brainz->search(new ArtistFilter($args));
    } catch (Exception $e) {
      print $e->getMessage();
    }

    var_dump($artists);

    if(in_array("artist", $keys) && in_array("album", $keys)) {
      $search_query["type"] = "master";
      $search_query["artist"] = $query_str["artist"];
      $search_query["title"] = $query_str["album"];
    }
    else if(in_array("artist", $keys)) {
      $search_query["type"] = "artist";
      $search_query["title"] = $query_str["artist"];
    }
    else if(in_array("album", $keys)) {
      $search_query["type"] = "master";
      $search_query["title"] = $query_str["album"];
    }

    $results = $this->service->search($search_query)->getResults();
    foreach($results as $result) {
     array_push($output_arr, $result->toArray());
    }
    return $output_arr;
  }

  /**
  * Search by artist name
  * @return array_of artist json objects
  **/
  public function searchArtists($query) {
    $search_query = array("type" => "artist", "q" => $query);
    $artist_ids = [];
    $results = $this->service->search($search_query)->getResults();
    foreach($results as $result) {
     array_push($artist_ids, $result->toArray());
    }
    //var_dump($results);
    return ($artist_ids);
  }

  /**
   * Search by album title, only get masters
   * @return array_of_album_ids
   */
  public function searchAlbums($query)
  {
    $search_query = array("type" => "master", "q" => $query);
    $album_ids = [];
    $results = $this->service->search($search_query)->getResults();
    //var_dump($results);
    foreach($results as $result) {
      array_push($album_ids, $result->getId());
    }
    var_dump($album_ids);
    return($album_ids);
  }

  /**
   * Get an artist object by id
   * @return Artist object (Discogs\Model\Artist)
   */
  public function getArtistById($id)
  {
    $artist_arr = $this->service->getArtist($id)->toArray();
    $releases_arr = $this->service->getReleases($artist_arr["id"]);
    var_dump($releases_arr);
    return $artist_arr;
  }
}

?>
