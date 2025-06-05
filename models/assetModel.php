<?php

class assetModel {
    private $connection;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }


    public function addFavorite($id, $user_id) {
        $sql = "INSERT INTO favorite_assets (user_id, asset_id) VALUES ($user_id,$id)";
        $result = @pg_query($this->connection, $sql);
         if(!$result) {
            $error = pg_last_error($this->connection);
            return ["error"=> $error];
        }
        else{
            return ["success"=> "succeded"];
        }
    }

    public function removeFavorite($id, $user_id) {
        $sql = "DELETE FROM favorite_assets WHERE $id = asset_id AND $user_id = user_id";
        $result = pg_query($this->connection, $sql);
         if(!$result) {
            return ["error"=> "error"];
        }
        else{
            return ["success"=> "succeded"];
        }
    }
    public function getAssetById($id){
        $sql = "SELECT * FROM assets WHERE id = $id";

        $result = pg_query($this->connection, $sql);
        $asset = pg_fetch_assoc($result);
        return $asset;
    }
}