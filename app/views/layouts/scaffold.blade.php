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
      <li class="name"><h1><a href="/" target="_self">RankTracks</a></h1></li>
      <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    </ul>

    <section class="top-bar-section">
      <ul class="left">
        <li class="has-form">
          <form novalidate action="/" method="POST">
            <div class="row">
              <div class="columns small-6 nav-input">
                <input type="text" placeholder="Artist..." name="artist">
              </div>
              <div class="columns small-6 nav-input">
                <input type="text" placeholder="Album..." name="album">
              </div>
            </div>
        </li>
        <li class="has-button nav-button">
          <button class="button" ng-click="search(query)">Search</button>
        </li>
          </form>
      </ul>

      <ul class="right">
        <li class="nav-button">
          @if(Auth::check())
            <a href="/users/{{ Auth::user()->username }}" target="_self">{{ Auth::user()->username }}</a>
          @else
            <a href="#" data-reveal-id="loginModal">Login / Register</a>
          @endif
        </li>
      </ul>
    </section>
  </nav>
<!-- End Navigation -->


<!-- Main Content -->
  <div class="row ratings-row">
    <div class="large-12">
      <div class="row">
        @if(Session::get('message'))
          <div data-alert class="alert-box">
            {{ Session::get('message') }}
            <a href="#" class="close">&times;</a>
          </div>
        @endif
        @yield('content')
      </div>
      <div id="view" ng-view></div>
    </div>
  </div>
<!-- End Main Content -->

<!-- Login Modal -->
  <div id="loginModal" class="reveal-modal">
    <div class="row">
    <div class="section-container auto user-section" data-section>
      <section class="active">
        <p class="title" data-section-title><a href="#panel1">Login</a></p>
        <div class="content" data-section-content>
          @include('users.login_form')
        </div>
      </section>
      <section>
        <p class="title" data-section-title><a href="#panel2">Register</a></p>
        <div class="content" data-section-content>
          @include('users.register_form')
        </div>
      </section>
    </div>
    </div>
    <a class="close-reveal-modal">&#215;</a>
  </div>
<!-- End Login Modal -->

<!-- Scripts -->
  <script>
    document.write('<script src=/assets/javascripts/vendor/'
      + ('__proto__' in {} ? 'zepto' : 'jquery')
      + '.js><\/script>');
  </script>
  <script src="//cdn.jsdelivr.net/foundation/4.3.2/js/foundation.min.js"></script>
  <script>
    $(document).foundation();
    var resize_window = function(e) {
    $(window).trigger('resize');
}

$(document).foundation('reveal', {'opened' : resize_window});
  </script>
<!-- End Scripts -->
</body>
</html>
