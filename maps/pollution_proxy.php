<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$lat = $_GET['lat'] ?? '47.1585';
$lng = $_GET['lng'] ?? '27.6014';
$radius = $_GET['radius'] ?? '10000';
$limit = $_GET['limit'] ?? '50';

$apiKey = 'af8f7c1e20b6fc5ef42bde8834f8a7c174492b710040beaf5404f5f25cbbc46a';

// Get locations
$locationsUrl = "https://api.openaq.org/v3/locations?coordinates={$lat},{$lng}&radius={$radius}&limit={$limit}";
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "X-API-Key: $apiKey\r\n"
    ]
];
$context = stream_context_create($opts);
$response = file_get_contents($locationsUrl, false, $context);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch locations"]);
    exit;
}

$locations = json_decode($response, true);
$results = $locations['results'] ?? [];

$finalResults = [];

foreach ($results as $location) {
    if (!isset($location['sensors'][2])) continue; // Skip if sensor index 2 doesn't exist

    $sensor = $location['sensors'][2];
    $sensorId = $sensor['id'];

    // Fetch sensor data (latest daily avg)
    $sensorUrl = "https://api.openaq.org/v3/sensors/{$sensorId}/days?limit=1";
    $sensorResponse = file_get_contents($sensorUrl, false, $context);
    if ($sensorResponse === FALSE) continue;

    $sensorData = json_decode($sensorResponse, true);
    $sensorValue = $sensorData['results'][0]['value'] ?? null;

    if ($sensorValue === null) continue;

    $finalResults[] = [
        'latitude' => $location['coordinates']['latitude'],
        'longitude' => $location['coordinates']['longitude'],
        'value' => $sensorValue
    ];
}

echo json_encode(['results' => $finalResults]);
