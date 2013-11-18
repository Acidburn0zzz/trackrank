//SEARCH
app.controller("QueryController", function($scope, $location, $window, artistService) {
  //$scope.query = $window.init;
  console.log("WINDOW: ", $window.init);
  $scope.query = {artist: "", album: ""};
  $scope.output = {};

  $scope.isEmpty = function (obj) {
    return angular.equals({},obj);
  };

  $scope.search = function(query) {
    console.log("SCOPE:", $scope);
    if(query.album == "null") query.album = "";
    if(query.artist == "null") query.artist = "";
    var res = {type: "", data: ""};
    var param = "";
    if(query.artist.length > 0 && query.album.length > 0) {
      params = "artist=" + query.artist + "&album=" + query.album;
      res.type = "release";
      artistService.get(params).then(function(result) {
        res.data = result.data;
      });
    }
    else if(query.artist.length > 0) {
      params = "artist=" + query.artist;
      res.type = "artist";
      artistService.get(params).then(function(result) {
        res.data = result.data;
      });
    }
    else if(query.album.length > 0) {
      params = "album=" + query.album;
      res.type = "release";
      artistService.get(params).then(function(result) {
        res.data = result.data;
      });
    }
    $scope.output = res;
  };

  if($window.init.artist.length > 0 || $window.init.album.length > 0) {
    console.log("not null");
    $scope.search($window.init);
  }
});

//ALBUM DISPLAY AND PAGINATION
app.controller("AlbumPageController", function($scope, $location, artistService, paginateService) {
  $scope.page = 0;
  $scope.page_size = 6;
  var mbid = $location.path().split("/")[2]; //path = /artist/MBID
  console.log($location);
  console.log(mbid);

  $scope.release_data = {};
  $scope.page_data = {};
  paginateService.getAlbumPage(mbid).then(function(result) {
    $scope.release_data = result.data;
    console.log("RD: ", $scope.release_data);
    $scope.page_data = paginateService.getPageData($scope.page, $scope.page_size, $scope.release_data.releases);
    $scope.page_max = Math.floor($scope.release_data.results_total / $scope.page_size);
    if($scope.page_max == 1) $scope.page_max = 0; //This is the case where there is only 1 page of results
    console.log("RD: ", $scope.page_max);
  });

  $scope.paginate = function(change) {
    $scope.page += +change;
    if($scope.page < 0) $scope.page = 0;
    if($scope.page > $scope.page_max) $scope.page = $scope.page_max;
    console.log("page: ", $scope.page);
    console.log("size: ", $scope.page_size);
    $scope.page_data = paginateService.getPageData($scope.page, $scope.page_size, $scope.release_data.releases);
    console.log("DATA: ", $scope.release_data);
  };

});

//RELEASE PAGE
app.controller("ReleaseController", function($scope, $location, releaseService) {
  var mbid = $location.path().split("/")[2]; //path = /release/MBID
  $scope.loaded = false;
  releaseService.getReleaseData(mbid).then(function(result) {
    $scope.release_data = result.data;
    $scope.loaded = true;
  });
});

