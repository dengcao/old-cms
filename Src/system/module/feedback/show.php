<?php
class feedback extends base{
	
	public static function get_class_content($classid){//根据ID获取某分类的数据，成功则返回数组
	    $class_arr=array();
		if(is_num($classid)){
		$sql="select * from ".DB_PRE."class where parentid>0 and classid=".intval($classid);
		    }else{
				$sql="select * from ".DB_PRE."class where parentid=3 order by orderby desc,classid LIMIT 0,1";
			}
		$sql_class=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		//while($myrow=mysql_fetch_array($sql_class)){
		//	$class_arr=array("id"=>$myrow['classid']);
		//	}
		if(@$class_arr=mysql_fetch_array($sql_class)){
			return $class_arr;
			}
		}
			
		
	public function get_feedback_content($fbid){//根据ID获取文章的数据，成功则返回数组
	    $feedback_arr=array();
		if(is_num($fbid)){
		  $sql="select * from ".DB_PRE."feedback where fbid=".intval($fbid);
		   }else{
			   return "";
			   }		
		$sql_feedback=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		if(@$feedback_arr=mysql_fetch_array($sql_feedback)){			
			$update_hits=parent::mysql()->query("update ".DB_PRE."feedback set hits=".($feedback_arr['hits']+1)." where fbid=$fbid");//更新点击数
			return $feedback_arr;
			}
		}
		
	
	}


!defined('IN_CMS') && exit('Access Denied');

//接收参数
$fbid=safe_replace(safe_html($_GET["id"]));
$feedback=new feedback();

$feedback_arr=$feedback->get_feedback_content($fbid);
if(!is_num($feedback_arr["fbid"])){Echo_ErrMsg("抱歉，该信息不存在。","javascript:window.close();");exit;}//判断是否审核
if($feedback_arr["shenhe"]!=1){Echo_ErrMsg("抱歉，该信息未通过审核，暂时不能查看。","javascript:window.close();");exit;}//判断是否审核
if($feedback_arr["seo_title"]==""){
	$feedback_arr["seo_title"]=$feedback_arr["fbtitle"];
	}
assign("feedback",$feedback_arr);

$class_arr=$feedback->get_class_content($feedback_arr["classid"]);
if($class_arr["isout"]==1){header("location:".$class_arr["outurl"]);exit;}//外部链接
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);

template("show","feedback","fb_show_".$fbid."_".md5(array_to_string($_GET,$separator="_")));