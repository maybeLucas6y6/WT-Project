<!DOCTYPE html>
<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Asset Details</title>
            <link rel="stylesheet" href="/views/mapView.css">
        </head>
        <body>
            <div id="big-wrapper">
                <h1>Asset Details</h1>
                <p><strong>Address:</strong> {$address} </p>
                <p><strong>Description:</strong> {$description}</p>
                <p><strong>Price:</strong> {$price}</p>
                
                <a href="/map" class="fancy-button">Inapoi catre harta</a>
                <div id="small-wrapper">
                    <button id="add-to-favorites-button" class="fancy-button" data-asset-id={$id}>Adaugati la favorite</button>
                    <button id="remove-from-favorites-button" class="fancy-button" data-asset-id={$id}>Stergeti din favorite</button>
                </div>
            </div>

            <script src="/views/assetView.js"></script>

        </body>
 
        </html>
