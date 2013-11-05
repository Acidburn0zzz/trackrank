var app = angular.module( "TrackRank", [] );

app.run(

);

//fix but where hashtag is being added to urls
app.config(['$locationProvider', function($locationProvider){
  $locationProvider.html5Mode(true).hashPrefix('!');
}]);
