<?php 
namespace Helpers;

class SearchHelper {
  protected $service;
  
  function __construct() {
    $this->service = new \Discogs\Service();
  }

  /**
  * Search by artist name
  * @return array_of Discogs\Model\Result
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
    return $this->service->getArtist($id);
  }
}

?>