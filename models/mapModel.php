<?php

class MapModel
{
    private $connection;
    private $apiKeyPollution = "nope";

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

    public function addAsset($description, $address, $price)
    {
        $description = pg_escape_string($this->connection, urldecode($description));
        $address = pg_escape_string($this->connection, urldecode($address));
        $price = floatval($price);
        $insertSql = "INSERT INTO assets (description, address, price) VALUES ('$description', '$address', $price)";
        $insertResult = pg_query($this->connection, $insertSql);

        if (!$insertResult) {
            return (["error" => "Insert failed"]);
        }

        $sql = "SELECT id FROM assets WHERE description = '$description' AND address = '$address' AND price = $price";
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
