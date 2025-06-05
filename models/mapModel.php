<?php

class MapModel
{
    private $connection;
    private $apiKeyPollution = "d1b3886d56be0912467e900b41076df55892f7a3c3cb8fed6e6fcec0e93b091a";

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getPollutionData($lat, $lng, $radius, $limit)
    {
        $url = "https://api.openaq.org/v3/locations?coordinates={$lat},{$lng}&radius={$radius}&limit={$limit}";
        return $this->makeRequestPollution($url);
    }

    public function getSensorData($id)
    {
        $url = "https://api.openaq.org/v3/sensors/$id/days?limit=1";
        return $this->makeRequestPollution($url);
    }

    public function getTemperatureData($lat, $lng)
    {
        $url = "https://power.larc.nasa.gov/api/temporal/climatology/point?parameters=T2M&community=RE&longitude=$lng&latitude=$lat&format=JSON";
        return $this->makeRequest($url);
    }

    public function updateAssetPos($id, $lat, $lng){
        $sql = "SELECT update_asset_location($id, $lat, $lng)";

        $result = pg_query($this->connection, $sql);

        if ($result) {
            return (["ok" => "Insert succeded"]);
        } else {
            return (["error" => "Insert failed"]);
        }
    }

    public function filterAssets($min_value, $max_value) {
        $sql = "SELECT * from filter_assets_by_price($min_value, $max_value)";

        $result = pg_query($this->connection, $sql);

        if(!$result){
            return ["error"=> "failed"];
        } else{
            $assets = [];
            while ($row = pg_fetch_assoc($result)) {
                $assets[] = $row;
            }
            return $assets;
        }
    }

    public function fetchFavoriteAssets($id){
        $sql = "SELECT * FROM get_favorite_assets($id)";
        $result = pg_query($this->connection, $sql);

        if(!$result){
            return ["error"=> "failed"];
        } else{
            $assets = [];
            while ($row = pg_fetch_assoc($result)) {
                $assets[] = $row;
            }
            return $assets;
        }
    }

    public function fetchNearbyAssets($lat, $lng) {
        $sql = "SELECT * FROM get_assets_within_distance(1,$lat, $lng)";
        $result = pg_query($this->connection, $sql);
        if(!$result) {
            return ["error"=> "failed"];
        }
        else{
            $assets = [];
            while ($row = pg_fetch_assoc($result)) {
                $assets[] = $row;
            }
            return $assets;
        }
    }
    public function addAsset($description, $address, $price, $lat, $lng,  $id, $category)
    {
        $description = pg_escape_string($this->connection, urldecode($description));
        $address = pg_escape_string($this->connection, urldecode($address));
        $price = floatval($price);
        $lat = floatval($lat);
        $lng = floatval($lng);
        $category = pg_escape_string($this->connection, urldecode($category));
        $sql = "select * from add_asset_with_category('$description','$address',$price,$lat,$lng,$id,'$category')";
        $result = pg_query($this->connection, $sql);

        if (!$result) {
            return ["error" => "failed"];
        }
        $id = pg_fetch_row($result);
        return ["id" => $id[0]];
    }

    private function makeRequest($url)
    {
        $opts = [
            "http" => [
                "method" => "GET"
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        if ($response === FALSE) {
            return ['error' => 'Request failed'];
        }

        return json_decode($response, true);
    }

    private function makeRequestPollution($url)
    {

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "X-API-Key: {$this->apiKeyPollution}\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        if ($response === FALSE) {
            return ['error' => 'Request failed'];
        }

        return json_decode($response, true);
    }

    public function getAssets()
    {
        $sql = "SELECT * FROM assets";
        $result = pg_query($this->connection, $sql);

        if (!$result) {
            return ["error" => "failed"];
        }

        $assets = [];
        while ($row = pg_fetch_assoc($result)) {
            $assets[] = $row;
        }
        return $assets;
    }
}
