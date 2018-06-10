<?php
include './function.php';
include './rss_php.php';
$filename = './cache/news_rss.html';
$response = '';
if (!file_exists($filename) || rand(0, 10) == 1) {
    $response = curl_get('http://feed.cnblogs.com/news/rss');
    if (!$response) {
        echo "cURL Error";
        exit(0);
    } else {
        if (is_writable($filename)) {
            file_put_contents($filename, $response);
        }
    }
} else {
    $response = file_get_contents($filename);
}
$rss = new rss_php();
$rss->loadRSS($response);
echo json_encode($rss->getRSS());