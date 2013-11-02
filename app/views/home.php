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
        <div class="large-8 large-offset-2" ng-controller="QueryController">
          <form novalidate>
            <div class="row">
              <div class="large-5 columns">
                <input type="text" placeholder="Artist..." ng-model="query.artist">
              </div>
              <div class="large-5 columns">
                <input type="text" placeholder="Album..." ng-model="query.album">
              </div>
              <div class="large-2 columns">
                <button class="button postfix" ng-click="search(query)">Search</button>
              </div>
            </div>
          </form>
          <div class="panel" ng-repeat="data in output.data">
            <a href="/{{ output.type }}/{{ data.id }}">{{ data.title }}</a>
          </div>
        </div>
      </div>
      <div id="view" ng-view></div>
    </div>
  </div>

</body>
</html>
