<?php
!defined('IN_CMS') && exit('Access Denied');

//启用Smarty模板引擎
require_once(SYS_BASE_PATH_ROOT.'system/smarty/Smarty.class.php');	//加载Smarty类库文件
		$smarty = new Smarty;
		$smarty->debugging = false; //调试模式
		$smarty->caching = WEB_ISCACHE; //是否开启缓存
		$smarty->cache_lifetime = WEB_CACHE_TIME; //缓存周期，秒
		$smarty->template_dir = Template_Path_Current; //定义模板文件存储位置
		$smarty->compile_dir = SYS_BASE_PATH_ROOT."system/templates_c/"; //定义编译文件存储位置
		$smarty->config_dir = SYS_BASE_PATH_ROOT."templates/".Template_FOLDER."/configs/"; //定义配置文件存储位置
		$smarty->cache_dir = SYS_BASE_PATH_ROOT."cache/"; //定义缓存文件存储位置
		/*  定义定界符  */
		$smarty->left_delimiter = "{";
		$smarty->right_delimiter = "}";