<?php

class QueryController extends BaseController {

	protected $searcher;
	function __construct() {
		$this->searcher = new \Helpers\SearchHelper();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('queries.index');
	}

  public function getSearch($query)
  {
    return $this->searcher->search($query);
  }
	/**
	*	Search by artist name
	*	@return array_of_artist_ids
	**/
	public function getSearchArtist($query) {
		return $this->searcher->searchArtists($query);
	}

	/**
	 * Search by album title
	 * @return array_of_album_ids
	 */
	public function getSearchAlbum($query)
	{
		return $this->searcher->searchAlbums($query);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('queries.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('queries.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('queries.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
