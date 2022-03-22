<?php
class hr extends base{
	
	public static function get_class_content($classid){//根据ID获取某分类的数据，成功则返回数组
	    $class_arr=array();
		if(is_num($classid)){
		$sql="select * from ".DB_PRE."class where parentid>0 and classid=".intval($classid);
		    }else{
				$sql="select * from ".DB_PRE."class where classid=7 order by orderby desc,classid LIMIT 0,1";
			}
		$sql_class=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		//while($myrow=mysql_fetch_array($sql_class)){
		//	$class_arr=array("id"=>$myrow['classid']);
		//	}
		if(@$class_arr=mysql_fetch_array($sql_class)){
			return $class_arr;
			}
		}
	
	}



!defined('IN_CMS') && exit('Access Denied');

//接收参数
$classid=safe_replace(safe_html($_GET["classid"]));
$p=safe_replace(safe_html($_GET["p"]));
$hr=new hr();
$class_arr=$hr->get_class_content($classid);
if($class_arr["isout"]==1){header("location:".$class_arr["outurl"]);exit;}//外部链接
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);
template("index","hr","hr_".$classid."_".$p."_".md5(array_to_string($_GET,$separator="_")));