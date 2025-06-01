<?php


class MapModel
{
    private $connection;
    private $apiKey = 'af8f7c1e20b6fc5ef42bde8834f8a7c174492b710040beaf5404f5f25cbbc46a';
    //self explanatory, request-uri in php normale


    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }
    public function getPollutionData($lat, $lng, $radius, $limit)
    {
        $url = "https://api.openaq.org/v3/locations?coordinates={$lat},{$lng}&radius={$radius}&limit={$limit}";
        return $this->makeRequest($url);
    }

    public function getSensorData($id)
    {
        $url = "https://api.openaq.org/v3/sensors/$id/days?limit=1";
        return $this->makeRequest($url);
    }

    private function makeRequest($url)
    {

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "X-API-Key: {$this->apiKey}\r\n"
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
