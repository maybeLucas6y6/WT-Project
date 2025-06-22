<!DOCTYPE html>
<html lang="en">

<head>
    <title>Google Map - Iași, Romania</title>
    <link rel="stylesheet" href="/views/mapView.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Real estate manager for people looking to buy and sell estates.">
</head>

<body>
    <form action="/auth/logout" method="post">
        <button type="submit">Logout</button>
    </form>

    <div id="big-wrapper">
        <h2>Real Estate Manager</h2>
        <label>
            <input type="checkbox" id="pollution-toggle"> Arata grad poluare.
        </label>
        <label>
            <input type="checkbox" id="heatmap-toggle"> Arata t.m.a.
        </label>
        <label>
            <input type="checkbox" id="favorite-toggle"> Filtreaza dupa favorite.
        </label>
        <div id="map"></div>

        <div id="form-wrapper">
            <div>
                <button id="form-button" class="fancy-button">Adauga oferta</button>
            </div>
            <form id="add-asset-form" autocomplete="off" style="display: none;">
                <label for="address">Adresa:</label> <br>
                <input type="text" id="address" name="address"> <br>

                <label for="description">Descriere:</label>
                <input type="text" id="description" name="description"> <br>

                <label for="price">Pret:</label>
                <input type="text" id="price" name="price"> <br>

                <label for="category">Categorie:</label>
                <select id="category" name="category">
                    <option value="Apartment">Apartment</option>
                    <option value="House">House</option>
                    <option value="Studio">Studio</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Land">Land</option>
                    <option value="Luxury">Luxury</option>
                    <option value="New Construction">New Construction</option>
                    <option value="Vacation Home">Vacation Home</option>
                    <option value="Office Space">Office Space</option>
                    <option value="Warehouse">Warehouse</option>
                </select> <br>

                <input type="submit" value="Adaugare oferta">
            </form>

            <div>
                <button id="filter-button" class="fancy-button">Filtreaza ofertele</button>
            </div>
            <form id="filter-form" autocomplete="off" style="display: none;">
                <label for="min-price">Minimum price:</label> <br>
                <input type="text" id="min-price" name="min-price"> <br>
                <label for="max-price">Maximum Price:</label>
                <input type="text" id="max-price" name="max-price"> <br>
                <input type="submit" value="Filtreaza!">
            </form>

            <div>
                <button id="nearby-button" class="fancy-button">Oferte in apropiere</button>
            </div>
            <form id="nearby-form" autocomplete="off" style="display: none;">
                <label for="nearby-address">Introdu adresa:</label> <br>
                <input type="text" id="nearby-address" name="nearby-address"> <br>
                <input type="submit" value="Filtreaza!">
            </form>

            <div>
                <button class="fancy-button" onclick="window.location.href='/documentation'">Documentatie</button>
            </div>

            <div>
                <button class="fancy-button" id="JSON-button">Export ca JSON</button>
            </div>

            <div>
                <button class="fancy-button" id="CSV-button">Export ca si CSV</button>
            </div>
        </div>


        <script src="views/mapView.js"></script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={$googleMapsApiKey}&libraries=visualization&callback=initMap">
        </script>


        <script>
            document.getElementById('form-button').addEventListener('click', function() {
                const form = document.getElementById('add-asset-form');
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' :
                    'none';
            });
            document.getElementById('filter-button').addEventListener('click', function() {
                const form = document.getElementById('filter-form');
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' :
                    'none';
            });
            document.getElementById('nearby-button').addEventListener('click', function() {
                const form = document.getElementById('nearby-form');
                form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' :
                    'none';
            });
        </script>
    </div>
</body>

</html>