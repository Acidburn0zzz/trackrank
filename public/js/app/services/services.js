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
  this.getAlbumPage = function(mbid) {
    var params = "mbid=" + mbid;
    return artistService.getArtistReleasesById(params);
  };
  this.getPageData = function(page, limit, data) {
    return data.slice(page * limit, (page * limit) + limit);
  };
});

app.service("releaseService", function($http) {
  this.getReleaseData = function(mbid) {
    return $http.get('/query/release');
  }
});
