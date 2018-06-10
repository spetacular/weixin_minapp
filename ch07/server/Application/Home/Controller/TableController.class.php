<?php
namespace Home\Controller;
use Think\Controller;

class TableController extends BaseController {

    public function query(){
        $fields = array('page', 'rows', 'sidx', 'sord', 'type', 'query', 'value', '_search', 'searchField', 'searchString', 'searchOper',);
        $params = $this->I($fields);

        $offset = ($params['page'] - 1) * $params['rows'];

        $p = array('offset' => $offset, 'limit' => $params['rows']);
        $TablesModel = M('tables');
        $result = $TablesModel->limit($p['offset'],$p['limit'])->select();
        foreach($result as &$row){
            $row['category_id'] = (int)$row['category_id'];
        }
        $records = $TablesModel->count();
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
        $fields = array('id', 'inner_number', 'category_id','status');
        $params = $this->I($fields);

        $TablesModel = M('tables');

        $oper = I('post.oper');
        if ($oper == 'del') {//删除
            $TablesModel->where("id={$params['id']}")->delete();
        } else if ($oper == 'edit') {
            $params['updated_at'] = time();
            $TablesModel->where("id={$params['id']}")->save($params);
        }else if($oper == 'add'){
            unset($params['id']);
            $params['updated_at'] = time();
            $TablesModel->add($params);
        }

        echo json_encode(array('msg'=>'ok'));
    }

    public function index(){
        $this->assign('base_url',__ROOT__);
        $CategoryModel = M('category');
        $result = $CategoryModel->field('id,description')->select();
        //var_dump($result);
        $category = array();
        foreach($result as $row){
            $category[] = $row['id'].':'.$row['description'];
        }

        $this->assign('category',implode(';',$category));
        $this->display('table:index');
    }
}