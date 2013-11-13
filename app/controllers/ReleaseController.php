<?php

class ReleaseController extends BaseController {

  protected $searcher;
  function __construct() {
    $this->searcher = new \Helpers\SearchHelper();
  }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('release');
	}

}
