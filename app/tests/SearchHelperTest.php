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

  public function testSearchHelper()
  {
    $artist_id_list = $this->searchHelper->searchArtists('danny+brown');

    $this->assertNotEmpty($artist_id_list);

    $artist_id = $artist_id_list[0]["id"];
    $artist_info = $this->searchHelper->getArtistById($artist_id);

    $this->assertNotNull($artist_info->getName()); //Do we have a name
    $this->assertEquals($artist_id, $artist_info->getId()); //Did we get the right artist

    // $jsonResponse = $this->client->getResponse()->getContent();
    // $responseData = json_decode($jsonResponse);

    // $this->assertTrue(count($responseData) > 0);
  }

}