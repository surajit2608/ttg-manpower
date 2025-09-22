<?php

namespace Module;

use Exception;
use GuzzleHttp\Client;
use WorkerAddress;

class Address
{

  public function curLatLon()
  {
    $url = "https://www.googleapis.com/geolocation/v1/geolocate?key=" . GOOGLE_API_KEY;

    $results = [];
    $client = new Client();
    try {
      $response = $client->post($url);
      $data = json_decode($response->getBody(), true);

      if (isset($data['location']['lat']) && isset($data['location']['lng'])) {
        $lat = $data['location']['lat'];
        $lon = $data['location']['lng'];

        $results = [$lat, $lon];
      }
    } catch (Exception $e) {
      $results = [];
    }
    return $results;
  }

  public function getLatLon($address)
  {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . GOOGLE_API_KEY;

    $results = [];
    $response = file_get_contents($url);
    $data = json_decode($response);

    if ($data->status === "OK") {
      $location = $data->results[0]->geometry->location;
      $lat = $location->lat;
      $lon = $location->lng;

      $results = [$lat, $lon];
    }

    return $results;
  }

  function haversineDistance($lat1, $lon1, $lat2, $lon2)
  {
    $earthRadius = 3959; // Radius of the Earth in miles (3959 for miles/6371 for kilometers)

    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    $latDiff = $lat2Rad - $lat1Rad;
    $lonDiff = $lon2Rad - $lon1Rad;

    $a = sin($latDiff / 2) * sin($latDiff / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($lonDiff / 2) * sin($lonDiff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c; // Distance in miles

    return $distance;
  }

  public function nearbyWorkerIds($targetLat, $targetLog, $maxDistance)
  {
    $workerIds = [];
    $addresses = WorkerAddress::get();
    foreach ($addresses as $address) {
      $address = deepClone($address);
      if (!$address->latitude || !$address->longitude) continue;

      $distance = $this->haversineDistance($targetLat, $targetLog, $address->latitude, $address->longitude);
      if ($distance <= $maxDistance) {
        $workerIds[$address->worker_id] = round($distance, 2);
      }
    }

    return $workerIds;
  }
}
