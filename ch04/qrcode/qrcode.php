<?php
define('APPID', '请填写小程序APPID');
define('APPSECRET', '请填写小程序APPSECRET');
$path = isset($_POST['path']) ? $_POST['path'] : '';
if (empty($path)) {
    exit('Error:Please enter path');
}
$width = isset($_POST['width']) ? $_POST['width'] : 430;
$post_data = sprintf('{"path": "%s", "width": %d}', $path, $width);
$filename = './qrimg/' . md5($post_data) . '.png';
if (!file_exists($filename)) {
    $access_token = get_access_token();
    $url = sprintf('https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=%s', $access_token);
    $data = fetch_post($url, $post_data);
    $json_data = json_decode($data, true);
    if (isset($json_data['errcode'])) {//如果发生错误，输出错误信息结果
        exit('Error occurs when get qrcode:' . $json_data['errmsg']);
    }

    //二维码接口返回的是图片的二进制格式，所以应先保存为图片
    $fp = fopen($filename, 'w');
    fwrite($fp, $data);
    fclose($fp);
}


echo "<img src='{$filename}' />";

function get_access_token(){
    $url = sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s', APPID, APPSECRET);
    $data = file_get_contents($url);
    $data = json_decode($data, true);
    if (isset($data['access_token'])) {
        return $data['access_token'];
    } else {
        exit('Error occurs when get access_token:' . $data['errmsg']);
    }
}

function fetch_post($url, $query){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $query,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        exit("cURL Error #:" . $err);
    } else {
        return $response;
    }
}