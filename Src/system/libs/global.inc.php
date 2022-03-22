<?php
/**
 * ====================================================================================
 * 全局处理程序
 * $Author: 邓草   http://caozha.com
 * GitHub：https://github.com/cao-zha
 * Gitee： https://gitee.com/caozha
 * 基于木兰宽松许可证 2.0（Mulan PSL v2）免费开源，您可以自由复制、修改、分发或用于商业用途，但需保留作者版权等声明。详见开源协议：http://license.coscl.org.cn/MulanPSL2
 * old-cms (Software Name) is licensed under Mulan PSL v2. Please refer to: http://license.coscl.org.cn/MulanPSL2
 * ====================================================================================
**/
!defined('IN_CMS') && exit('Access Denied');

define("LIBS_PATH",SYS_BASE_PATH_ROOT."system/libs/");
define("Module_Dir",SYS_BASE_PATH_ROOT."system/module/"); //定义模块文件夹
define("Template_FOLDER","default"); //定义模板文件夹
define("Template_Path_Root",SYS_BASE_PATH_ROOT."templates/"); //定义模板总路径
define("Template_Path_Current",Template_Path_Root.Template_FOLDER."/"); //定义当前模板路径

require_once(SYS_BASE_PATH_ROOT."include/conn.php");//加载数据库连接
require_once(LIBS_PATH."smarty.inc.php");//加载模板引擎
require_once(LIBS_PATH."class.base.php");//加载基础类
require_once(LIBS_PATH."function.inc.php");//加载函数库

if(WEB_ISWEBCLOSE==1){//检测是否关闭网站
	Echo_ErrMsg("<li>抱歉，网站暂停访问！<li>原因：".WEB_WEBCLOSE_CAUSE,"javascript:window.close();");
	exit;
	}

$base=new base(); //实例化基础类
$config_arr=$base->load_webconfig();
assign("web",$config_arr);   //加载网站配置
$label_arr=$base->get_label();
assign("label",$label_arr);   //加载标签
$_GET=array_iconv($_GET,"gbk","utf-8");//转换GBK为UTF-8，防止乱码
$_POST=array_iconv($_POST,"gbk","utf-8");
assign("get",$_GET); //加载标签
assign("post",$_POST);

//构造模板函数:get_category
$smarty->registerPlugin("function","get_category","get_category_smarty");
function get_category_smarty($params,$smarty) //获取分类列表
{
  if($params==""){
		return false;
		}
  if(!is_num($params["parentid"])){
    $parentid = 0;
  }else{
	$parentid = $params["parentid"];
	  }
  if(!is_num($params["visible"])){
    $visible = "";
  }else{
	$visible = $params["visible"];
	  }
  $level=$params["level"];
  $htmlstr=$params["htmlstr"];
  $num=$params["num"];
  $noneback = $params["noneback"];
  global $base;
  $base->category_html_str="";//初始化分类保存变量，防止数据重复
  return $base->get_category($parentid,$level,$visible,$htmlstr,$noneback,$num);
}


//构造模板函数:get_category_list
$smarty->registerPlugin("block","get_category_list", "get_category_list_smarty");
function get_category_list_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
  if(!is_num($params["parentid"])){
    $parentid_list = 0;
  }else{
	$parentid_list = $params["parentid"];
	  }
  if(!is_num($params["visible"])){
    $visible_list = "";
  }else{
	$visible_list = $params["visible"];
	  }
  $level_list=$params["level"];
  $htmlstr_list=$content;
  $num_list=$params["num"];
  $noneback = $params["noneback"];
  global $base;
  $base->category_html_str="";//初始化分类保存变量，防止数据重复
  return $base->get_category($parentid_list,$level_list,$visible_list,$htmlstr_list,$noneback,$num_list);
 }
}
}


//构造模板函数:get_category_level
$smarty->registerPlugin("block","get_category_level", "get_category_level_smarty");
function get_category_level_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
  if(!is_num($params["parentid"])){
    $parentid_list = 0;
  }else{
	$parentid_list = $params["parentid"];
	  }
  if(!is_num($params["visible"])){
    $visible_list = "";
  }else{
	$visible_list = $params["visible"];
	  }
  $level_list=$params["level"];
  $htmlstr_list=$content;
  $num_list=$params["num"];
  $noneback = $params["noneback"];
  global $base;
  $base->category_html_str="";//初始化分类保存变量，防止数据重复
  return $base->get_category_level($parentid_list,$level_list,$visible_list,$htmlstr_list,$noneback,$num_list);
 }
}
}


//构造模板函数:get_product_list
$smarty->registerPlugin("block","get_product_list", "get_product_list_smarty");
function get_product_list_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
	 $classid=$params["classid"];
	 
  if(!is_num($params["recommend"])){//推荐
    $tuijian = "";
  }else{
	$tuijian = $params["recommend"];
	  }
  if(!is_num($params["auditing"])){//审核
    $shenhe = "";
  }else{
	$shenhe = $params["auditing"];
	  }
  if(!is_bool($params["isimg"])){//是否必须包含产品图片
    $is_proimg = "";
  }else{
	$is_proimg=$params["isimg"];
	  }    
  $htmlstr=$content;
  if(!is_num($params["num"])){//每页显示
    $num = 20;
  }else{
	$num = $params["num"];
	  }
  $orderby=$params["orderby"];
  if(!is_bool($params["ischild"])){//是否包含子分类的产品
    $is_childclass = true;
  }else{
	$is_childclass=$params["ischild"];
	  }
  if(!is_num($params["pagestyle"])){//分页显示样式，1-4
    $page_style = 4;
  }else{
	$page_style = $params["pagestyle"];
	  }
  $noneback = $params["noneback"];
  $page_str = $params["page"];
  $sql_like=$params["sql_like"];//模糊查询（设置查询包含的字段，多个用,分隔）
  $keyword=$params["keyword"];
  global $base;
  $base->product_list_html_str="";//初始化变量，防止数据重复
  $get_product_list=$base->get_product_list($classid,$tuijian,$shenhe,$is_proimg,$htmlstr,$noneback,$num,$orderby,$is_childclass,$page_style,$page_str,$sql_like,$keyword);
  return $get_product_list;
 }
}
}

//构造模板函数:get_article_list
$smarty->registerPlugin("block","get_article_list", "get_article_list_smarty");
function get_article_list_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
	 $classid=$params["classid"];
	 
  if(!is_num($params["recommend"])){//推荐
    $tuijian = "";
  }else{
	$tuijian = $params["recommend"];
	  }
  if(!is_num($params["auditing"])){//审核
    $shenhe = "";
  }else{
	$shenhe = $params["auditing"];
	  }
  if(!is_bool($params["isimg"])){//是否必须包含产品图片
    $is_artimg = "";
  }else{
	$is_artimg =$params["isimg"];
	  }    
  $htmlstr=$content;
  if(!is_num($params["num"])){//每页显示
    $num = 20;
  }else{
	$num = $params["num"];
	  }
  $orderby=$params["orderby"];
  if(!is_bool($params["ischild"])){//是否包含子分类的产品
    $is_childclass = true;
  }else{
	$is_childclass=$params["ischild"];
	  }
  if(!is_num($params["pagestyle"])){//分页显示样式，1-4
    $page_style = 4;
  }else{
	$page_style = $params["pagestyle"];
	  }
  $noneback = $params["noneback"];
  $page_str = $params["page"];
  $sql_like=$params["sql_like"];//模糊查询（设置查询包含的字段，多个用,分隔）
  $keyword=$params["keyword"];
  global $base;
  $base->article_list_html_str="";//初始化变量，防止数据重复
  $get_article_list=$base->get_article_list($classid,$tuijian,$shenhe,$is_artimg,$htmlstr,$noneback,$num,$orderby,$is_childclass,$page_style,$page_str,$sql_like,$keyword);
  return $get_article_list;
 }
}
}


//构造模板函数:get_feedback_list
$smarty->registerPlugin("block","get_feedback_list", "get_feedback_list_smarty");
function get_feedback_list_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
	 $classid=$params["classid"];
	 
  if(!is_num($params["recommend"])){//推荐
    $tuijian = "";
  }else{
	$tuijian = $params["recommend"];
	  }
  if(!is_num($params["auditing"])){//审核
    $shenhe = "";
  }else{
	$shenhe = $params["auditing"];
	  }
  if(!is_bool($params["isreply"])){//是否有回复内容
    $is_reply = "";
  }else{
	$is_reply = $params["isreply"];
	  }    
  $htmlstr=$content;
  if(!is_num($params["num"])){//每页显示
    $num = 20;
  }else{
	$num = $params["num"];
	  }
  $orderby=$params["orderby"];
  if(!is_bool($params["ischild"])){//是否包含子分类的产品
    $is_childclass = true;
  }else{
	$is_childclass=$params["ischild"];
	  }
  if(!is_num($params["pagestyle"])){//分页显示样式，1-4
    $page_style = 4;
  }else{
	$page_style = $params["pagestyle"];
	  }
  $noneback = $params["noneback"];
  $page_str = $params["page"];
  $sql_like=$params["sql_like"];//模糊查询（设置查询包含的字段，多个用,分隔）
  $keyword=$params["keyword"];
  global $base;
  $base->feedback_list_html_str="";//初始化变量，防止数据重复
  $get_feedback_list=$base->get_feedback_list($classid,$tuijian,$shenhe,$is_reply,$htmlstr,$noneback,$num,$orderby,$is_childclass,$page_style,$page_str,$sql_like,$keyword);
  return $get_feedback_list;
 }
}
}


//构造模板函数:get_hr_list
$smarty->registerPlugin("block","get_hr_list", "get_hr_list_smarty");
function get_hr_list_smarty($params, $content, $smarty, $repeat, $template="")
{
if(!$repeat){
 if(isset($content)){
	 $classid=$params["classid"];
	 
  if(!is_num($params["recommend"])){//推荐
    $tuijian = "";
  }else{
	$tuijian = $params["recommend"];
	  }
  if(!is_num($params["auditing"])){//审核
    $shenhe = "";
  }else{
	$shenhe = $params["auditing"];
	  }
  if(!is_bool($params["is_useful_life"])){//是否有回复内容
    $is_useful_life = "";
  }else{
	$is_useful_life = $params["is_useful_life"];
	  }    
  $htmlstr=$content;
  if(!is_num($params["num"])){//每页显示
    $num = 20;
  }else{
	$num = $params["num"];
	  }
  $orderby=$params["orderby"];
  if(!is_bool($params["ischild"])){//是否包含子分类的产品
    $is_childclass = true;
  }else{
	$is_childclass=$params["ischild"];
	  }
  if(!is_num($params["pagestyle"])){//分页显示样式，1-4
    $page_style = 4;
  }else{
	$page_style = $params["pagestyle"];
	  }
  $noneback = $params["noneback"];
  $page_str = $params["page"];
  $sql_like=$params["sql_like"];//模糊查询（设置查询包含的字段，多个用,分隔）
  $keyword=$params["keyword"];
  global $base;
  $base->hr_list_html_str="";//初始化变量，防止数据重复
  $get_hr_list=$base->get_hr_list($classid,$tuijian,$shenhe,$is_useful_life,$htmlstr,$noneback,$num,$orderby,$is_childclass,$page_style,$page_str,$sql_like,$keyword);
  return $get_hr_list;
 }
}
}





/*global $base;
  echo $base->get_product_list(1,0,"",false,"<classid><classname><proname>",20,"",false,4,"");
exit;*/

//unset($base);//销毁类实例

//接收参数
$module=safe_replace(safe_html(isset($_GET["m"]))) ? safe_replace(safe_html($_GET["m"])) : "index";
$class_file=safe_replace(safe_html(isset($_GET["c"]))) ? safe_replace(safe_html($_GET["c"])) : "index";
$module_path=Module_Dir.$module."/".$class_file.".php"; //模块文件路径
if(!file_exists($module_path))die(Echo_ErrMsg("加载模块[".$module."]失败，模块文件不存在。","javascript:window.close();")); //检查文件是否存在
include $module_path;   //加载模块文件