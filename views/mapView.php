<?php


class MapView extends View
{
    private $googleMapsApiKey = 'nope';

    public function __construct() {}

    public function render($args)
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

                label {
                    display: flex;
                    justify-content: center;
                }

                form {
                    display: flex;
                    justify-content: center;
                }

                h2 {
                    display: flex;
                    justify-content: center;
                }
            </style>
        </head>

        <body>
            <h2>Real Estate Manager</h2>
            <label>
                <input type="checkbox" id="pollution-toggle"> Show Pollution Layer
            </label>
            <label>
                <input type="checkbox" id="heatmap-toggle"> Show Temperature Layer
            </label>
            <form id="add-asset-form" autocomplete="off">
                <label for="address">Adresa:</label> <br>
                <input type="text" id="address" name="address"> <br>
                <label for="description">Descriere:</label>
                <input type="text" id="description" name="description"> <br>
                <label for="price">Pret:</label>
                <input type="text" id="price" name="price"> <br>
                <input type="submit" value="Adaugare oferta">
            </form>
            <div id="map"></div>

            <script src="views/mapView.js"></script>
            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->googleMapsApiKey; ?>&libraries=visualization&callback=initMap">
            </script>

        </body>

        </html>
<?php
    }
}
