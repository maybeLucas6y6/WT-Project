<?php

class assetModel {
    private $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getAssetById($id){
        $sql = "SELECT * FROM assets WHERE id = $id";

        $result = pg_query($this->connection, $sql);
        $asset = pg_fetch_assoc($result);
        return $asset;
    }
}