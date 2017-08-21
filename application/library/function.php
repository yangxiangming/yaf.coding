<?php
/**
 * Description: 常用函数
 * User: yangxiangming@live.com
 * Date: 16/4/7
 * Time: 下午9:01
 */

/**
 * 获取客户端IP
 */
function getClientIp(){
    if(isset($_SERVER["HTTP_CLIENT_IP"]) and strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")){
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) and strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")){
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    if(isset($_SERVER["REMOTE_ADDR"])){
        return $_SERVER["REMOTE_ADDR"];
    }
    return "";
}

/**
 * 正则处理图片
 * param $string 数据源
 * param $attribute 要添加的属性
 */
function getReplaceImg($string, $attribute){
    return preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', '<a '.$attribute.' href="$2">$0</a>', $string);
}

/**
 * 键值不变随机重排序列
 * param $list
 */
function arrayShuffleArray($list) {
    if (!is_array($list)) return $list;
    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key){
        $random[$key] = $list[$key];
    }
    return $random;
}

/**
 * 根据键值排序
 * param $list 排序数据
 * param $key 排序键值
 * param int $sort 排序方式
 */
function arraySort($list, $key, $sort=SORT_DESC){
    if(is_array($list)){
        foreach ($list as $array){
            if(is_array($array)){
                $keyArray[] = $array[$key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($keyArray, $sort, $list);
    return $list;
}

/**
 * 过滤html中的tag属性
 * param $html 要过滤的数据
 * param $attrs 指定过滤tag属性
 */
function removeAttr($html, $attrs=[]){
    //删除所有属性
    if (!is_array($attrs) or count($attrs) == 0){
        return preg_replace('~<([a-z]+)[^>]*>~i','<$1>', $html);
    } else { //删除部分指定的属性
        foreach($attrs as $attr){
            $regx = '~<([^>]*?)[\s\t\r\n]+('.$attr.'[\s\t\r\n]*=[\s\t\r\n]*([\"\'])[^\3]*?\3)([^>]*)>~i';
            $html = preg_replace($regx,'<$1 $4>', $html);
        }
        return $html;
    }
}

/**
 * 字符串截取
 * param $string 截取数据
 * param $start 开始位置
 * param $length 截取长度
 * param $charset 编码格式
 * param $suffix 后缀
 */
function stringSubstr($string, $start=0, $length, $charset="utf-8", $suffix=true){
    if(function_exists("mb_substr")){
        if ($suffix && strlen($string)>$length){
            return mb_substr($string, $start, $length, $charset)."...";
        } else {
            return mb_substr($string, $start, $length, $charset);
        }
    } elseif(function_exists('iconv_substr')) {
        if ($suffix && strlen($string)>$length) {
            return iconv_substr($string,$start,$length,$charset)."...";
        } else {
            return iconv_substr($string,$start,$length,$charset);
        }
    }
    
    $preg['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $preg['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $preg['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $preg['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    
    preg_match_all($preg[$charset], $string, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}

/**
 * 获取Unix时间微妙数
 */
function getRunTime() {
    list($usec,$sec)=explode(" ",microtime());
    return ((float)$usec+(float)$sec);
}

/**
 * 根据键值获取值
 * param $array 数组
 * param $name 键值名
 * param bool $keep 是否保存数据键
 */
function getKeyValue($array, $name, $keep = true){

}

/**
 * 数组合并
 * param $array1
 * param $array2
 */
function arrayMerge($array1, $array2){
    $args = func_get_args();
    $res = array_shift($args);
    while (!empty($args)) {
        $next = array_shift($args);
        foreach ($next as $k => $v) {
            if (is_int($k)) {
                if (isset($res[$k])) {
                    $res[] = $v;
                } else {
                    $res[$k] = $v;
                }
            } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                $res[$k] = self::merge($res[$k], $v);
            } else {
                $res[$k] = $v;
            }
        }
    }
    return $res;
}

/**
 * 格式化时间
 * param $time 时间戳
 */
function getFormatTime($time){
    date_default_timezone_set('PRC'); //设置东八区时间
    $nowTime = time(); //当前时间
    $result = $temp = 0;

    //时间匹配
    switch ($time) {
        //分钟
        case ($time+60)>$nowTime:
            //$temp = $nowTime-$time;
            //$result = $temp.'秒前';
            $result = '刚刚';
            break;
        //小时
        case ($time+(60*60))>$nowTime:
            $temp = date('i', $nowTime-$time);
            $result = $temp.'分钟前';
            break;
        //一天
        case ($time+(60*60*24))>$nowTime:
            $temp = date('H', $nowTime)-date('H', $time);
            $result = $temp.'小时前';
            break;
        //昨天
        case ($time+(60*60*24*2))>$nowTime:
            $temp = date('H:i', $time);
            $result = '昨天'.$temp;
            break;
        //前天
        case ($time+(60*60*24*3))>$nowTime:
            $temp = date('H:i', $time);
            $result = '前天'.$temp;
            break;
        //7天内
        case ($time+(60*60*24*7))>$nowTime:
            $temp = $nowTime-$time;
            $day = floor($temp/(60*60*24));
            $result = $day.'天前'.date('H:i', $time);
            break;
        //年月日
        default:
            $result = date('Y-m-d', $time);
            break;
    }
    return $result;
}

/**
 * 数组分割[类似分页]
 * param $num 总数
 * param $page 索引[当前位置]
 * param $array 数组
 * param $sort 反转数组顺序
 */
function arrayPage($num, $page, $array, $order=0){
    // 定全局变量
    global $countpage;
    $page=(empty($page))?'1':$page;
    // 开始位置
    $start=($page-1)*$num;
    if($order==1){
        $array=array_reverse($array);
    }
    // 总数
    $totals=count($array);
    $countpage=ceil($totals/$num);
    $pagedata=array_slice($array, $start, $num);
    return $pagedata;
}

/**
 * POST请求URL
 * param $data 数组[请求的参数]
 * param $url URL
 */
function postCurl($data, $url){
    if(!is_array($data)) return false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $url);
    $info= curl_exec($ch);
    curl_close($ch);
    return $info;
}

/**
 * description 输出json数据格式
 */
function outputJson($array, $isboor = true, $isheader = true) {
    $isheader && header('Content-type: application/json;charset=utf-8');
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Expires: Mon, 26 Jul 1997 01:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pramga: no-cache");
    if ($isboor){
        exit (json_encode((array)($array), JSON_UNESCAPED_UNICODE));
    } else {
        exit (stripcslashes(json_encode((array)($array)), JSON_UNESCAPED_UNICODE));
    }
}

/**
 * description 获取毫秒时间
 */
function getMsec($isboor = true) {
    list($usec, $sec) = explode(" ", microtime());
    $microtime = ((float)$usec+(float)$sec);
    list($usec, $sec) = explode(".", $microtime);
    $date = date('Y-m-d H:i:s x', $usec);
    $result = str_replace('x', $sec, $date);
    return $isboor?$result.'Msec':$microtime;
}

/**
 * description 获取设备
 */
function isClient() {
    if(!empty($_SERVER('HTTP_USER_AGENT') && (substr($_SERVER('HTTP_USER_AGENT'), 0, 12) == 'great-winner') || strpos($_SERVER['HTTP_USER_AGENT'], 'great-winner'))){
        return true;
    }
    return false;
}
