app.service("artistService", function($http) {
  this.get = function(params) {
    return $http.get('/query/' + params);
  };
  this.getArtistById = function(params) {
    return $http.get('/query/artist/' + params);
  };
  this.getArtistReleasesById = function(params) {
    return $http.get('/query/artist_releases/' + params);
  };
});

app.service("paginateService", function($http, artistService) {
  this.getAlbumPage = function(mbid, page, limit) {
    var params = "mbid=" + mbid + "&p=" + page;
    return artistService.getArtistReleasesById(params);
  };
});
