<?php
/**
 * Description: 入口模版
 * User: yangxiangming@live.com
 * Date: 16/4/7
 * Time: 下午9:01
 */

class IndexModel extends PDO{
    final public function __construct() {}

    final public function selectIndex() {
        return 'Hello IndexModel!';
    }

    final public function insertIndex($arrInfo) {
        return true;
    }
    
    public function getArea($id){
        $sql = "SELECT id, areaName, areaId FROM yaf_area WHERE id=:id";
        $stmt = PDO::db()->prepare($sql);
        return $stmt->execute([':id'=>$id])->fetchAll();
    }
}
