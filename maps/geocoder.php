<!DOCTYPE html>
<html>
  <head>
    <title>Geocoding Service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>

      #map {
        height: 100%;
        width: 100%;
      }
      .maps {
        height: 400px;
        width: 100%;
      }
      .no-padding{
        padding: 0px !important; 
      }

      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

  </head>
  <body>
    <div class="col-md-12 maps no-padding">
      <div id="map"></div>
    </div>
    <br>
    <div class="container">
      <div class="row">
        <div class="card col-md-6 m-1">
          <div class="card-body pt-5">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Address" aria-label="Address" aria-describedby="button-addon2" id="address">
                <div class="input-group-append">
                  <button class="btn btn-outline-success" type="button" id="submit">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card col-md m-1">
          <div class="card-body pt-5">
            <div class="col-md-12">
              <label>Address : </label>
              <p id="text-address"></p>    

              <label>Latitude/Longitude : </label>
              <p id="text-latlang"></p>     

            </div>
          </div>
        </div>
      </div>
    </div>

   
    

    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
      var map           = null;
      var marker        = null;
      var $map          = document.getElementById('map');
      var $txtAddress   = document.getElementById('text-address');
      var $txtLatLang   = document.getElementById('text-latlang');
      var $btnSubmit    = document.getElementById('submit');
      var $inputAddress = document.getElementById('address');

      function handleInitGoogleMaps() {
        map = new google.maps.Map($map, {
          zoom: 8,
          center: {lat: -6.914744, lng: 107.609810}
        });

        var geocoder = new google.maps.Geocoder();

        $btnSubmit.addEventListener('click', function() {
          handleGeocoderMaps(geocoder, map);
        });

        $inputAddress.addEventListener('keyup', function(e){
            if (e.keyCode == 13) {
              $btnSubmit.focus();
              handleGeocoderMaps(geocoder, map);
            }
        });

      }

      function handleGeocoderMaps(geocoder, resultsMap) {
        
        var address = $inputAddress.value;

        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {

            resultsMap.setCenter(results[0].geometry.location);
            
            console.log(results[0]);
            
            $txtAddress.innerHTML = results[0].formatted_address;
            $txtLatLang.innerHTML = results[0].geometry.location;

            if (marker == null) {
              marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
              });
            }else{
              marker.setPosition(results[0].geometry.location);
            }


          } else {
            swal("Aww, Sorry!", "The address you were looking for was not found.", "error");
          }
        });
      }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH5XEIHSIkwimGdIy0p3W4AICN8-sU5zg&callback=handleInitGoogleMaps">
    </script>

  </body>
</html>