<?php 
$rawUrl = $_GET['video'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $rawUrl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$content = curl_exec($ch);
curl_close($ch);

preg_match("/(?<=source: ')(.*?)(?=')/",$content,$m);

$url = urldecode($m[0]);

$chars = str_split($url);

$fullUrl = "";

foreach ($chars as $char) {
    $c = ord($char) + 47;
    $b = $c > 126 ? $c - 94 : $c;
            
    $fullUrl = $fullUrl . chr($b);
}

$video = fopen($fullUrl, "rb");

foreach ($http_response_header AS $header) {
    header($header);
}

while (!feof($video)) {
    print (fgets($video));
}

fclose($video);

?>