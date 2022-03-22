<?php
class article extends base{
	
	public static function get_class_content($classid){//根据ID获取某分类的数据，成功则返回数组
	    $class_arr=array();
		if(is_num($classid)){
		$sql="select * from ".DB_PRE."class where parentid>0 and classid=".intval($classid);
		    }else{
				$sql="select * from ".DB_PRE."class where classid=2 order by orderby desc,classid LIMIT 0,1";
			}
		$sql_class=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		//while($myrow=mysql_fetch_array($sql_class)){
		//	$class_arr=array("id"=>$myrow['classid']);
		//	}
		if(@$class_arr=mysql_fetch_array($sql_class)){
			return $class_arr;
			}
		}
		
	public function get_article_content($artid){//根据ID获取文章的数据，成功则返回数组
	    $article_arr=array();
		if(is_num($artid)){
		  $sql="select * from ".DB_PRE."article where artid=".intval($artid);
		   }else{
			   return "";
			   }		
		$sql_article=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		if(@$article_arr=mysql_fetch_array($sql_article)){			
			$update_hits=parent::mysql()->query("update ".DB_PRE."article set hits=".($article_arr['hits']+1)." where artid=$artid");//更新点击数
			return $article_arr;
			}
		}
	
	}


!defined('IN_CMS') && exit('Access Denied');

//接收参数
$artid=safe_replace(safe_html($_GET["id"]));
$article=new article();

$article_arr=$article->get_article_content($artid);
if(!is_num($article_arr["artid"])){Echo_ErrMsg("抱歉，该信息不存在。","javascript:window.close();");exit;}//判断是否审核
if($article_arr["shenhe"]!=1){Echo_ErrMsg("抱歉，该信息未通过审核，暂时不能查看。","javascript:window.close();");exit;}//判断是否审核
if($article_arr["seo_title"]==""){
	$article_arr["seo_title"]=$article_arr["arttitle"];
	}
assign("article",$article_arr);

$class_arr=$article->get_class_content($article_arr["classid"]);
if($class_arr["isout"]==1){header("location:".$class_arr["outurl"]);exit;}//外部链接
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);
template("show","article","art_show_".$artid."_".md5(array_to_string($_GET,$separator="_")));