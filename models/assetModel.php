<?php

class assetModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }


    public function addFavorite($id, $user_id)
    {
        $sql = "INSERT INTO favorite_assets (user_id, asset_id) VALUES ($1,$2)";
        $result = @pg_query_params($this->connection, $sql, [$user_id, $id]);
        if (!$result) {
            $error = pg_last_error($this->connection);
            return ["error" => $error];
        } else {
            return ["success" => "succeded"];
        }
    }

    public function removeFavorite($id, $user_id)
    {
        $sql = "DELETE FROM favorite_assets WHERE $1 = asset_id AND $2 = user_id";
        $result = pg_query_params($this->connection, $sql, [$id, $user_id]);
        if (!$result) {
            return ["error" => "error"];
        } else {
            return ["success" => "succeded"];
        }
    }
    public function getAssetById($id)
    {
        $sql = "SELECT * FROM assets WHERE id = $1";

        $result = pg_query_params($this->connection, $sql, [$id]);
        $asset = pg_fetch_assoc($result);
        return $asset;
    }

    public function deleteAsset($id)
    {
        $sql = "DELETE FROM favorite_assets WHERE asset_id = $1";
        $result = pg_query_params($this->connection, $sql, [$id]);
        if (!$result) {
            return ["error" => pg_last_error($this->connection)];
        }

        $sql = "DELETE FROM asset_category WHERE asset_id = $1";
        $result = pg_query_params($this->connection, $sql, [$id]);
        if (!$result) {
            return ["error" => pg_last_error($this->connection)];
        }

        $sql = "DELETE FROM assets WHERE id = $1";
        $result = pg_query_params($this->connection, $sql, [$id]);

        if (!$result) {
            return ["error" => pg_last_error($this->connection)];
        }

        return ["success" => "Asset deleted successfully"];
    }
}
