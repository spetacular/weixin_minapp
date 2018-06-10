<?php
$src = $_GET['url'];
//$src = 'https://pic.cnblogs.com/face/1100046/20170130212431.png';

if($src){
    $ch = curl_init($src);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
    $output = curl_exec($ch) ;
    header('Content-Type: image/jpeg');
    echo $output;
}else {
    header('Content-Type: image/jpeg');
    echo '';
}