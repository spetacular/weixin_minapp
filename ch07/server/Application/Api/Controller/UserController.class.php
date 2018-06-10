<?php
namespace Api\Controller;
use Think\Controller;

class UserController extends BaseController {
    public function queues(){
        $CategoryModel = M('category');
        $QueueModel = D('queue');
        $cats = $CategoryModel->field('id,label,description')->select();
        $result = array();
        foreach($cats as $row){

            $row['queue_count'] = $QueueModel->get_queue_count($row['id']);

            $number = $QueueModel->get_calling_number($row['id']);
            if(empty($number)){
               $label = $row['label'].'000';
            }else{
                $label = sprintf('%s%03d',$row['label'],$number);
            }
            $row['current_number'] = $label;
            $result[] = $row;
        }
        echo json_encode($result);
    }

    public function queue_by_catid(){
        $catid = I('get.catid/d',0);
        $CategoryModel = M('category');
        $QueueModel = D('queue');
        $cat = $CategoryModel->field('id,label,description')->where("id={$catid}")->find();



        $cat['queue_count'] = $QueueModel->get_queue_count($catid);

            $number = $QueueModel->where("category_id={$catid} and status=1")->order('updated_at desc')->limit(1)->getField('number');
            if(empty($number)){
                $label = $cat['label'].'000';
            }else{
                $label = sprintf('%s%03d',$cat['label'],$number);
            }
        $cat['current_number'] = $label;


        echo json_encode($cat);
    }

    public function my_queue(){
        $guest_id = I('get.gusetId/s','');
        $QueueModel = D('queue');
        $CategoryModel = M('category');
        $where = array(
            'guest_id' => $guest_id
        );
        $queue = $QueueModel->where($where)->order('id desc')->find();

        if(!$queue){
            echo json_encode(array('msg'=>'NO'));
            exit(0);
        }
        $cat =  $CategoryModel->field('id,label,description')->where("id={$queue['category_id']}")->find();

        $queue['description'] = $cat['description'];
        $queue['label'] = sprintf('%s%03d',$cat['label'],$queue['number']);
        $current_id = $QueueModel->get_calling_number($queue['category_id']);;
        $current_number = sprintf('%s%03d',$cat['label'],$current_id);
        $result = array(
            'label' => $queue['label'],
            'description'=> $queue['description'],
            'current_number'=> $current_number,
            'ahead_count' => $QueueModel->get_ahead_count($queue['category_id'],$queue['number'])
        );
        echo json_encode($result);
    }

    public function do_queue(){
        $catid = I('post.catid/d',0);
        $guest_id = I('post.guestId/s','');
        $nickname = I('post.nickname/s','');
        $QueueModel = D('queue');

        $current_number = $QueueModel->where("category_id={$catid} and status!=2")->max('number');
        $max_number = $current_number ? $current_number+1 : 1;
        $data = array(
            'guest_id'=>$guest_id,
            'nickname'=>$nickname,
            'number'=>$max_number,
            'table_id'=>0,
            'category_id'=>$catid,
            'status'=>0,
            'updated_at'=>time(),
        );
        $QueueModel->add($data);
        echo json_encode(array('msg'=>'ok'));
    }


    public function wxlogin(){
        $code = $_GET['code'];
        $url_format = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
        $url = sprintf($url_format,C('APPID'),C('APPSECRET'),$code);
        $json = file_get_contents($url);
        $data = json_decode($json,true);
        if($data['openid']){
            $data['created_at'] = time();
            $UserModel = M('user');
            $where = array(
                "openid"=>$data['openid']
            );

            if($UserModel->where($where)->find()){
                $UserModel->where($where)->save($data);
            }else{
                $UserModel->add($data);
            }
            echo json_encode(array('msg'=>'ok','openid'=>$data['openid']));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
    }


    public function sign_test(){
        $data = array();
        $appid = 'wx4f4bc4dec97d474b';
        $sessionKey = 'tiihtNczf5v6AKRyjwEUhQ==';

        $encryptedData="CiyLU1Aw2KjvrjMdj8YKliAjtP4gsMZM
                QmRzooG2xrDcvSnxIMXFufNstNGTyaGS
                9uT5geRa0W4oTOb1WT7fJlAC+oNPdbB+
                3hVbJSRgv+4lGOETKUQz6OYStslQ142d
                NCuabNPGBzlooOmB231qMM85d2/fV6Ch
                evvXvQP8Hkue1poOFtnEtpyxVLW1zAo6
                /1Xx1COxFvrc2d7UL/lmHInNlxuacJXw
                u0fjpXfz/YqYzBIBzD6WUfTIF9GRHpOn
                /Hz7saL8xz+W//FRAUid1OksQaQx4CMs
                8LOddcQhULW4ucetDf96JcR3g0gfRK4P
                C7E/r7Z6xNrXd2UIeorGj5Ef7b1pJAYB
                6Y5anaHqZ9J6nKEBvB4DnNLIVWSgARns
                /8wR2SiRS7MNACwTyrGvt9ts8p12PKFd
                lqYTopNHR1Vf7XjfhQlVsAJdNiKdYmYV
                oKlaRv85IfVunYzO0IKXsyl7JCUjCpoG
                20f0a04COwfneQAGGwd5oa+T8yO5hzuy
                Db/XcxxmK01EpqOyuxINew==";

        $iv = 'r7BXXKkLb8qrSNn05n0qiA==';

        $pc = new \Org\Util\Weixin\DataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );

        if ($errCode == 0) {
            print($data . "\n");
        } else {
            print($errCode . "\n");
        }
    }

    private function get_queue_num($catid){
        $QueueModel = D('queue');
        return $QueueModel->where("category_id={$catid} and status=0")->count();
    }


    private function get_current_number($catid,$label){
        $QueueModel = D('queue');
        $label = $QueueModel->where("category_id={$catid} and status=1")->order('updated_at desc')->limit(1)->getField('number');
        if(empty($label)){
            $label = $label.'000';
        }else{

        }
        $row['current_number'] = $label;
    }
}