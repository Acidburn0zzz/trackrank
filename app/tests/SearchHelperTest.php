<?php

class SearchHelperTest extends TestCase {

  protected $searchHelper;
  public function setUp() {
    $this->searchHelper = new \Helpers\SearchHelper();
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