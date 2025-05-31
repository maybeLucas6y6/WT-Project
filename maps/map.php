<?php
$googleMapsApiKey = 'no';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Google Map - Iași, Romania</title>
    <style>
        #map {
            height: 1000px;
            width: 100%;
        }
    </style>
</head>

<body>
    <h2>Google Map Centered on Iași, Romania</h2>
    <div id="map"></div>

    <script>
        function initMap() {
            var geocoder = new google.maps.Geocoder();
            var address = "Iasi, Romania";

            geocoder.geocode({ address: address }, function(results, status) {
                if (status === 'OK') {
                    var map = new google.maps.Map(document.getElementById('map'), {
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
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleMapsApiKey; ?>&callback=initMap">
        </script>
</body>

</html>