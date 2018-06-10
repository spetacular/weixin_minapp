<?php
namespace Api\Controller;
use Think\Controller;

class QueueController extends BaseController
{
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