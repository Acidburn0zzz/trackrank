<?php

class QueryController extends BaseController {

	protected $searcher;
	function __construct() {
		$this->searcher = new SearchHelper();
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

  /**
   * Search by artist name, album or name + album
   * @param search query
   * @return JSON object of results
   */
  public function getSearch($query_string)
  {
    return $this->searcher->search($query_string);
  }

  /**
   * Get a post search request from the top nav bar and route the result to the view
   * @return View
   */
  public function postSearch()
  {
    $artist = Input::get("artist");
    $album = Input::get("album");

    return View::make('home')->with(array("artist" => $artist, "album" => $album));
  }

  /**
   * Query for an artist's info and releases by a musicbrainz id
   * @param mbid = artist MBID
   * @param p = (OPTIONAL) page number
   * @return JSON object of artist info and releases
   */
  public function getArtistById($query_string)
  {
    parse_str($query_string, $params);
    $mbid = isset($params["mbid"]) ? $params["mbid"] : null;
    $page = isset($params["p"]) ? $params["p"] : 1;
    if(isset($mbid) && isset($page)) {
      return $this->searcher->getArtistById($mbid, $page);
    }
    return Response::make("ERROR: Invalid MBID", 500);
  }

  /**
   * Get a list of albums by artist id with pagination
   * @param mbid = artist MBID
   * @param p = (OPTIONAL) the page to get
   * @param limit = (OPTIONAL) the number of results per page
   * @return
   */
  public function getReleasesByArtistId($query_string)
  {
    parse_str($query_string, $params);
    $mbid = isset($params["mbid"]) ? $params["mbid"] : null;
    $page = isset($params["p"]) ? $params["p"] : 1;
    $limit = isset($params["limit"]) ? $params["limit"] : Config::get('constants.ALBUMS_BY_ARTIST_LIMIT');
    if(isset($mbid) && isset($page)) {
      return $this->searcher->getReleasesByArtistId($mbid, $page, $limit);
    }
    return Response::make("ERROR: Invalid MBID", 500);
  }

  //TODO: comments
  public function getReleaseByMBID($mbid)
  {
    return $this->searcher->getReleaseByMBID($mbid);
  }


}
