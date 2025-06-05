<?php

class AssetView {
    private $asset;

    public function __construct() {

    }

    public function initAsset($asset){
        $this->asset = $asset;
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Asset Details</title>
            <link rel="stylesheet" href="/views/mapView.css">
        </head>
        <body>
            <div id="big-wrapper">
                <h1>Asset Details</h1>
                <p><strong>Address:</strong> <?= htmlspecialchars($this->asset['address']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($this->asset['description']) ?></p>
                <p><strong>Price:</strong> <?= htmlspecialchars($this->asset['price']) ?></p>
                
                <a href="/map" class="fancy-button">Inapoi catre harta</a>
                <div id="small-wrapper">
                    <button id="add-to-favorites-button" class="fancy-button" data-asset-id="<?= htmlspecialchars($this->asset['id']) ?>">Adaugati la favorite</button>
                    <button id="remove-from-favorites-button" class="fancy-button" data-asset-id="<?= htmlspecialchars($this->asset['id']) ?>">Stergeti din favorite</button>
                </div>
            </div>

            <script src="/views/assetView.js"></script>

        </body>
 
        </html>

        <?php
    }
    //Trebuie schimbat cu smarty
}
