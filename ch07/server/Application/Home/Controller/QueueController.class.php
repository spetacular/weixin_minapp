<?php
namespace Home\Controller;
use Think\Controller;

class QueueController extends BaseController
{
    public function index(){
        $CategoryModel = M('category');
        $QueueModel = M('queue');
        $cats = $CategoryModel->field('id,label,description')->select();
        $result = array();
        foreach($cats as $row){

            $row['queue_num'] = $QueueModel->where("category_id={$row['id']} and status=0")->count();

            $number = $QueueModel->where("category_id={$row['id']} and status=1")->order('updated_at desc')->limit(1)->getField('number');
            if(empty($number)){
                $label = $row['label'].'000';
            }else{
                $label = sprintf('%s%03d',$row['label'],$number);
            }
            $row['current_number'] = $label;
            $result[] = $row;
        }
        $this->assign('result',$result);
        $this->assign('base_url',__ROOT__);
        $this->display('queue:index');
    }

    public function do_next(){
        $cat_id = intval($_POST['cat_id']);
        $QueueModel = M('queue');
        $cat = $QueueModel->where("category_id={$cat_id} and status=0")->order('id asc')->limit(1)->find();
        if($cat){
            $QueueModel->where("id={$cat['id']}")->save(array('status'=>1));
            $QueueModel->where("category_id={$cat_id} and number<{$cat['number']}")->save(array('status'=>2));
        }
        echo json_encode(array('msg'=>'ok'));
    }
}