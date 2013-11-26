<?php

class CacheHelper {
  protected $lastfm;

  function __construct() {
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

  public function cacheAlbumImages($albums, $artist)
  {
    //dd(getcwd());
    foreach($albums as $album)
    {
      $album_args = array(
        "artist" => $artist,
        "album" => $album["title"]
      );
      $response = $this->lastfm->album_getInfo($album_args);
      $path_medium = getcwd() . "/img/album/175x175/" . $response->album->mbid . ".jpg";
      $path_large = getcwd() . "/img/album/300x300/" . $response->album->mbid . ".jpg";
      if(!file_exists($path_medium) && !empty($response->album->image[2]->{"#text"})) file_put_contents($path_medium, file_get_contents($response->album->image[2]->{"#text"}));
      if(!file_exists($path_large) && !empty($response->album->image[3]->{"#text"})) file_put_contents($path_large, file_get_contents($response->album->image[3]->{"#text"}));
      //var_dump($response);
    }
  }
}
?>
