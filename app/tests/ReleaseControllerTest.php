<?php

class ReleaseControllerTest extends TestCase {

	public function testReleaseView()
	{
    $release_id = "05b5d7bc-35f6-470a-9597-bb35020f39d0"; //This Heat - This Heat
    $this->call("GET", "/release/" . $release_id);

    $this->assertResponseOk();
    $this->assertViewHas('release');
	}

}
