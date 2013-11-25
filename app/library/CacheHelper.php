<?php

use ApaiIO\ApaiIO;
use ApaiIO\Operations\Search;
use ApaiIO\Configuration\GenericConfiguration;

class CacheHelper {
  protected $conf;

  function __construct() {
    $this->conf = new GenericConfiguration();
    $this->conf
      ->setCountry('com')
      ->setAccessKey('AKIAJLC6ICEFO4YUGZ6Q')
      ->setSecretKey('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')
      ->setAssociateTag('track00a-20');
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

  public function cacheAlbumImages($albums)
  {
    $search = new Search();
    $search->setCategory('Music');
    $search->setKeywords('Melvins Houdini');
    $search->setPage(3);
    $search->setResponseGroup(array('Large', 'Small'));
    $apaiIo = new ApaiIO($this->conf);
    $response = $apaiIo->runOperation($search);

    var_dump($response);

  }
}
?>
