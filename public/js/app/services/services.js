app.service("artistService", function($http) {
  this.get = function(params) {
    return $http.get('/query/' + params);
  };
  this.getArtistById = function(params) {
    return $http.get('/query/artist/' + params);
  };
  this.getArtistReleasesById = function(params) {
    return $http.get('/query/artist_releases_mb/' + params);
  };
});

app.service("paginateService", function($http, artistService) {
  this.getAlbumPage = function(mbid) {
    var params = mbid;
    return artistService.getArtistReleasesById(params);
  };
  this.getPageData = function(page, limit, data) {
    return data.slice(page * limit, (page * limit) + limit);
  };
});

app.service("releaseService", function($http) {
  this.getReleaseData = function(mbid) {
    return $http.get('/query/release_mb/' + mbid);
  };
});

app.directive("ratingsGrid", function(){
  return {
    restrict: "A",
    link: function(scope, element){
      var canvas_element = element[0];
      var ctx = element[0].getContext('2d');

      var offset = {x: 10, y: 25};
      var x = 10;
      var y = 10;
      var grid_size = 25;
      var canvas = {width: canvas_element.width, height: canvas_element.height, startY: (canvas_element.height - offset.y)};
      var _rs = {};
      var _rows = {};
      var tracklist = scope.release_data.tracks;
      var id = "";

      //Adds 0 infront of 1 digit number
      function minTwoDigits(n) {
        return (n < 10 ? '0' : '') + n;
      }

      function fillRowGradient(startX, startY, countY) {
        console.log("GRADIENT: " + startX + ", " + startY + ", " + countY);
        var y = startY;
        if(countY > 10) countY = 10;
        for(var i = 1; i <= countY; i++) {
          y -= grid_size;
          ctx.fillStyle = 'rgb(' + Math.floor(255 - 25.5*i) + ',' + Math.floor(25.5*i) + ',50)';
          ctx.fillRect(startX, y, grid_size, grid_size);
          ctx.stroke();
        }
      }

      function resetRow(row, fillY) {
        var fill = (fillY > 0) ? fillY : _rows[row].rating;
        console.log("FILL: ", fill);
        fillRowGradient(_rows[row].start, canvas.startY, fill);
        fillRow(_rows[row].start, canvas.startY - (fill * grid_size), (10 - fill));
      }

      function fillRow(startX, startY, countY, fill) {
        console.log("FILLROW: " + startX + ", " + startY + ", " + countY);
        var y = startY;
        ctx.fillStyle = "#FFF";
        for(var i = 1; i <= countY; i++) {
          y -= grid_size;
          ctx.fillRect(startX, y, grid_size, grid_size);
          ctx.stroke();
        }
      }

      function drawRow(startX, startY, countY) {
        var y = startY;
        for(var i = 1; i <= countY; i++) {
          y = (i * grid_size);
          ctx.rect(startX, y, grid_size, grid_size);
          ctx.stroke();
        }
      }

      //Draw initial grid
      for(var i = 1; i <= tracklist.length; i++) {
        x += grid_size;
        ctx.fillStyle = "#000";
        ctx.font = "bold 12px sans-serif";
        ctx.fillText(i, x + 10, (canvas.height - 12));
        drawRow(x, offset.y, 10, "#FFF");
        _rows[i] = {"start": x, "end": x + grid_size, "track": i, "rating": 0};
      }

      console.log(_rows);
      element.bind('mousedown', function(event) {
        console.log("SIZE: ", scope.release_data.tracks.length);
        _rows[row].rating = Math.floor((canvas.height - y) / grid_size);
        resetRow(row);
        console.log(_rows);
      });

      var row = 0, lastRow = 0;
      var fillY = 0, lastFillY = 0;

      function getRow(x, y) {
        for(var key in _rows) {
          if(x >= _rows[key].start && x < _rows[key].end) return key;
        }
        return 0;
      }

      element.bind('mousemove', function(event){
        x = event.offsetX;
        y = event.offsetY;
        lastRow = row;
        lastFillY = fillY;
        row = getRow(x, y);
        fillY = Math.floor((canvas.height - y) / grid_size);

        if(lastFillY !== fillY) resetRow(row, fillY);//fillRow((row * grid_size) + offset.x, (canvas.height - offset.y), 10, "#FFF");
        if(row > 0) resetRow(row, fillY);//fillRowGradient((row * grid_size) + offset.x, (canvas.height - offset.y), fillY);
        if(row !== lastRow) {
          resetRow(lastRow);
          //fillRow((lastRow * grid_size) + offset.x, (canvas.height - offset.y), 10, "#FFF");
        }
        console.log("FILLY: " + fillY + " LASTFILLY: " + lastFillY);
        console.log("ROW: " + row + " LASTROW: " + lastRow);
       // console.log("COORDS: " + event.offsetX + " , " + event.offsetY);
      });
      element.bind('mouseup', function(event){

      });
      // canvas reset
      function reset(){
       element[0].width = element[0].width;
      }
    }
  };
});
