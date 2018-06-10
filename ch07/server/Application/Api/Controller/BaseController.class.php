<?php
namespace Api\Controller;
use Think\Controller;
class BaseController extends Controller{
    //按字段获取用户输入
    protected function I($fields = array()){
        if(!is_array($fields)){
            return array();
        }
        $params = array();
        foreach($fields as $field){
            if(isset($_GET[$field])){
                $params[$field] = I('get.'.$field);
            }

            if(isset($_POST[$field])){
                $params[$field] = I('post.'.$field);
            }
        }
        return $params;
    }
}