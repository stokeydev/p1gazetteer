<?php

include('config.php');

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$executionStartTime = microtime(true);

$data = file_get_contents('./../../countryBorders.geo.json');
$decode = json_decode($data, true);


$countryData = array();
$countryArray = $decode["features"];

foreach ($countryArray as $country) {
    if ($country["properties"]["iso_a2"] == $_REQUEST['param1']) {
        $countryData = $country["geometry"]["coordinates"];
        break;
    }
}


$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
$output['data'] = $countryData;

header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output);

?>
