<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- Styles Here -->
    {{ HTML::style('assets/css/bootstrap.css') }}
    {{ HTML::style('assets/css/main.css') }}
  </head>

  <body>
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        {{ link_to_route('home', 'Home', null, array('class'=>'navbar-brand')) }}
      </div>
      <div ng-app="trackrank">
        <div ng-controller="MainCtrl">{{ text }}</div>
        <form action="" class="navbar-form navbar-right" role="search">
          <div class="form-group">
            <input id="artist" type="text" class="form-control" placeholder="Artist...">
          </div>
          <div class="form-group">
            <input id="album" type="text" class="form-control" placeholder="Album...">
          </div>
          <button type="submit" class="btn btn-default">Search</button>
        </form>
      </div>
    </nav>
    <div class="container">
      @if (Session::has('error'))
        <div class="alert alert-danger">
          <p>{{ Session::get('error') }}</p>
        </div>
      @endif
      @if (Session::has('message'))
        <div class="alert alert-success">
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif

      @yield('main')
    </div>

    <!-- Scripts Here -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.1/angular.min.js"></script>
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/jquery.js') }}
  </body>

</html>