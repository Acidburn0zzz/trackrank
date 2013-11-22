<?php

class CacheHelper {

  /**
   * Store an artist in the database
   * @param $data array_of_artist_data
   * @return
   */
	public static function cacheArtistData($data)
	{
    $artist = Artist::create($data);
	}
}
?>
