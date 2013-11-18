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

<!-- Navigation -->


  <nav class="top-bar">
    <ul class="title-area">
      <li class="name"><h1><a href="#">RankTracks</a></h1></li>
      <li class="toggle-topbar menu-item"><a href="#">asdf</a></li>
    </ul>

    <section class="top-bar-section">
      <ul class="right">
        <li><a href="#">Test Item</a></li>
        <li><a href="#">Test2</a></li>
      </ul>
    </section>
  </nav>
<!-- End Navigation -->


  <form novalidate>
    <div class="row collapse">
      <div class="small-5 columns">
        <input type="text" placeholder="Artist..." ng-model="query.artist">
      </div>
      <div class="small-5 columns">
        <input type="text" placeholder="Album..." ng-model="query.album">
      </div>
      <div class="small-2 columns">
        <button class="button" ng-click="search(query)">Search</button>
      </div>
    </div>
  </form>

  <div class="row">
    <div class="large-12">
      <h1>RankTracks</h1>
      <a href="#" data-reveal-id="loginModal">Login</a>
      <div class="row">
        @yield('content')
      </div>
      <div id="view" ng-view></div>
    </div>
  </div>

  <div id="loginModal" class="reveal-modal">
    <h2>Test</h2>
    <a class="close-reveal-modal">&#215;</a>
  </div>
  <script>
    document.write('<script src=/assets/javascripts/vendor/'
      + ('__proto__' in {} ? 'zepto' : 'jquery')
      + '.js><\/script>');
  </script>
  <script src="//cdn.jsdelivr.net/foundation/4.3.2/js/foundation.min.js"></script>
  <script src="assets/javascripts/foundation/foundation.reveal.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>
