<!doctype html>
<html lang="en" ng-app="TrackRank">
<head>
  <meta charset="UTF-8">
  <title>RankTracks</title>
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="stylesheet" href="/assets/stylesheets/app.css">
  <link rel="stylesheet" href="/css/style.css">
  <script src="/assets/javascripts/vendor/custom.modernizr.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="/assets/javascripts/vendor/angular.min.js"></script>
  <script src="/assets/javascripts/vendor/angular-animate.min.js"></script>
  <script src="/js/app/app.js"></script>
  <script src="/js/app/controllers/controllers.js"></script>
  <script src="/js/app/services/services.js"></script>
</head>
<body>

  <div class="row">
    <div class="large-12">
      <h1>RankTracks</h1>
      <div class="row">
        @yield('content')
      </div>
      <div id="view" ng-view></div>
    </div>
  </div>
  <script>
    document.write('<script src=/assets/javascripts/vendor/'
      + ('__proto__' in {} ? 'zepto' : 'jquery')
      + '.js><\/script>');
  </script>
  <script src="//cdn.jsdelivr.net/foundation/4.3.2/js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>
