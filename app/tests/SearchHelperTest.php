<?php

class SearchHelperTest extends TestCase {

  protected $searchHelper;
  public function setUp() {
    $this->searchHelper = new SearchHelper();
  }

  public function testSearchFunction()
  {
    $artist_query = "artist=danny+brown";
    $album_query = "album=the+hybrid";
    $artist_album_query = $artist_query . "&" . $album_query;
    $artist_query_mixed_case = "ArTiST=danNy+bROWN";

    $artist_query_result = $this->searchHelper->search($artist_query);
    $this->assertNotEmpty($artist_query_result);

    $album_query_result = $this->searchHelper->search($album_query);
    $this->assertNotEmpty($album_query_result);

    $artist_album_query_result = $this->searchHelper->search($artist_album_query);
    $this->assertNotEmpty($artist_album_query_result);

    $artist_query_mixed_case_result = $this->searchHelper->search($artist_query_mixed_case);
    $this->assertNotEmpty($artist_query_mixed_case_result);
  }

  public function testGetArtistById()
  {
    $artist_query = "artist=melvins";
    $artist_query_result = $this->searchHelper->search($artist_query);
    $artist_id = $artist_query_result[0]["mbid"];
    $get_artist_id = $this->searchHelper->getArtistById($artist_id);

    $this->assertNotEmpty($get_artist_id);
    $this->assertEquals($artist_id, $get_artist_id["mbid"]);
  }

  public function testGetArtistByName()
  {
    $name = "melvins";

    $artist_by_name_result = $this->searchHelper->getArtistById($name);
    $this->assertNotNull($artist_by_name_result);
    $this->assertEquals($artist_by_name_result["name"], "Melvins");
  }

  public function testGetReleasesByArtistId()
  {
    $artist_id = "9ccfbc94-a4f4-42f7-b6f5-d903ab77cccb"; //Melvins
    $releases_by_artist_id_result = $this->searchHelper->getReleasesByArtistId($artist_id);

    $this->assertNotEmpty($releases_by_artist_id_result);
  }

  public function testGetReleaseByArtistMBID()
  {
    $artist_id = "9ccfbc94-a4f4-42f7-b6f5-d903ab77cccb"; //Melvins
    $releases_by_artist_mbid_result = $this->searchHelper->getReleasesByArtistMBID($artist_id);

    $this->assertNotEmpty($releases_by_artist_mbid_result);
  }

  public function testIsValidMBID()
  {
    $valid_mbid = "0383dadf-2a4e-4d10-a46a-e9e041da8eb3";
    $valid_mbid2 = "0383DADF-2A4E-4d10-a46a-e9e041da8eb3";
    $invalid_mbid = "0383dadf-2a4e-4d10-a46a-";

    $this->assertEquals($this->searchHelper->isValidMBID($valid_mbid), 1); //TRUE
    $this->assertEquals($this->searchHelper->isValidMBID($valid_mbid2), 1); //TRUE
    $this->assertEquals($this->searchHelper->isValidMBID($invalid_mbid), 0); //FALSE
  }

  public function testGetReleaseById()
  {
    $release_id = "67d450b3-9f16-43e7-a819-019e6e54e074"; //Melvins - Bullhead
    $release_by_id_result = $this->searchHelper->getReleaseByMBID($release_id);

    $this->assertNotEmpty($release_by_id_result);
    $this->assertEquals($release_by_id_result["album"], "Bullhead");
    $this->assertEquals($release_by_id_result["tracks"][0]["title"], "Boris");
  }
}
