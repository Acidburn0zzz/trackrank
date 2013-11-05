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

  public function testGetArtistById()
  {
    $artist_query = "artist=danny+brown";
    $artist_query_result = $this->searchHelper->search($artist_query);
    $artist_id = $artist_query_result[0]["id"];
    $get_artist_id = $this->searchHelper->getArtistById($artist_id);

    $this->assertNotEmpty($get_artist_id);
    $this->assertEquals($artist_id, $get_artist_id["id"]);
  }

}