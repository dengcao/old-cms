<?php
/**
 * ====================================================================================
 * 函数库
 * $Author: 邓草   http://caozha.com
 * GitHub：https://github.com/cao-zha
 * Gitee： https://gitee.com/caozha
 * 基于木兰宽松许可证 2.0（Mulan PSL v2）免费开源，您可以自由复制、修改、分发或用于商业用途，但需保留作者版权等声明。详见开源协议：http://license.coscl.org.cn/MulanPSL2
 * old-cms (Software Name) is licensed under Mulan PSL v2. Please refer to: http://license.coscl.org.cn/MulanPSL2
 * ====================================================================================
**/


//截取字符串
function strip_str_content($str, $start, $end){
        if ( $start == '' || $end == '' ){
               return "";
        }
        $str = explode($start, $str);
        $str = explode($end, $str[1]);
        return $str[0]; 
}

//检查字符串长度
function strlength($str,$len){
	if(strlen($str)<$len){
		return false;
	}else{
		return $str;
	}
}

function array_to_string($arr,$separator=",",$periphery=""){
	//数组转换为字符串，默认以“,”分开，$periphery为外围，比如'1'，'2','3'……中的'
	if (!is_array($arr)){return $arr;}
	if(!$separator){$separator=",";}
	if(!$periphery){$periphery="";}
	$arr_str="";
	$arr_count=count($arr);
	foreach($arr as $key=>$value){//输出数组
	      if($key==($arr_count-1)){
			  $arr_str.=$periphery.$value.$periphery;
			  }else{
			  $arr_str.=$periphery.$value.$periphery.$separator;
			  }
		}
	return $arr_str;
	}

function array_iconv($arr,$from="",$to=""){
	//一维数组转换编码，比如gbk转utf-8：array_iconv($arr,"gbk","utf-8")
	if (!is_array($arr) || $from=="" || $to==""){return $arr;}
	foreach($arr as $key=>$value){//输出数组
	      if (!is_utf8($value)){
			  $arr[$key]=iconv($from,$to,$value);//转换格式
		        }
		}
	return $arr;
	}

//判断是否为数字
function is_num($str){
	if(strlen($str)>0){
		return preg_match('/[\d]/',$str);
	}else{
		return false;
		}
}

//正则检查字符串
function check_str($str,$ereg){
	if(empty($str)){
		return false;
	}else{
		return preg_match($ereg,$str);
	}
}

//过滤非法字符串函数
function safe_replace($string) {
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('%2527','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','&quot;',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace('"','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','&lt;',$string);
	$string = str_replace('>','&gt;',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	$string = str_replace('\\','',$string);
	return $string;
}


// Returns true if $string is valid UTF-8 and false otherwise. 
function is_utf8($word){//判断是否UTF-8字符串
if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true) 
{ 
return true; 
}else{
return false;
}
} 


//安全过滤SQL函数
function safe_html($str){
	if(empty($str)){return;}
	$str=preg_replace('/select|insert | update | and | in | on | left | joins | delete |\%|\=|\/\*|\*|\.\.\/|\.\/| union | from | where | group | into |load_file
|outfile/','',$str);
	return htmlspecialchars($str);
}

//清除数组中空元素
function array_clear($arr){
	if(is_array($arr)){
		function odd($var){
			return($var<>'');
		}
		return (array_filter($arr, "odd"));
	}else{
		return $arr;
	}
}

//获取IP
function getip() {  
	if (getenv ( "HTTP_CLIENT_IP" )) {
		$httpip = getenv ( "HTTP_CLIENT_IP" );
		return $httpip;
	}
	if (getenv ( "HTTP_X_FORWARDED_FOR" )) {
		$httpip = getenv ( "HTTP_X_FORWARDED_FOR" );
		return $httpip;
	}
	if (getenv ( "HTTP_X_FORWARDED" )) {
		$httpip = getenv ( "HTTP_X_FORWARDED" );
		return $httpip;
	}
	if (getenv ( "HTTP_FORWARDED_FOR" )) {
		$httpip = getenv ( "HTTP_FORWARDED_FOR" );
		return $httpip;
	}
	if (getenv ( "HTTP_FORWARDED" )) {
		$httpip = getenv ( "HTTP_FORWARDED" );
		return $httpip;
	}
	$httpip = $_SERVER ['REMOTE_ADDR'];
	
	if (!preg_match("/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/", $httpip)) { 
		$httpip = "127.0.0.1";
	}
	
	return $httpip;
}

//获取当前时间
function get_datetime($format=""){
	//return strtotime("now");
	if($format){
		return date($format,time());
		}else{
	    return date("Y-m-d H:i:s",time());
	}
}

//模板加载函数
function template($name,$path="",$cacheid=""){//$cacheid缓存号，防止同一模板覆盖缓存
	global $smarty;	
	if(strtolower(strrchr($name,'.'))==""){//检查是否带后缀，假如不带，则默认使用.html
		$name.=".html";
		}
	if(!file_exists(Template_Path_Current.$path."/".$name))die($path."/".$name."模版文件不存在"); //检查模版文件是否存在
	$smarty->display(Template_Path_Current.$path."/".$name,$cacheid);
}

//模板加载变量
function assign($var,$value){
	global $smarty;
	$smarty->assign($var,$value);
}

function Echo_ErrMsg($text,$gotourl){//输出错误信息
	if ($gotourl==""){$gotourl="javascript:history.back();";}
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<table width=100% height=100% border=0 align=center cellpadding=0 cellspacing=0><tr><td valign=top>";
echo "<table cellSpacing=0 cellPadding=0 width=480 align=center border=0><tr><td height=99></td></tr></table>";
echo "<table width=500 border=0 align=center cellPadding=0 cellSpacing=0 style='border:1px #66cc66 solid;' bgcolor=#DDEEEB><tr><td valign=top><table width=100% border=0 align=center cellPadding=4 cellSpacing=0><tr><td height=26 colspan=3 bgcolor=#BAF692  style='font-size:14px;color:#666;font-weight:bold'>&nbsp;<img src=\"".WEB_DIR."images/arr_error.gif\" width=7 height=8>&nbsp;&nbsp;系统提示信息</td></tr><tr><td height=1 colspan=3 style='background-color:#66cc66'></td></tr><tr><td height=127 colSpan=3 align=left valign=top style='padding-left:12px;background-color:#EDFEE7;font-size:12px;line-height:150%;color:#666' >". $text ."</td></tr><tr><td height=27 colSpan=3 align=center  style='background-color:#EDFEE7'><a href=\"".$gotourl."\" class=bgcolor1>确 定</a></td></tr></table></td></tr></table></td></TD></tr></table>";
	}

function Echo_Js($text){//输出JS
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	echo "<script language=\"javascript\">".$text."</script>";
	}

function Check_date($date) { //检查日期是否合法日期:2012-01-01
    $dateArr = explode("-", $date);
    if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) {
        return checkdate($dateArr[1],$dateArr[2],$dateArr[0]);
    }
    return false;
}

function Check_time($time) {  //检查时间是否合法时间:12:01:01
    $timeArr = explode(":", $time);
    if (is_numeric($timeArr[0]) && is_numeric($timeArr[1]) && is_numeric($timeArr[2])) {
        if (($timeArr[0] >= 0 && $timeArr[0] <= 23) && ($timeArr[1] >= 0 && $timeArr[1] <= 59) && ($timeArr[2] >= 0 && $timeArr[2] <= 59))
            return true;
        else
            return false;
    }
    return false;
}

function is__date($date_time){//检查时间是否合法:2012-01-01 12:01:01
	 $dateArr = explode(" ", $date_time);
	 if(Check_date($dateArr[0]) && Check_time($dateArr[1])){
		 return true;
		 }else{return false;}
	}