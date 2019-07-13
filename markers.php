<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
	
     <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
     <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
     <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    </script>
    <script>
		function initialize() {
        var latitude = 19.81,
            longitude = -99.04,
            radius = 8000, //how is this set up
            center = new google.maps.LatLng(latitude,longitude),
            bounds = new google.maps.Circle({center: center, radius: radius}).getBounds(),
            mapOptions = {
                center: center,
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false
            };

        var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        setMarkers(center, radius, map);
    }

    function setMarkers(center, radius, map) {
        var json = (function () { 
            var json = null; 
            $.ajax({ 
                'async': false, 
                'global': false, 
                'url': "js/clientes.json", 
                'dataType': "json", 
                'success': function (data) {
                     json = data; 
                 }
            });
            return json;
        })();

        var circle = new google.maps.Circle({
                strokeColor: '#000000',
                strokeOpacity: 0.25,
                strokeWeight: 1.0,
                fillColor: '#ffffff',
                fillOpacity: 0.1,
                clickable: false,
                map: map,
                center: center,
                radius: radius
            });
        var bounds = circle.getBounds();

        //loop between each of the json elements
        for (var i = 0, length = json.length; i < length; i++) {
            var data = json[i],
            latLng = new google.maps.LatLng(data.lat, data.lng); 



            if(bounds.contains(latLng)) {
                // Creating a marker and putting it on the map
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.content
                });
                infoBox(map, marker, data);
            }
        }

        circle.bindTo('center', marker, 'position');
    }

    function infoBox(map, marker, data) {
        var infoWindow = new google.maps.InfoWindow();
        // Attaching a click event to the current marker
        google.maps.event.addListener(marker, "click", function(e) {
            infoWindow.setContent(data.content);
            infoWindow.open(map, marker);
        });

        // Creating a closure to retain the correct data 
        // Note how I pass the current data in the loop into the closure (marker, data)
        (function(marker, data) {
          // Attaching a click event to the current marker
          google.maps.event.addListener(marker, "click", function(e) {
            infoWindow.setContent(data.content);
            infoWindow.open(map, marker);
          });
        })(marker, data);
    }

   google.maps.event.addDomListener(window, 'load', initialize);
	
	
	</script>
  </head>
  <body>
    <div id="map-canvas"/>
  </body>
</html>