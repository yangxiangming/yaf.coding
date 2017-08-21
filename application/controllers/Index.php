<?php
/**
 * Description: 入口控制器
 * User: yangxiangming@live.com
 * Date: 16/4/7
 * Time: 下午9:00
 */

class IndexController extends Yaf_Controller_Abstract {

    final public function indexAction() {//默认Action
        $this->getView()->assign("message", "Welcome to Code");
    }
    
    final public function statusAction() {
        $list = [];
    }
    
    final public function areaAction(){
        $id = Yaf_Request_Http::getPost('id', 0);
        if(empty($id)){
            exit(json_decode([
                'status'=>0,
                'message'=>'地区id不能为空',
                'data'=>[]
            ]));
        }

        $area = new AreaModel();
        $list = $area->getArea($id);
        exit(json_decode([
            'status'=>1,
            'message'=>'Success',
            'data'=>$list
        ]));
    }

}
