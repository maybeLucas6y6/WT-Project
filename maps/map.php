<?php
$googleMapsApiKey = 'AIzaSyDQz3eIc4qVe1iNkZaehSEz94GhJRxkPP0';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Google Map - Iași, Romania</title>
    <style>
        #map {
            height: 800px;
            width: 100%;
        }
    </style>
</head>

<body>
    <h2>Google Map Centered on Iași, Romania</h2>
    <label>
  <input type="checkbox" id="pollution-toggle"> Show Pollution Layer
</label>
    <div id="map"></div>
    
    

    <script>
        let map;
        let pollutionCircles = [];
            
        function initMap() {
            var geocoder = new google.maps.Geocoder();
            var address = "Iasi, Romania";

            geocoder.geocode({ address: address }, function(results, status) {
                if (status === 'OK') {
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 13,
                        center: results[0].geometry.location
                    });

                    new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode failed: ' + status);
                }
            });

            document.getElementById("pollution-toggle").addEventListener("change", function () {
                if (this.checked) {
                    fetchPollutionData();
                } else {
                    clearPollutionLayer();
                }
            });

            function fetchPollutionData(){
                console.log("Fetching data...");

                const center = map.getCenter();
                const lat = center.lat();
                const lng = center.lng();

            console.log("Fetching pollution data for:", lat, lng);

                fetch(`pollution_proxy.php?lat=${lat}&lng=${lng}&radius=10000&limit=50`)  
                .then(res => res.json())
                .then(data => {
                    console.log("Pollution data:", data);
                    let results = data.results;
                    
                    results.forEach(entry => {
                        const sensor =  entry.sensors?.[2];
                        if(!sensor) return;

                        const sensorId = sensor.id;

                        fetch(`sensor_proxy.php?id=${sensorId}`)
                        .then(res => res.json())
                        .then(measurementData => {
                            const value = measurementData.results[0].value;

                            const color = getPollutionColor(value);
                            console.log("Sensor measurement:", measurementData);
                            const circle = new google.maps.Circle({
                                strokeColor: color,
                                strokeOpacity: 0.8,
                                strokeWeight: 1,
                                fillColor: color,
                                fillOpacity: 0.35,
                                map: map,
                                center: {lat: entry.coordinates.latitude, lng: entry.coordinates.longitude},
                                radius: 1800
                            })
                            
                            pollutionCircles.push(circle);

                        });


  
                    })

                })
                .catch(err => console.error("Error:", err));
            }

            function clearPollutionLayer(){
                pollutionCircles.forEach(circle => circle.setMap(null));
                pollutionCircles = [];
                console.log("Pollution data removed.");
            }

            function getPollutionColor(value) {
                if (value <= 12) return '#00e400';        // Good (green)
                else if (value <= 35.4) return '#ffff00'; // Moderate (yellow)
                else if (value <= 55.4) return '#ff7e00'; // Unhealthy for Sensitive Groups (orange)
                else if (value <= 150.4) return '#ff0000'; // Unhealthy (red)
                else if (value <= 250.4) return '#8f3f97'; // Very Unhealthy (purple)
                else return '#7e0023';                    // Hazardous (maroon)
            }

        }
        

    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleMapsApiKey; ?>&callback=initMap">
        </script>
</body>

</html>