<?php

class ReleaseController extends BaseController {

  protected $searcher;
  function __construct() {
    $this->searcher = new \Helpers\SearchHelper();
  }

	/**
	 * Generate the release page
	 * @param  $mbid Release MusicBrainz id
	 * @return Response
	 */
	public function show($mbid)
	{
    $release = $this->searcher->getReleaseById($mbid);
    return View::make('release', array('release' => $release));
	}

  public function showmbid($artist, $mbid)
  {
    $release = $this->searcher->getReleaseByMBID($artist, $mbid);
    return View::make('release', array('release' => $release));
  }

}
