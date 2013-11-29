<?php

class CacheHelper {
  protected $lastfm;

  function __construct() {
    $this->lastfmservice = new \LastfmHelper\LastfmHelper();
    $this->lastfm = new \Dandelionmood\LastFm\LastFm("a179ca871e578d4a0c51d406e14fbc54", "40c5c9863176992f7688afdc3c0abf35");
  }
  /**
   * Store an artist in the database
   * @param $data array_of_artist_data
   * @return
   */
	public static function cacheArtistData($data)
	{
    $artist = new Artist();
    if($artist->validate($data)) {
      $artist->fill($data);
      $artist->save();
    }
	}

  /**
   * Store an album in the database
   * @param $data album_data_object \LastfmHelper\Models\Album
   * @return
   */
  public static function cacheAlbumData($album_obj)
  {
    $album = new Album();
    $data = array(
      "mbid" => $album_obj->mbid,
      "title" => $album_obj->name,
      "artist" => $album_obj->artist,
      "date" => $album_obj->date,
      "img_small" => $album_obj->images["medium"],
      "img_large" => $album_obj->images["large"],
      "img_cached" => false
    );
    if($album->validate($data)) {
      $album->fill($data);
      $album->save();
    }
  }

  public function cacheAlbumImages($albums, $artist)
  {
    foreach($albums as $album)
    {
      $album_args = array(
        "artist" => $artist,
        "album" => $album["title"]
      );
      $response = $this->lastfmservice->albumGetInfo($album_args);
      //$response = $this->lastfm->album_getInfo($album_args);
      $path_medium = getcwd() . "/img/album/175x175/" . $response->mbid . ".jpg";
      $path_large = getcwd() . "/img/album/300x300/" . $response->mbid . ".jpg";
      if(!file_exists($path_medium) && !empty($response->images["medium"])) file_put_contents($path_medium, file_get_contents($response->images["medium"]));
      if(!file_exists($path_large) && !empty($response->images["large"])) file_put_contents($path_large, file_get_contents($response->images["large"]));
    }
  }

  public function getImage($mbid, $artist, $album)
  {
    $album_query = Album::where('mbid', '=', $mbid)->get();
    if($album_query->isEmpty()) {
      $album_args = array("artist" => $artist, "album" => $album);

        $response = $this->lastfmservice->albumGetInfo($album_args);
        CacheHelper::cacheAlbumData($response); //Store album data in database
        return $response->images["medium"];

    } else {
      return $album_query->img_small;
    }
  }
}
?>
