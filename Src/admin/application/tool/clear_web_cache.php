<?php
!defined('IN_CMS') && exit('Access Denied');
require_once("../include/conn.php");
require_once("include/class.php");
pl_session_open();//启用session
Check_Admin();//检查权限
define("LIBS_PATH",SYS_BASE_PATH_ROOT."system/libs/");
define("Module_Dir",SYS_BASE_PATH_ROOT."system/module/"); //定义模块文件夹
define("Template_FOLDER","default"); //定义模板文件夹
define("Template_Path_Root",SYS_BASE_PATH_ROOT."templates/"); //定义模板总路径
define("Template_Path_Current",Template_Path_Root.Template_FOLDER."/"); //定义当前模板路径
require_once(LIBS_PATH."smarty.inc.php");//加载模板引擎
// 删除全部缓存
$smarty->clearAllCache();
unset($smarty);//销毁类实例
$ErrMsg .= "<li>页面缓存清理成功！</li><br>";
WriteErrMsg($ErrMsg,"javascript:history.back();");
exit;	