<?php
/**
 * Date: 15-12-26
 * @author 大蒙<59262424@qq.com.com>
 */

namespace Api\Model;


use Think\Model;

class ResourcesModel extends Model{

    public function editData($data)
    {
        if(!mb_strlen($data['description'],'utf-8')){
            $data['description']=msubstr(op_t($data['content']),0,200);
        }
        $data['reason']='';
        if($data['id']){
            $data['update_time']=time();
            $res=$this->save($data);
        }else{
            $data['create_time']=$data['update_time']=time();
            $res=$this->add($data);
            action_log('add_design', 'Design', $res, is_login());
        }
        return $res;
    }

    public function getListByPage($map,$page=1,$order='update_time desc',$field='*',$r=20)
    {
        $totalCount=$this->where($map)->count();
        if($totalCount){
            $list=$this->where($map)->page($page,$r)->order($order)->field($field)->select();
        }
        return array($list,$totalCount);
    }
	
	//访问最多的5条
    public function getList($map,$order='view desc',$limit=5,$field='*')
    {
        $lists = $this->where($map)->order($order)->limit($limit)->field($field)->select();
        return $lists;
    }


    public function getData($id)
    {
        if($id>0){
            $map['id']=$id;
            $data=$this->where($map)->find();
            return $data;
        }
        return null;
    }

} 