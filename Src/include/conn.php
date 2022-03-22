<?php
//数据库配置信息
define('DB_HOST', 'localhost'); //数据库服务器主机地址
define('DB_USER', 'root'); //数据库帐号
define('DB_PW', 'root'); //数据库密码
define('DB_NAME', 'old_cms'); //数据库名
define('DB_PRE', 'pl_'); //数据库表前缀
define('DB_CHARSET', 'utf8'); //数据库字符集
define('DB_PCONNECT', 0); //0 或1，是否使用持久连接

!defined('IN_CMS') && exit('Access Denied');
require_once(SYS_BASE_PATH_ROOT."system/libs/mysql.inc.php");//加载数据库连接类