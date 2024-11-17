<?php
//require modules;
require 'require/Modules.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attandance System location based</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2Xh8p7kp8B4VZWFonkjVvwfwmPT0A_Hw"></script>

</head>

<body>
  <section class="container">
    <div class='row'>
      <div class="col-md-12">
        <div class="mt-3">
          <h3><i class='fa fa-map-marker text-success'></i> Location Based Attandance</h3>
          <hr>
        </div>
      </div>

      <div class="col-md-4">
        <button id="get-location-btn" class="btn-sm btn btn-success">Get Location</button>
        <hr>
        <h6>My Location Co-Ordinates:</h6>
        <p>
          <span>
            Longitude : <span id='long'></span><br>
          </span>
          <span>
            Latitude : <span id='att'></span>
          </span>
        </p>
        <h6>Checking Location Co-ordinates:</h6>
        <p>
          <span>
            <span class="bold" id='name'>Searching Location...</span><br>
            <span id='address'>Searching address...</span><br>
          </span>
          <br>

          <span>
            Office Long: <span id='OfficeLong'></span>
          </span><br>
          <span>
            Office Lat: <span id='OfficeLat'></span>
          </span><br>
        </p>

        <hr>
        <h6>Distance Between office and My Location:</h6>
        <p>
          <span>
            Distance is:
            <span id='distance'></span> Km
          </span>
        </p>
        <h6>Status:</h6>
        <hr>
        <p>
          <span>
            <span id='status'></span>.
          </span>
        </p>
      </div>

      <div class="col-md-8">
        <h5>Live Location Caputuring</h5>
        <div id='map'></div>
      </div>

    </div>
  </section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#get-location-btn').click(function() {
        getLocation();
      });
    });

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function showPosition(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;


      //targeting location co-ordinates
      var OfficeLang = 77.3802343;
      var OfficeLat = 28.6271625;

      document.getElementById('long').innerHTML = longitude;
      document.getElementById('att').innerHTML = latitude;

      document.getElementById("OfficeLong").innerHTML = OfficeLang;
      document.getElementById("OfficeLat").innerHTML = OfficeLat;

      function initMap() {
        var map;
        map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: latitude,
            lng: longitude
          },
          zoom: 16
        });
        var marker = new google.maps.Marker({
          position: {
            lat: latitude,
            lng: longitude
          },
          map: map
        });
      }

      initMap();


      //get distance between two co-ordinates
      function deg2rad(deg) {
        return deg * (Math.PI / 180);
      }

      const R = 6371; // Radius of the earth in km
      const dLat = deg2rad(OfficeLat - latitude); // deg2rad() function converts degrees to radians
      const dLon = deg2rad(OfficeLang - longitude);
      const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(latitude)) * Math.cos(deg2rad(OfficeLat)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      const distance = R * c; // Distance in km

      //distance
      document.getElementById("distance").innerHTML = distance.toFixed(2);

      //send status
      if (distance >= 0.15) {
        // If the distance is greater than 10 meters (0.01 kilometers), display "You are not in the office."
        document.getElementById("status").innerHTML = "You are not in the office and " + distance.toFixed(2) + " km away from the office!";
      } else {
        // If the distance is 10 meters or less, display "You are in the office."
        document.getElementById("status").innerHTML = "You are in the office.";
      }

      //location name
      // Make a request to the Google Maps Geocoding API
      fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${OfficeLat},${OfficeLang}&key=AIzaSyC2Xh8p7kp8B4VZWFonkjVvwfwmPT0A_Hw`)
        .then(response => response.json())
        .then(data => {
          // Get the formatted address from the response
          const locationAddress = data.results[0].formatted_address;
          const result = data.results.find(place => place.geometry.location.lat === latitude && place.geometry.location.lng === longitude);

          let businessName;
          if (result) {
            businessName = result.name;
          } else {
            businessName = "Not Found!";
          }

          // Display the location name and address
          document.getElementById("name").innerHTML = businessName;
          document.getElementById("address").innerHTML = locationAddress;
        })
        .catch(error => {
          console.error("Error fetching location data:", error);
        });
    }
  </script>
</body>

</html>