<?php

class ArtistControllerTest extends TestCase {

	public function testArtistView()
	{
    $artist_mbid = "9ccfbc94-a4f4-42f7-b6f5-d903ab77cccb"; //melvins
    $this->call('GET', '/artist/' . $artist_mbid);

    $this->assertResponseOk();
    $this->assertViewHas('artist');
	}

}
