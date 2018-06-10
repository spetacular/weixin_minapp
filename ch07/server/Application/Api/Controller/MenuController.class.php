<?php
namespace Api\Controller;
use Think\Controller;

class MenuController extends BaseController {
    public function get_menus(){
        $MenuModel = M('menu');
        $menus = $MenuModel->field('name,image,price,description')->where('status=1')->select();
        echo json_encode($menus);
    }
}