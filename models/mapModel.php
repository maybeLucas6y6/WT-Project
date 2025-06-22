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
        $sql = "SELECT update_asset_location($1, $2, $3)";
        $result = pg_query_params($this->connection, $sql, [$id, $lat, $lng]);

        if ($result) {
            return (["ok" => "Insert succeded"]);
        } else {
            return (["error" => "Insert failed"]);
        }
    }

    public function filterAssets($min_value, $max_value) {
        $sql = "SELECT * from filter_assets_by_price($1, $2)";

        $result = pg_query_params($this->connection, $sql, [$min_value, $max_value]);

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
        $sql = "SELECT * FROM get_favorite_assets($1)";
        $result = pg_query_params($this->connection, $sql, [$id]);

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
        $sql = "SELECT * FROM get_assets_within_distance(1,$1, $2)";
        $result = pg_query_params($this->connection, $sql, [$lat, $lng]);
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
        $description = urldecode($description);
        $address = urldecode($address);
        $price = floatval($price);
        $lat = floatval($lat);
        $lng = floatval($lng);
        $category = urldecode($category);
        $sql = "SELECT * FROM add_asset_with_category($1,$2,$3,$4,$5,$6,$7)";
        $result = pg_query_params($this->connection, $sql, [$description, $address, $price, $lat, $lng, $id, $category]);

        if (!$result) {
            return ["error" => "failed"];
        }
        $id = pg_fetch_row($result);
        return ["id" => $id[0]];
    }

    public function exportAssetsJSON(){
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="export.json"');

        $sql = "SELECT * FROM assets";
        $result = pg_query($this->connection, $sql);

        if (!$result) {
            return ["error" => "failed"];
        }

        $assets = [];
        while ($row = pg_fetch_assoc($result)) {
            $assets[] = $row;
        }
        echo json_encode($assets, JSON_PRETTY_PRINT);
    }

    public function exportAssetsCSV(){
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=export.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['id', 'address', 'description', 'price', 'lat', 'long', 'user_id']);

        $sql = "SELECT * FROM assets";
        $result = pg_query($this->connection, $sql);

        while ($row = pg_fetch_assoc($result)) {
            fputcsv($output, $row);
        }

        fclose($output);
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
