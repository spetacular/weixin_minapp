<?php
include './function.php';
$post_id = isset($_GET['id'])?intval($_GET['id']):exit('缺失id参数');
$response = curl_get('http://wcf.open.cnblogs.com/blog/post/body/' . $post_id);
if (!$response) {
    echo "cURL Error";
    exit(0);
}
$isMatched = preg_match('/<string>(.*?)<\/string>/ms', $response, $matches);
$text = strip_tags(htmlspecialchars_decode($matches[1]));
echo json_encode([$text]);