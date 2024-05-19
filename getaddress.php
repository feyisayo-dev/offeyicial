<?php
header('Content-Type: application/json');

$lat = filter_var($_GET['lat'], FILTER_VALIDATE_FLOAT);
$lng = filter_var($_GET['lng'], FILTER_VALIDATE_FLOAT);

function getaddress($lat, $lng)
{
    $url = 'https://geocode.maps.co/reverse?lat=' . trim($lat) . '&lon=' . trim($lng) . '&api_key=65a86d5ee4463482591200gfm98fa46';
    $json = file_get_contents($url);

    $addressData = json_decode($json, true);

    if (isset($addressData['error'])) {
        return $addressData; 
    }

    $addressArray = [
        'place_id' => $addressData['osm_id'],
        'latitude' => $addressData['lat'],
        'longitude' => $addressData['lon'],
        'display_name' => $addressData['display_name'],
        'address' => [
            // 'road' => $addressData['address']['road'], 
            'village' => $addressData['address']['village'],
            'state' => $addressData['address']['state'],
            'ISO3166-2-lvl4' => $addressData['address']['ISO3166-2-lvl4'],
            'postcode' => $addressData['address']['postcode'],
            'country' => $addressData['address']['country'],
            'country_code' => $addressData['address']['country_code']
        ],
        'boundingbox' => $addressData['boundingbox']
    ];

    return $addressArray;
}

if ($lat === false || $lng === false) {
    echo json_encode(['error' => 'Invalid latitude or longitude']);
    exit();
}

$address = getaddress($lat, $lng);
echo json_encode($address); 
?>