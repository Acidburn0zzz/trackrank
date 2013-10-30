<?php

class QueryControllerTest extends TestCase {


	public function testSearchArtist()
	{
    $this->client->request('GET', '/query/search/artist/danny+brown');

    $this->assertTrue($this->client->getResponse()->isOk());

    $jsonResponse = $this->client->getResponse()->getContent();
    $responseData = json_decode($jsonResponse);

    $this->assertTrue(count($responseData) > 0);
	}

}