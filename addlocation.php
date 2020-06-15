<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <style>
       #map{
           height: 500px;
           width: 100% ;
       } 

 </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="map"></div>
<div id="map"></div>
<script type="text/javascript" src="index.js"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhkEJfrhZNEH_npNwl7PHsX76nHFEq7DU&callback&callback=initMap">
</script>



</script>
</body>
</html> -->
<!DOCTYPE html>
<html>
  <head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Places Search Box</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width: 100%;
        height:550px
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 100%;
        
      }
      .waves-light{
        margin-bottom: 25px;
      }
    </style>
  </head>
  <body>
      <center>
        
      <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
          <form action="location.php" method="POST">
          <div><a href="http://localhost/anr-mobile/"><h6>Click here to see locations</h6></a></div>
    <div class="row">
    <div class="input-field col s6">
      <input name="address" value="" id="property_address" type="text" class="validate">
      <label class="active" for="property_address">Property Address</label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s6">
      <input name="title" value="" id="property_title" type="text" class="validate">
      <label class="active" for="property_title">property Title"</label>
    </div>
  </div>
  <div class="row">
  
      <div class="row">
        <div class="input-field col s12">
          <textarea name="description" id="textarea1" class="materialize-textarea"></textarea>
          <label for="yo">Describe more about your property</label>
        </div>
      </div>
      <input type="hidden" id="lat" name="lat" value="">
      <input type="hidden" id="lng" name="lng" value="">
        <input type="hidden" id="addressback" name="addressback" value="">
  </div>
  <button class="btn waves-effect waves-light" type="submit" name="submit">Submit
    <i class="material-icons right">send</i>
  </button>
  </form>
  </center>
    <script>

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 56.1304, lng: 106.3468},
          zoom: 7,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          var address = document.getElementById('pac-input').value;
          document.getElementById('property_address').focus();
          var displat_address = document.getElementById('property_address');
      
          displat_address.value=address;
          document.getElementById('property_address').disabled=true;
          document.getElementById('lat').value=places[0].geometry.location.lat();
          document.getElementById('lng').value=places[0].geometry.location.lng();
          document.getElementById('addressback').value=address;
          var lat =places[0].geometry.location.lat();
         var lng =places[0].geometry.location.lng();
         console.log(lat+" "+lng);
         
          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhkEJfrhZNEH_npNwl7PHsX76nHFEq7DU&callback&libraries=places&callback=initAutocomplete"
         async defer></script>
  </body>
</html>