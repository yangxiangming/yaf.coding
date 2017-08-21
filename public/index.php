<?php
/**
 * Description: 入口文件
 * User: yangxiangming@live.com
 * Date: 16/4/7
 * Time: 下午8:55
 */

define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->run();
