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
		
	public function get_hr_content($hrid){//根据ID获取数据，成功则返回数组
	    $hr_arr=array();
		if(is_num($hrid)){
		  $sql="select * from ".DB_PRE."hr where hrid=".intval($hrid);
		   }else{
			   return "";
			   }		
		$sql_hr=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		if(@$hr_arr=mysql_fetch_array($sql_hr)){			
			$update_hits=parent::mysql()->query("update ".DB_PRE."hr set hits=".($hr_arr['hits']+1)." where hrid=$hrid");//更新点击数
			return $hr_arr;
			}
		}
	
	}



!defined('IN_CMS') && exit('Access Denied');

//接收参数
$hrid=safe_replace(safe_html($_GET["id"]));
$hr=new hr();

$hr_arr=$hr->get_hr_content($hrid);
if(!is_num($hr_arr["hrid"])){Echo_ErrMsg("抱歉，该信息不存在。","javascript:window.close();");exit;}//判断是否审核
if($hr_arr["shenhe"]!=1){Echo_ErrMsg("抱歉，该信息未通过审核，暂时不能查看。","javascript:window.close();");exit;}//判断是否审核

assign("hr",$hr_arr);

$class_arr=$hr->get_class_content($hr_arr["classid"]);
if($class_arr["isout"]==1){header("location:".$class_arr["outurl"]);exit;}//外部链接
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);
template("show","hr","hr_show_".$hrid."_".md5(array_to_string($_GET,$separator="_")));