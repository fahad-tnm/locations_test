<!DOCTYPE html>
<html>
  <head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script>
        function getdata(){
         

   
}</script>
    <title>Places Search Box</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width: 100%;
        height:550px;
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
        width: 345px;
      }
    </style>
  </head>
  <body function onload=getdata();>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <center>
    <div><a href="./addlocation.php"><h6>Insert Location</h6></a></div>
   
    </center><script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
        const map = new google.maps.Map(
              document.getElementById('map'),
              {
                  center: {
                      lat: 56.1304,
                      lng: 106.3468
                  },
                  zoom: 7
              }
          );
          var locations=[]
          $.ajax({
       url: "getdata.php",
       type: "post",
       data: {value:""} ,
       success: function (response) {
        var obj = jQuery.parseJSON (response);
      
        console.log(obj);  

        obj.forEach((yo) => {
            var latlng = {lat:parseFloat(yo.lat),lng:parseInt(yo.lng)};
            locations.push(latlng);
            var latlng
            ;
          });
          var marker;
          marker=  obj.forEach((points) => {

            console.log(points);
             latlng = {lat:parseFloat(points.lat),lng:parseInt(points.lng)};
       
              new google.maps.Marker({
                  position: latlng,
                  map: map
              }).addListener('click', function() {
        new google.maps.InfoWindow({
          content: '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h5>' +  points.Address + '</h5>' +
            '<div id="bodyContent">' +
            '</div>' +
            '</div>'
        }).open(map, this);

        markers.push(marker);
      });
 
          });
          console.log(locations);
        // You will get response from your PHP page (what you echo or print)
       },
       error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
       }
   });

        // var locations = [
        //       {lat: 46.233226, lng: 6.055737},
        //       {lat: 46.2278, lng: 6.0510},
        //       {lat: 46.23336, lng: 6.0471}
        //   ]
        // var uluru = {lat: 53.000000, lng:-60.000000};
        
// var map = new google.maps.Map(document.getElementById('map'), {
//   zoom: 4,
//   center: uluru
// });
// var marker = new google.maps.Marker({
//   position: uluru,
//   map: map
// });
        // var map = new google.maps.Map(document.getElementById('map'), {
        //   center: {lat: -33.8688, lng: 151.2195},
        //   zoom: 13,
        //   mapTypeId: 'roadmap'
        // });

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
//             var locations = [
//     ['Los Angeles', 34.052235, -118.243683],
//     ['Santa Monica', 34.024212, -118.496475],
//     ['Redondo Beach', 33.849182, -118.388405],
//     ['Newport Beach', 33.628342, -117.927933],
//     ['Long Beach', 33.770050, -118.193739]
//   ];
// var infowindow =  new google.maps.InfoWindow({});
// var marker, count;
// for (count = 0; count < locations.length; count++) {
//     marker = new google.maps.Marker({
//       position: new google.maps.LatLng(locations[count][1], locations[count][2]),
//       map: map,
//       title: locations[count][0]
//     });
// google.maps.event.addListener(marker, 'click', (function (marker, count) {
//       return function () {
//         infowindow.setContent(locations[count][0]);
//         infowindow.open(map, marker);
//       }
//     })(marker, count));
//   }



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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhkEJfrhZNEH_npNwl7PHsX76nHFEq7DU&libraries=places&callback=initAutocomplete"
         async defer></script>
  </body>
</html>