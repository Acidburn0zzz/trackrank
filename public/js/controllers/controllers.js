app.controller("QueryController", function($scope, $location, ArtistService) {
  $scope.query = {artist: "", album: ""};
  $scope.search = function(query) {
    console.log($scope);
    var res = {type: "", data: ""};
    var param = "";
    if(query.artist.length > 0 && query.album.length > 0) {
      params = "artist=" + query.artist + "&album=" + query.album;
      res.type = "release";
      res.data = ArtistService.get(params).then(function(result) {
        return result.data;
      });
    }
    else if(query.artist.length > 0) {
      params = "artist=" + query.artist;
      res.type = "artist";
      res.data = ArtistService.get(params).then(function(result) {
        return result.data;
      });
    }
    else if(query.album.length > 0) {
      params = "album=" + query.album;
      res.type = "release";
      res.data = ArtistService.get(params).then(function(result) {
        return result.data;
      });
    }
    $scope.output = res;
  };
});
