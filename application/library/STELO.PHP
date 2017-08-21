<?php
/**
 * Description: 常用函数
 * User: yangxiangming@live.com
 * Date: 16/4/27
 * Time: 下午4:14
 */
 
CLASS STELO{

    /**
     * 默认构造函数
     */
    PRIVATE FUNCTION __CONSTRUCT(){}

    /**
     * STELO TIME
     */
    FINAL PUBLIC STATIC FUNCTION GetWedding(){
        $now = date('Y-m-d', time());
        $LoveStart = "2012-06-03";
        $LifeStart = "2013-06-10";
        $LicensingStart = "2016-04-13";
        // 时间区间计算
        $weddingTime['LoveTime'] = (strtotime($now)-strtotime($LoveStart))/(3600*24);
        $weddingTime['LifeTime'] = (strtotime($now)-strtotime($LifeStart))/(3600*24);
        $weddingTime['LicensingTime'] = (strtotime($now)-strtotime($LicensingStart))/(3600*24);
        // 返回计算数据
        return $weddingTime;
    }
}
