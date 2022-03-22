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
		
		
	public static function add_post_content($back_url){
	$classid=safe_replace(safe_html($_POST["classid"]));
	if(!is_num($classid)){$classid=3;}
	$fbtitle=safe_replace(safe_html($_POST["fbtitle"]));
	$fbcontent=safe_replace(safe_html($_POST["fbcontent"]));
	$author=safe_replace(safe_html($_POST["author"]));
	$userid=0; //会员ID，预留
	$myphone=safe_replace(safe_html($_POST["myphone"]));
	$email=safe_replace(safe_html($_POST["email"]));	
	$qq=safe_replace(safe_html($_POST["qq"]));
	$address=safe_replace(safe_html($_POST["address"]));
	$replycontent=NULL;
	$replytime=NULL;
	$replyman=NULL;
	$hits=0;
	$orderid=0;	
	$tuijian=0;	
	$shenhe=0;
	$updatetime=date('Y-m-d H:i:s',time());
	
	if ($fbtitle==""){
	   echo_js("alert('标题不能为空！');history.back();");
	   exit;
	   }
	if ($fbcontent==""){
	   echo_js("alert('内容不能为空！');history.back();");
	   exit;
	   }
	$sql_into="insert into pl_feedback set classid=$classid,fbtitle='$fbtitle',fbcontent='$fbcontent',author='$author',updatetime='$updatetime',userid=$userid,myphone='$myphone',email='$email',address='$address',qq='$qq',tuijian=$tuijian,shenhe=$shenhe,hits=$hits,orderid=$orderid";
	$result=parent::mysql()->query($sql_into);//从父类中调用query方法，查询数据库
	        if ($result){
	       echo_js("alert('留言发送成功！我们会及时查看和反馈，谢谢您的支持！');location.href=\"$back_url\";");
		   }else{
		   echo_js("alert('留言发送失败！');history.back();");
			   }
			   
		
		}
		
	
	}


!defined('IN_CMS') && exit('Access Denied');

//接收参数
$classid=safe_replace(safe_html($_GET["classid"]));
$feedback=new feedback();

$action=safe_replace(safe_html($_GET["action"]));
if($action=="fb_post"){
	$back_url="index.php?m=feedback";
	$feedback->add_post_content($back_url);
	exit;
	}

$class_arr=$feedback->get_class_content($classid);
if($class_arr["isout"]==1){header("location:".$class_arr["outurl"]);exit;}//外部链接
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);

template("index","feedback","feedback_".$classid."_".md5(array_to_string($_GET,$separator="_")));