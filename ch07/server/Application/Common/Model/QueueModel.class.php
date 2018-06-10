<?php
namespace Common\Model;
use Think\Model;
class QueueModel extends Model{
    const WAITING = 0;//正在排队
    const CALLING = 1;//正在叫号
    const EXPIRED = 2;//已过号

    /**
     * 获取每队的排队人数
     * @param $category_id
     * @return int
     */
    public function get_queue_count($category_id){
        $where = array(
            'category_id'=>$category_id,
            'status' => self::WAITING
        );
        return $this->where($where)->count();
    }

    /**
     * 返回每队当前的叫号
     * @param $category_id
     * @return int
     */
    public function get_calling_number($category_id){
        $where = array(
            'category_id'=>$category_id,
            'status' => self::CALLING
        );
        return $this->where($where)->order('updated_at desc')->limit(1)->getField('number');
    }

    /**
     * 返回前面还有几位客人
     * @param $category_id
     * @param $my_number
     * @return int 返回客人数目，大于0为正在排队，等于0为正在叫号，小于0为已过期
     */
    public function get_ahead_count($category_id,$my_number){
        $current_num = $this->get_calling_number($category_id);
        //var_dump($current_num);
        return $my_number-$current_num;
    }

}