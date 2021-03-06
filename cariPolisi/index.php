<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CariPolisi</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mediku2.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css" />
    <style>
		::-webkit-scrollbar {
			width: 12px;
		}
		 
		::-webkit-scrollbar-track {
			-webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.3); 
			border-radius: 10px;
		}
		 
		::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: none; 
			background-color: #dddddd;
		}
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .controls {
            margin-top: 10px;
            border: 2px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
			background-color: #fff;
			font-family: Roboto;
			font-size: 16px;
			font-weight: 500;
			color: #0277BD !important;
			text-overflow: ellipsis;
			width: 40vw;
			height: 50px;
			margin: 5vw 15vw;
        }
        
        #pac-input:hover {
        	height: 50px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
			color: #4d90fe;
        }
		a, a:link, a:visited {
			color: #4d90fe;
			text-decoration: none;
			display: inline-block;
		}
        #target {
            width: 345px;
        }
		.navbar {
			background-color: #fff !important;
			height: 100px;
			box-shadow: 5px 5px 5px #dddddd;
		}
		.btn-danger, .btn-danger:hover{
			font-family: Roboto;
            font-size: 14px;
            font-weight: 500;
			background-color: #ffce00 !Important;
			border-radius: 0px;
			color: #fff;
			margin-right: 30px;
		}
		.btn-info, .btn-info:hover{
			font-family: Roboto;
            font-size: 14px;
            font-weight: 500;
			background-color: #B2EBF2 !important;
			border-radius: 0px;
			color: #fff;
		}
		
		.home {
			max-width: 90vw;
			max-height: 80vh;
			margin-left: 5vw;
			margin-top: 18vh;
		}
		
		#dvPanel {
			background-color: #fff;
			z-index: 10;
			position: absolute;
			right: 0;
			top: 0;
			float: right;
			width: 30%;
			overflow-y: scroll;
			height: 100%;
			padding: 20px;
		}
		.adp, .adp table {
			font-family: roboto;
			font-weight: 300;
			font-size: 13px;
			color: #2C2C2C;
			border: none;
		}
		.adp-summary {
			padding: 1em 1em;
			text-align: center;
			font-weight: 600;
			font-size: 15px;
		}
		table tbody tr:nth-child(2n + 1) {
			border: none;
		}
		img.adp-marker {
		display:none;
		}
		
    </style>
</head>
<body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <div class="container">
        <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header col-md-12">
                    <div class="col-md-4">
                        <label style="font-size:30px"><a href="index.php"><img src="assets/logo2.png" style="height: 40px"/> CariPolisi<br><p style="font-family:roboto;font-size:12px;color:#333; font-weight:500;"> Sarana Pencarian Polisi Kota Depok </p></a> </label>                            
					</div>                     
					
                    <div class="col-md-8" id="kanan">
						<button class='btn-danger' onclick='toClosest()'>Panic Button</button>
                        <button class='btn-info' onclick='getData()'>Cari Disekitar Saya</button>                      
                    </div>

                </div>

            </div>
        </nav>

    </div>
    <div class="home">
     
            <div id="search-box">
                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
            </div>
      

        <div id="map">                
        </div>

        <div id="side"> 
            <div id="dvPanel">                
            </div>                
        </div>
    </div>
    <script>
        var markers = [];
        var global;
        var startLat;
        var startLong;
        var map;
        var tmp;
        var radius = 4;
        function initAutocomplete() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -6.4025, lng: 106.7942},
                zoom: 16,
                mapTypeId: 'roadmap'
            });
            var opt = {minZoom: 14, maxZoom: 17};
            map.setOptions(opt);
            var infoWindow = new google.maps.InfoWindow({map: map});
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    global = position;
                    startLat = position.coords.latitude;
                    startLong = position.coords.longitude;
                    var icons = 'assets/pin64n.png';
                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Your Location');
                    map.setCenter(pos);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: pos,
                        icon: icons,
                    });
                }, function () {
                    /*handleLocationError(true, infoWindow, map.getCenter());*/
                });
            } else {
                    // Browser doesn't support Geolocation
                    /*handleLocationError(false, infoWindow, map.getCenter());*/
                }

//               
                // Create the search box and link it to the UI element.
                var input = document.getElementById('pac-input');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function () {
                    searchBox.setBounds(map.getBounds());
                });

                var markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener('places_changed', function () {
                    var places = searchBox.getPlaces();
                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function (marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function (place) {
                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        startLat = place.geometry.location.lat();
                        startLong = place.geometry.location.lng();
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
                            icon: iconstart,
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

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            }

            function directionFunction(lat, long) {
                var iconstart = 'assets/placeholder.png';
                var iconfinish = 'assets/police.png';
                var infoWindow = new google.maps.InfoWindow({map: map});

                var pointA = new google.maps.LatLng(startLat, startLong),
                pointB = new google.maps.LatLng(lat, long),
                myOptions = {
                    zoom: 15,
                    center: pointA
                },
                map = new google.maps.Map(document.getElementById('map'), myOptions),
                        // Instantiate a directions service.
                        directionsService = new google.maps.DirectionsService,
                        directionsDisplay = new google.maps.DirectionsRenderer({
                            map: map
                        }),
                        markerA = new google.maps.Marker({
                            position: pointA,
                            title: "Your Location",
                            map: map,
                            icon: iconstart
                        }),
                        markerB = new google.maps.Marker({
                            position: pointB,
                            title: "Destination",
                            map: map,
                            icon: iconfinish
                        });

                        var opt = {minZoom: 14, maxZoom: 17};
                        map.setOptions(opt);
                //directionsDisplay.setMap(map);                
                var string = "https://maps.googleapis.com/maps/api/directions/json?origin=" + startLat + "," + startLong + "&destination=" + lat + "," + long + "&key=AIzaSyDnx6V7Xv10H-bjBbjmMRyldc2qq7x72NQ";

                $.getJSON(string, function (data) {
                    tmp = data;
                });

                // get route from A to B
                calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
                showDiv()
            }

            function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
                directionsDisplay.setPanel(document.getElementById('dvPanel'));
                directionsService.route({
                    origin: pointA,
                    destination: pointB,
                    travelMode: google.maps.TravelMode.DRIVING
                }, function (response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                        var distance = tmp.routes[0].legs[0].distance.text;
                        var duration = tmp.routes[0].legs[0].duration.text;
                        //console.log(distance, duration)
                        var dvDistance = document.getElementById("dvDistance");
                        dvDistance.innerHTML += "<div style='width:100%;background-color:white;font-size: 20px;padding:10px;text-align:center;'>Distance : " + distance + "<br>Duration : " + duration + "<br><br><a href='map.php' class='btn btn-primary'>Exit Direction Mode</a></div>";
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });

            }

            function showDiv() {
                var x = document.getElementById("side");
                var y = document.getElementById("dvDistance");
                x.style.visibility = "visible";
                y.style.visibility = "visible";
            }
			
			function toClosest(){
				deleteMarkers();
				$.getJSON("polisi.json", function (json){
					var i = 0;
					var tempDis = getDistance(json[0].geometry.lat, json[0].geometry.lng, startLat,startLong);
					var geoLat = 0;
					var geoLng = 0;
					for (var key in json){
						 var distance = getDistance(json[key].geometry.lat, json[key].geometry.lng, startLat,startLong);
						 if (distance < tempDis){
							 tempDis = distance;
							 geoLat = json[key].geometry.lat;
							 geoLng = json[key].geometry.lng;
						 }
					}
					directionFunction(geoLat,geoLng);
				});
			}

            function getData() {
                deleteMarkers();
                markers = [];                
                var count = 0;
                $.getJSON("polisi.json", function (json) {
                    var i = 0;
                    for (var key in json) {
                        if (json.hasOwnProperty(key)) {
                            var icons = 'assets/police.png';
                            var geoLat = json[key].geometry.lat;
                            var geoLng = json[key].geometry.lng;
                            var distance = Math.round(getDistance(geoLat, geoLng, startLat, startLong)).toFixed(2);                            
                            var content =
                            "<div style='width:280px;'><h4>" + json[key].properties.Name + "</h4>\n\
                            <p>" + json[key].properties.description + "</p><p style='text-align:center;color:grey'><h3 style='text-align:center;margin-top:-10px'>+- "+distance+" km</h3><p style='text-align:center'><button class='btn btn-primary' onclick='directionFunction(" + geoLat + "," + geoLng + ")'>Direction</button></p>";

                            var infowindow = new google.maps.InfoWindow()
                            infowindow.open();                            
                            if (distance < radius) {
                                var marker = new google.maps.Marker({
                                    map: map,
                                    position: new google.maps.LatLng(json[key].geometry.lat, json[key].geometry.lng),
                                    icon: icons,
                                });
                                markers.push(marker);
                                count += 1;
                                google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) {
                                    return function () {
                                        infowindow.setContent(content);
                                        infowindow.open(map, marker);
                                    };
                                })(marker, content, infowindow));
                            }
                        }
                    }
                    if (count < 1) {
                        alert("Tidak Ditemukan Kantor Polisi Terdekat");
                    } else {
                        alert("Ditemukan " + count + " Kantor Polisi di Sekitar Anda")
                    }                    
                });
                deleteMarkers();
            }

            function clearMarkers() {
                setMapOnAll(null);
            }

            function deleteMarkers() {
                clearMarkers();
                markers = [];
            }

            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                  markers[i].setMap(map);
              }
          }

          function getDistance(p1, p2, p3, p4) {
            var R = 6378137;
            //console.log(p1, p2, p3, p4);
            var dLat = rad(p1 - p3);
            var dLong = rad(p2 - p4);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad(p1)) * Math.cos(rad(p3)) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = (R * c) / 1000;;
                //console.log(a, c, d);
                return d;
            }

            var rad = function (x) {
                return x * Math.PI / 180;
            };

        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnx6V7Xv10H-bjBbjmMRyldc2qq7x72NQ&libraries=places&callback=initAutocomplete"
        async defer></script> 

    </body>

    </html>