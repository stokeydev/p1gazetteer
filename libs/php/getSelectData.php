<?php

include('config.php');

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$executionStartTime = microtime(true);

$data = file_get_contents('./../../countryBorders.geo.json');
$decode = json_decode($data, true);

$countryArray = $decode["features"];
$countrySelect = array();

foreach ($countryArray as $country) {
    array_push($countrySelect, array($country["properties"]["name"], $country["properties"]["iso_a2"]));
}

sort($countrySelect);

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
$output['data'] = $countrySelect;

header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output);

?>
