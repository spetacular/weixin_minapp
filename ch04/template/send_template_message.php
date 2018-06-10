<?php
 $access_token = 'YourAccessToken';
 $touser = "OPENID";
 $template_id = "TEMPLATEID";
 $form_id = "formID";
 $data = '{
  "touser": "'.$touser.'",  
  "template_id": "'.$template_id.'", 
  "page": "index",          
  "form_id": "'.$form_id.'",         
  "data": {
      "keyword1": {
          "value": "339208499", 
          "color": "#173177"
      }, 
      "keyword2": {
          "value": "2015年01月05日 12:30", 
          "color": "#173177"
      }, 
      "keyword3": {
          "value": "粤海喜来登酒店", 
          "color": "#173177"
      } , 
      "keyword4": {
          "value": "广州市天河区天河路208号", 
          "color": "#173177"
      } 
  },
  "emphasis_keyword": "keyword1.DATA" 
}
 ';

 $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
 $retjson = curl_post($url, $data);
 $ret = json_decode($retjson,true);
 if($ret['errcode'] == 0){
     echo "Push Template Message OK";
 }else{
     echo "Push Template Message Fail\n";
     var_dump($retjson);
 }
function curl_post($url, $post_string){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>