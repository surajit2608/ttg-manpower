<?php 


$apiUrl = "https://www.googleapis.com/geolocation/v1/geolocate?key=".GOOGLE_API_KEY;

$client = new GuzzleHttp\Client();

try {
    $response = $client->post($apiUrl);
    $data = json_decode($response->getBody(), true);

    if (isset($data['location']['lat']) && isset($data['location']['lng'])) {
        $latitude = $data['location']['lat'];
        $longitude = $data['location']['lng'];

        echo "Current Latitude: $latitude<br>";
        echo "Current Longitude: $longitude";
    } else {
        echo "Unable to fetch current location.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}