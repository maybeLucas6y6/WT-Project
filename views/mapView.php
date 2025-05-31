<?php


class MapView extends View
{
    private $googleMapsApiKey;

    public function __construct($googleMapsApiKey)
    {
        $this->googleMapsApiKey = $googleMapsApiKey;
    }

    public function render()
    {
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

        <script src="views/mapView.js"></script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->googleMapsApiKey; ?>&callback=initMap">
        </script>

        </body>
        </html>
        <?php
    }
}
