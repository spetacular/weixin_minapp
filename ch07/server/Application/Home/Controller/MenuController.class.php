<?php
namespace Home\Controller;
use Think\Controller;

class MenuController extends BaseController {

    public function query(){
        $fields = array('page', 'rows', 'sidx', 'sord', 'type', 'query', 'value', '_search', 'searchField', 'searchString', 'searchOper',);
        $params = $this->I($fields);

        $offset = ($params['page'] - 1) * $params['rows'];

        $p = array('offset' => $offset, 'limit' => $params['rows']);
        $MenuModel = M('menu');
        $result = $MenuModel->limit($p['offset'],$p['limit'])->select();
        $records = $MenuModel->count();
        $total = ceil($records/$params['rows']);
        $data = array(
            'records' => $records,
            'page' => $params['page'],
            'total' => $total,
            'rows' => $result,
        );

        echo json_encode($data);
    }


    public function update(){
        $fields = array('id', 'name', 'image','description','price','status');
        $params = $this->I($fields);

        $MenuModel = M('menu');

        $oper = I('post.oper');
        if ($oper == 'del') {//删除
            $MenuModel->where("id={$params['id']}")->delete();
        } else if ($oper == 'edit') {
            $params['updated_at'] = time();
            $MenuModel->where("id={$params['id']}")->save($params);
        }else if($oper == 'add'){
            unset($params['id']);
            $params['updated_at'] = time();
            $MenuModel->add($params);
        }

        echo json_encode(array('msg'=>'ok'));
    }

    public function index(){
        $this->assign('base_url',__ROOT__);
        $this->display('menu:index');
    }
}