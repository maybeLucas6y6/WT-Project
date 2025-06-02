<?php

class AssetView {
    private $asset;

    public function __construct() {

    }

    public function initAsset($asset){
        $this->asset = $asset;
    }

    public function render() {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Asset Details</title></head><body>";
        echo "<h1>Asset Details</h1>";
        echo "<p><strong>Address:</strong> {$this->asset['address']}</p>";
        echo "<p><strong>Description:</strong> {$this->asset['description']}</p>";
        echo "<p><strong>Price:</strong> {$this->asset['price']}</p>";
        echo "<a href='/map'>Back to map</a>";
        echo "</body></html>";
    }
}
