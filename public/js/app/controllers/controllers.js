//SEARCH
app.controller("QueryController", function($scope, $location, artistService) {
  $scope.query = {artist: "", album: ""};
  $scope.output = {};

  $scope.isEmpty = function (obj) {
    return angular.equals({},obj);
  };

  $scope.search = function(query) {
    console.log($scope);
    var res = {type: "", data: ""};
    var param = "";
    if(query.artist.length > 0 && query.album.length > 0) {
      params = "artist=" + query.artist + "&album=" + query.album;
      res.type = "release";
      res.data = artistService.get(params).then(function(result) {
        return result.data;
      });
    }
    else if(query.artist.length > 0) {
      params = "artist=" + query.artist;
      res.type = "artist";
      res.data = artistService.get(params).then(function(result) {
        return result.data;
      });
    }
    else if(query.album.length > 0) {
      params = "album=" + query.album;
      res.type = "release";
      res.data = artistService.get(params).then(function(result) {
        return result.data;
      });
    }
    $scope.output = res;
  };
});

//ALBUM DISPLAY AND PAGINATION
app.controller("AlbumPageController", function($scope, $location, artistService, paginateService) {
  $scope.page = 1;
  $scope.page_size = 6;
  var mbid = $location.path().split("/")[2]; //path = /artist/MBID
  console.log($location);
  console.log(mbid);

  $scope.release_data = {};
  paginateService.getAlbumPage(mbid, 1).then(function(result) {
    $scope.release_data = result.data;
  });

  $scope.paginate = function(change) {
    $scope.page += change;
    paginateService.getAlbumPage(mbid, $scope.page).then(function(result) {
      $scope.release_data = result.data;
    });
    console.log("DATA: ", $scope.release_data);
  };

});

app.controller("RatingController", function($scope) {

});
