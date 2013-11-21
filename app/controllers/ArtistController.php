<?php

class ArtistController extends BaseController {

  protected $searcher;
  function __construct() {
    $this->searcher = new SearchHelper();
  }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $page = 1)
	{
    $artist_info = $this->searcher->getArtistById($id, $page);
    return View::make('artist', array('artist' => $artist_info));
	}

}
