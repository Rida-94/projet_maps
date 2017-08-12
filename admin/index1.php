<?php
session_start();
if(empty($_SESSION['admin'])) {
	header("Location: index.php");
}
if(!empty($_POST)){
  extract($_POST);
$ville1 = $_POST['ville1'];
$ville2 = $_POST['ville2'];  
require('../id_connexion.php');

$req1 = $bdd->query("select latitude,longitude from map where ville = '$ville1'");
while($var1= $req1->fetch())
{
	$lat1=$var1['latitude'];
	$long1=$var1['longitude'];
}


$req2 = $bdd->query("select latitude,longitude from map where ville = '$ville2'");
while($var2= $req2->fetch())
{
	$lat2=$var2['latitude'];
	$long2=$var2['longitude'];
}

$req1->closeCursor();
$req2->closeCursor();

}
?>
<script>
function initialize(){
	var ver1 = <?php echo $lat1;?>;
	var ver2 = <?php echo $long1;?>;
	var ver3 = <?php echo $lat2;?>;
	var ver4 = <?php echo $long2 ;?>;
	var mapOptions={
		zoom: 6, // 0 à 21
		center: new google.maps.LatLng(47,2), // centre de la carte
		mapTypeId: google.maps.MapTypeId.ROADMAP, // ROADMAP, SATELLITE, HYBRID, TERRAIN
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	var myLatLng = new google.maps.LatLng(ver1,ver2);
	var marker = new google.maps.Marker ({
		position: myLatLng,
		map: map,
		titre: "Auriac-sur-vendinelle"
	});

	var myLatLng2 = new google.maps.LatLng(ver3,ver4);
	var marker2 = new google.maps.Marker ({
		position: myLatLng2,
		map: map,
		titre: "Castres"
	});

	//trajet 1
	var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer({
		'map': map
	});

	var request = {
		origin: myLatLng,
		destination: myLatLng2,
		travelMode: google.maps.DirectionsTravelMode.DRIVING,
		unitSystem: google.maps.DirectionsUnitSystem.METRIC
	};

	directionsService.route(request, function(response, status){
		if(status == google.maps.DirectionsStatus.OK){
			directionsDisplay.setDirections(response);
			directionsDisplay.suppressMarkers = false;
			directionsDisplay.setOptions({
				polylineOptions: {strokeColor: '#008000'},
				preserveViewport: false
			});
		}
	});

	//trajet 2
	var directionsService2 = new google.maps.DirectionsService();
	var directionsDisplay2 = new google.maps.DirectionsRenderer({
		'map': map
	});

	var request2 = {
		origin: myLatLng,
		destination: myLatLng2,
		travelMode: google.maps.DirectionsTravelMode.BICYCLING,
		unitSystem: google.maps.DirectionsUnitSystem.METRIC
	};

	directionsService2.route(request2, function(response, status){
		if(status == google.maps.DirectionsStatus.OK){
			directionsDisplay2.setDirections(response);
			directionsDisplay2.suppressMarkers = false;
			directionsDisplay2.setOptions({
				polylineOptions: {strokeColor: '#00FF00'},
				preserveViewport: true
			});
		}
	});
}
</script>






<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<title>Google Maps API : créer des trajets</title>
		<link rel="stylesheet" href="css/style.css" />
		<!--script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script-->
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYkmljuL0CQFjetIgVhKAO8_Gg9nW3amg&callback=initMap"
        type="text/javascript"></script>
		
	</head>

	<body onload="initialize()">
		<div id="map_canvas"></div>
	</body>
</html>
