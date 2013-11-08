var app = angular.module( "TrackRank", [] );

//stops built in interception of clicks
app.run(function($location, $rootElement) {
  $rootElement.off('click');
});

//fix but where hashtag is being added to urls
app.config(['$locationProvider', function($locationProvider){
  $locationProvider.html5Mode(true).hashPrefix('!');
}]);
