<?php
/**
 * 
 * @author yangxiangming
 *
 */

class Develop {
  static public $instance; // 静态变量保存类中的实例

  private function __construct(){} // 防止外部实例化

  static public function getInstance(){ // 公共静态方法检测是否有实力对象
    if(!self::$instance){
      self::$instance = new self();
    }
    return self::$instance;
  }
}
