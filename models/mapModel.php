<?php

class MapModel
{
    private $connection;
    private $apiKeyPollution;

    public function __construct() {
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

    public function getTemperatureData($lat, $lng){
        $url = "https://power.larc.nasa.gov/api/temporal/climatology/point?parameters=T2M&community=RE&longitude=$lng&latitude=$lat&format=JSON";
        return $this->makeRequest($url);
    }

    public function addAsset($description, $address, $price){
        $description = pg_escape_string($this->connection, $description);
        $address = pg_escape_string($this->connection, $address);
        $price = floatval($price);
        $sql = "INSERT INTO assets (description, address, price) VALUES ('$description', '$address', $price)";
        $result = pg_query($this->connection, $sql);

        if(!$result) {
            return ["error" => "failed"];
        }
        else return ["ok" => "success"];
    }

    private function makeRequest($url){
        $opts = [
            "http" => [
                "method"=> "GET"
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context); 
        if($response === FALSE){
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

    public function getAssets(){
        $sql = "SELECT * FROM assets";
        $result = pg_query($this->connection, $sql);

        if(!$result) {
            return ["error" => "failed"];
        }

        $assets = [];
        while ($row = pg_fetch_assoc($result)) {
            $assets[] = $row;
        }
        return $assets;
    }
}
