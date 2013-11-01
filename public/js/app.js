var app = angular.module( "TrackRank", [] );

app.run(

);

app.factory("ArtistService", function($http) {
  return {
    get: function(artistName) {
      return $http.get('/query/artist/' + artistName);
    }
  };
});

app.controller("QueryController", function($scope, $location, ArtistService) {
  var res = ArtistService.get("Danny Brown").then(function(result) {
    return result.data;
  });
  $scope.output = res;
});
