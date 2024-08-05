<?php

$executionStartTime = microtime(true);

$url='https://restcountries.com/v3.1/alpha?codes=' . $_REQUEST['param1'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);

$decode = json_decode($result, true);
$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";
$output['officialName'] = $decode['0']['name']['official'];
$output['currencies'] = $decode['0']['currencies'][$_REQUEST['param2']];
$output['languages'] = $decode['0']['languages'];
$output['demonym'] = $decode['0']['demonyms']['eng']['f'];
$output['landlocked'] = $decode['0']['landlocked'];
$output['flag'] = $decode['0']['flags']['png']; 

header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output);

?>
