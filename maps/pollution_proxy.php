<?php
// pollution-proxy.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Optional: adjust in production

$lat = isset($_GET['lat']) ? $_GET['lat'] : '35.14942';
$lng = isset($_GET['lng']) ? $_GET['lng'] : '136.90610';
$radius = isset($_GET['radius']) ? $_GET['radius'] : '10000';
$limit = isset($_GET['limit']) ? $_GET['limit'] : '100';

$apiKey = 'af8f7c1e20b6fc5ef42bde8834f8a7c174492b710040beaf5404f5f25cbbc46a'; // Replace with your real key

$url = "https://api.openaq.org/v3/locations?coordinates={$lat},{$lng}&radius={$radius}&limit={$limit}";

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "X-API-Key: $apiKey\r\n"
    ]
];

$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(["error" => "Unable to fetch data"]);
    exit;
}

echo $response;
