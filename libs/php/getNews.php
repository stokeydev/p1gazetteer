<?php

include('config.php');

$executionStartTime = microtime(true);

$url='https://newsdata.io/api/1/news?apikey=' . $newsKey . '&country=' . $_REQUEST['param1'] . '&category=top&language=en';
$decode = curlNewsData($url);


function curlNewsData($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);

$result=curl_exec($ch);
curl_close($ch);

$decode = json_decode($result, true);
return $decode;
}

if ($decode['status'] == 'error') {
    $url='https://newsdata.io/api/1/news?apikey=' . $newsKey . '&q=' . $_REQUEST['param2'] . '&category=top&language=en';
    $decode = curlNewsData($url);
}

if ($decode['totalResults'] == 0) {
    $url='https://newsdata.io/api/1/news?apikey=' . $newsKey . '&category=top&language=en';
    $decode = curlNewsData($url);
}

$output['status']['code'] = "200";
$output['status']['name'] = "ok";
$output['status']['description'] = "success";
$output['status']['returnedIn'] = intval((microtime(true) - $executionStartTime) * 1000) . " ms";

$newsData = array();

$stories = $decode['results'];
for ($i=0; $i<sizeof($stories); $i++) {
    if (!$stories[$i]['image_url']) {
        array_push($newsData, array($stories[$i]['title'], $stories[$i]['link'],'./libs/css/news-blue.png'));
    } else {
    array_push($newsData, array($stories[$i]['title'], $stories[$i]['link'],$stories[$i]['image_url']));
}
}
$output['data'] = $newsData;


header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output);

?>
