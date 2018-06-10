<?php
namespace Home\Controller;
class IndexController extends BaseController {
    public function index(){
        $this->assign('base_url',__ROOT__);
        $this->display('index:index');
    }


    public function upload(){
        $data = $this->upload_local();

        echo json_encode($data);
    }

    private function upload_local(){
        $base = dirname($_SERVER['SCRIPT_FILENAME']);
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     $base.'/Public/attachments/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        $url = C('BASE_URL').'/Public/attachments/'.$info['file']['savepath'].$info['file']['savename'];
        if(!$info) {// 上传错误提示错误信息
            return array(
                'ret'=>-1,
                'msg'=>'上传失败'
            );
        }else{// 上传成功
            return array(
                'ret'=>0,
                'url'=>$url
            );
        }

    }
}