<!doctype html>
<html lang="en" ng-app="TrackRank">
<head>
  <meta charset="UTF-8">
  <title>AngularJS AuthenticationService Example</title>
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="stylesheet" href="/css/foundation.min.css">
  <link rel="stylesheet" href="/css/style.css">
  <script src="/js/angular.js"></script>
  <script src="/js/angular-resource.min.js"></script>
  <script src="/js/app.js"></script>
</head>
<body>

  <div class="row">
    <div class="large-12">
      <h1>Trackrank</h1>
      <div class="row">
        <div class="large-6 large-offset-3" ng-controller="QueryController">
          {{ output }}<br />
          Search here
        </div>
      </div>
      <div id="view" ng-view></div>
    </div>
  </div>

</body>
</html>
