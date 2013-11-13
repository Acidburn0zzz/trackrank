<?php

class SearchHelperTest extends TestCase {

  protected $searchHelper;
  public function setUp() {
    $this->searchHelper = new \Helpers\SearchHelper();
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

  public function testIssetOrNull()
  {
    $null_checks = (object) array(
      "artist" => "melvins",
      "year" => "",
    );

    $this->assertNotEmpty(\Helpers\issetOrNull($null_checks->artist));
    $this->assertEmpty(\Helpers\issetOrNull($null_checks->year));
    $this->assertEmpty(\Helpers\issetOrNull($null_checks->invalidProperty));
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

  public function testGetReleasesByArtistId()
  {
    $artist_id = "9ccfbc94-a4f4-42f7-b6f5-d903ab77cccb"; //Melvins
    $releases_by_artist_id_result = $this->searchHelper->getReleasesByArtistId($artist_id);

    $this->assertNotEmpty($releases_by_artist_id_result);
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
    $release_id = "05b5d7bc-35f6-470a-9597-bb35020f39d0"; //This Heat - This Heat
    //$release_by_id_result = $this->searchHelper->getReleaseById($release_id);

    //$this->assertNotEmpty($release_by_id_result);
  }
}
