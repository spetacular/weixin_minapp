<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{

    public function __construct(){
        parent::__construct();
        $token = cookie('token');
        if(empty($token) || $token != md5(C('ADMIN_PASSWORD'))){
            $this->error('您长时间未操作已退出登录，请重新登录！',C('BASE_URL').'/index.php/home/login/index',3);
        }
    }

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