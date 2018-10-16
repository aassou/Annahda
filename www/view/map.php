<?php
    include('../autoload.php');
    session_start();
    if ( isset($_SESSION['userMerlaTrav']) ) {
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 800px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <!--h3>My Google Maps Demo</h3-->
    <div id="map"></div>
    <script>
      function initMap() {
        var onda = {lat: 35.154559, lng: -2.919575};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: onda
        });
        //MarocInvest2AS14 Begin
        var MarocInvest2AS14 = {lat: 35.152129, lng: -2.914972};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 14</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS14 = new google.maps.Marker({
          position: MarocInvest2AS14,
          map: map,
          title: 'MarocInvest2AS 14'
        });
        markerMarocInvest2AS14.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS14);
        });
        infowindow.open(map, markerMarocInvest2AS14);
        //MarocInvest2AS14 End
        //MarocInvest2AS13 Begin
        var MarocInvest2AS13 = {lat: 35.150927, lng: -2.915648};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 13</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS13 = new google.maps.Marker({
          position: MarocInvest2AS13,
          map: map,
          title: 'MarocInvest2AS 13'
        });
        markerMarocInvest2AS13.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS13);
        });
        infowindow.open(map, markerMarocInvest2AS13);
        //MarocInvest2AS13 End
        //MarocInvest2AS12 Begin
        var MarocInvest2AS12 = {lat: 35.154559, lng: -2.919575};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 12</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS12 = new google.maps.Marker({
          position: MarocInvest2AS12,
          map: map,
          title: 'MarocInvest2AS 12'
        });
        markerMarocInvest2AS12.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS12);
        });
        infowindow.open(map, markerMarocInvest2AS12);
        //MarocInvest2AS12 End
        //MarocInvest2AS11 Begin
        var MarocInvest2AS11 = {lat: 35.154682, lng: -2.923877};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 11</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS11 = new google.maps.Marker({
          position: MarocInvest2AS11,
          map: map,
          title: 'MarocInvest2AS 11'
        });
        markerMarocInvest2AS11.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS11);
        });
        infowindow.open(map, markerMarocInvest2AS11);
        //MarocInvest2AS11 End
        //MarocInvest2AS10 Begin
        var MarocInvest2AS10 = {lat: 35.151752, lng: -2.917375};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 10</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS10 = new google.maps.Marker({
          position: MarocInvest2AS10,
          map: map,
          title: 'MarocInvest2AS 10'
        });
        markerMarocInvest2AS10.addListener('click', function() {
        infowindow.open(map, markerMarocInvest2AS10);
        });
        infowindow.open(map, markerMarocInvest2AS10);
        //MarocInvest2AS10 End
        //MarocInvest2AS9 Begin
        var MarocInvest2AS9 = {lat: 35.150585, lng: -2.915712};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 9</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS9 = new google.maps.Marker({
          position: MarocInvest2AS9,
          map: map,
          title: 'MarocInvest2AS 9'
        });
        markerMarocInvest2AS9.addListener('click', function() {
        infowindow.open(map, markerMarocInvest2AS9);
        });
        infowindow.open(map, markerMarocInvest2AS9);
        //MarocInvest2AS9 End
        //MarocInvest2AS8G Begin
        var MarocInvest2AS8G = {lat: 35.147585, lng: -2.917440};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 8/G</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS8G = new google.maps.Marker({
          position: MarocInvest2AS8G,
          map: map,
          title: 'MarocInvest2AS 8/G'
        });
        markerMarocInvest2AS8G.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS8G);
        });
        infowindow.open(map, markerMarocInvest2AS8G);
        //MarocInvest2AS8G End
        //MarocInvest2AS8S Begin
        var MarocInvest2AS8S = {lat: 35.147383, lng: -2.917419};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 8/S</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS8S = new google.maps.Marker({
          position: MarocInvest2AS8S,
          map: map,
          title: 'MarocInvest2AS 8/S'
        });
        markerMarocInvest2AS8S.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS8S);
        });
        infowindow.open(map, markerMarocInvest2AS8S);
        //MarocInvest2AS8S End
        //MarocInvest2AS7 Begin
        var MarocInvest2AS7 = {lat: 35.150997, lng: -2.916925};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 7</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS7 = new google.maps.Marker({
          position: MarocInvest2AS7,
          map: map,
          title: 'MarocInvest2AS 7'
        });
        markerMarocInvest2AS7.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS7);
        });
        infowindow.open(map, markerMarocInvest2AS7);
        //MarocInvest2AS7 End
        //MarocInvest2AS6 Begin
        var MarocInvest2AS6 = {lat: 35.150997, lng: -2.916925};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 6</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS6 = new google.maps.Marker({
          position: MarocInvest2AS6,
          map: map,
          title: 'MarocInvest2AS 6'
        });
        markerMarocInvest2AS6.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS6);
        });
        infowindow.open(map, markerMarocInvest2AS6);
        //MarocInvest2AS6 End
        //MarocInvest2AS5 Begin
        var MarocInvest2AS5 = {lat: 35.147356, lng: -2.916904};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 5</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS5 = new google.maps.Marker({
          position: MarocInvest2AS5,
          map: map,
          title: 'MarocInvest2AS 5'
        });
        markerMarocInvest2AS5.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS5);
        });
        infowindow.open(map, markerMarocInvest2AS5);
        //MarocInvest2AS5 End
        //MarocInvest2AS4 Begin
        var MarocInvest2AS4 = {lat: 35.147932, lng: -2.910765};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 4</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS4 = new google.maps.Marker({
          position: MarocInvest2AS4,
          map: map,
          title: 'MarocInvest2AS 4'
        });
        markerMarocInvest2AS4.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS4);
        });
        infowindow.open(map, markerMarocInvest2AS4);
        //MarocInvest2AS4 End
        //MarocInvest2AS2 Begin
        var MarocInvest2AS2 = {lat: 35.145818, lng: -2.916655};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 2</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS2 = new google.maps.Marker({
          position: MarocInvest2AS2,
          map: map,
          title: 'MarocInvest2AS 2'
        });
        markerMarocInvest2AS2.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS2);
        });
        infowindow.open(map, markerMarocInvest2AS2);
        //MarocInvest2AS2 End
        //MarocInvest2AS1 Begin
        var MarocInvest2AS1 = {lat: 35.146827, lng: -2.912439};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<p id="firstHeading" class="firstHeading"><strong>MarocInvest2AS 1</strong></p>'+
            '<div id="bodyContent">'+
            '</div>'+
            '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var markerMarocInvest2AS1 = new google.maps.Marker({
          position: MarocInvest2AS1,
          map: map,
          title: 'MarocInvest2AS 1'
        });
        markerMarocInvest2AS1.addListener('click', function() {
          infowindow.open(map, markerMarocInvest2AS1);
        });
        infowindow.open(map, markerMarocInvest2AS1);
        //MarocInvest2AS1 End
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPiRX_IPjs69eKkCxnkaSmqjEp_obZDRc&callback=initMap">
    </script>
  </body>
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>