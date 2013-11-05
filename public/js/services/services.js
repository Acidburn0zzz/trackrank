app.service("ArtistService", function($http) {
  this.get = function(params) {
    return $http.get('/query/' + params);
  };
});
