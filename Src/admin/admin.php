<?php
require_once("../include/config.inc.php");
!defined('IN_CMS') && exit('Access Denied');
$action=$_GET["action"];
if($action!="login" && $action!="validatorcode" && $action!="LoginCheck"){
require_once("../include/conn.php");
require_once("include/class.php");
pl_session_open();//启用session
Check_Admin();//检查权限
}

switch($action){
	case "login";//登陆
	    require_once("application/admin_login.php");
		break;
	case "validatorcode";//验证码
	    require_once("../include/conn.php");
	    require_once("include/class.php");
	    ValidatorCode();
		break;
	case "LoginCheck";//登陆验证	    
	    require_once("../include/conn.php");
        require_once("include/class.php");
		CheckComeUrl();//检查来路
		pl_session_open();//启用session
	    $AdminName=pl_safe($_POST["UserName"]);
        $AdminPassword=pl_safe($_POST["UserPassword"]);
        $validatorCode=pl_safe($_POST["CheckCode"]);
	    Login_check($AdminName,$AdminPassword,$validatorCode);
		break;
	case "logout";//退出登陆
		Logout();
		break;
	case "index";//后台首页
	    require_once("application/admin_index.php");
		break;
	case "top";//后台头部
	    require_once("application/admin_top.php");
		break;
	case "left";//后台左边
	    require_once("application/admin_left.php");
		break;
	case "upload_img";//上传图片框
	    require_once("application/upload/up_img.php");
		break;	
	case "switch";//后台中间
	    require_once("application/admin_switch.php");
		break;
	case "main";//后台主体首页
	    require_once("application/admin_main.php");
		break;
	case "admin";//后台管理员
	    require_once("application/admin/index.php");
		break;
	case "admin_op";//后台管理员操作
	    require_once("application/admin/index2.php");
		break;
	case "webconfig";//设置
	    require_once("application/webconfig/index.php");
		break;
	case "class";//分类
	    require_once("application/class/index.php");
		break;
	case "product";//产品
	    require_once("application/product/index.php");
		break;
	case "article";//文章
	    require_once("application/article/index.php");
		break;
	case "feedback";//留言
	    require_once("application/feedback/index.php");
		break;
	case "member";//会员
	    require_once("application/member/index.php");
		break;
	case "channel";//栏目
	    require_once("application/channel/index.php");
		break;
	case "label";//标签
	    require_once("application/label/index.php");
		break;
	case "webfiles";//空间统计
	    require_once("application/tool/webfiles.php");
		break;
	case "phptanzhen";//PHP探针
	    require_once("application/tool/phptanzhen.php");
		break;
	case "database";//数据库管理
	    require_once("application/tool/database.php");
		break;
	case "service";//在线客服
	    require_once("application/service/index.php");
		break;
	case "hr";//人才招聘
	    require_once("application/hr/index.php");
		break;
	case "clear_web_cache";//清空页面缓存
	    require_once("application/tool/clear_web_cache.php");
		break;
	}