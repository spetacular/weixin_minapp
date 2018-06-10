<?php
include './function.php';
$filename = './cache/blog_rss.html';
$response = '';
if (!file_exists($filename) || rand(0, 10) == 1) {
    $response = curl_get('http://wcf.open.cnblogs.com/blog/sitehome/recent/20');
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
echo xmltojson($response);