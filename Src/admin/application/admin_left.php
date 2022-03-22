<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
!defined('IN_CMS') && exit('Access Denied');

$left_get=$_GET["get"]
?>
<title>左边部分-后台管理系统</title>
<link href="Css/pl.css" rel="stylesheet" />
<script language="javascript">
//侧边菜单导航
function showchild(nowlist,i){
var tt="Main_left_list_"+i;
if (document.getElementById(tt).style.display=="none"){
document.getElementById(tt).style.display='';
nowlist.style.cssText="background:url(Images/Main_left_list_arr2.gif) no-repeat 9px 5px;";
}
else{
document.getElementById(tt).style.display='none';
nowlist.style.cssText="background:url(Images/Main_left_list_arr.gif) no-repeat 9px 5px;";
}
}</script>

</head>

<?php function config(){?>
<div class="Skin_Main_left_head">网站设置</div>
<ul>
<li><a href="admin.php?action=webconfig" target="mainframe">网站配置</a></li>
<li><a href="admin.php?action=label" target="mainframe">标签管理</a></li>
<li><a href="admin.php?action=label&action_app=add" target="mainframe">添加标签</a></li>
<li><a href="admin.php?action=channel&parentid_all=4" target="mainframe">栏目列表</a></li>
<li><a href="admin.php?action=channel&parentid_all=4&action_app=add" target="mainframe">添加栏目</a></li>
</ul>
<?php }?>

<?php function admin(){?>
<div class="Skin_Main_left_head">网站管理员</div>
<ul>
<li><a href="admin.php?action=admin" target="mainframe">管理员列表</a></li>
<li><a href="admin.php?action=admin&action2=add" target="mainframe">添加管理员</a></li>
<li><a href="admin.php?action=admin&action2=my" target="mainframe">修改我的信息</a></li>
</ul>
<?php }?>

<?php function member(){?>
<div class="Skin_Main_left_head">网站会员</div>
<ul>
<li><a href="admin.php?action=member" target="mainframe">会员列表</a></li>
<li><a href="admin.php?action=member&action2=add" target="mainframe">添加会员</a></li>
</ul>
<?php }?>

<?php function product(){?>
<div class="Skin_Main_left_head">产品管理</div>
<ul>
<li><a href="admin.php?action=class&parentid_all=1" target="mainframe">产品分类</a></li>
<li><a href="admin.php?action=class&action_app=add&parentid_all=1" target="mainframe">添加分类</a></li>
<li><a href="admin.php?action=product" target="mainframe">产品列表</a></li>
<li><a href="admin.php?action=product&action_app=add" target="mainframe">添加产品</a></li>
</ul>
<?php }?>

<?php function article(){?>
<div class="Skin_Main_left_head">新闻管理</div>
<ul>
<li><a href="admin.php?action=class&parentid_all=2" target="mainframe">新闻分类</a></li>
<li><a href="admin.php?action=class&action_app=add&parentid_all=2" target="mainframe">添加分类</a></li>
<li><a href="admin.php?action=article" target="mainframe">新闻列表</a></li>
<li><a href="admin.php?action=article&action_app=add" target="mainframe">添加新闻</a></li>
</ul>
<?php }?>

<?php function feedback(){?>
<div class="Skin_Main_left_head">留言管理</div>
<ul>
<li><a href="admin.php?action=class&parentid_all=3" target="mainframe">留言分类</a></li>
<li><a href="admin.php?action=class&action_app=add&parentid_all=3" target="mainframe">添加分类</a></li>
<li><a href="admin.php?action=feedback" target="mainframe">留言列表</a></li>
<li><a href="admin.php?action=feedback&action_app=add" target="mainframe">添加留言</a></li>
</ul>
<?php }?>

<?php function webtool(){?>
<div class="Skin_Main_left_head">网站工具</div>
<ul>
<li><a href="admin.php?action=database" target="mainframe">数据库管理</a></li>
<li><a href="admin.php?action=clear_web_cache" target="mainframe">清空页面缓存</a></li>
<li><a href="admin.php?action=webfiles" target="mainframe">空间统计</a></li>
<li><a href="http://www.diannao.wang/tool/" target="_blank">站长工具</a></li>
<li><a href="admin.php?action=phptanzhen" target="mainframe">PHP探针</a></li>
</ul>
<?php }?>

<?php function service(){?>
<div class="Skin_Main_left_head">在线客服</div>
<ul>
<li><a href="admin.php?action=service" target="mainframe">客服列表</a></li>
<li><a href="admin.php?action=service&action_app=add" target="mainframe">添加客服</a></li>
</ul>
<?php }?>

<?php function hr(){?>
<div class="Skin_Main_left_head">人才招聘</div>
<ul>
<li><a href="admin.php?action=class&parentid_all=7" target="mainframe">招聘分类</a></li>
<li><a href="admin.php?action=class&action_app=add&parentid_all=7" target="mainframe">添加分类</a></li>
<li><a href="admin.php?action=hr" target="mainframe">招聘列表</a></li>
<li><a href="admin.php?action=hr&action_app=add" target="mainframe">添加招聘</a></li>
</ul>
<?php }?>

<body>
<!--Page Left--->
<div class="Main_left" id="Main_left">
<!--第二种左栏样式--->
<div class="Skin_Main_left">
<?php
switch ($left_get){
case "config":
config();
break;
case "admin":
admin();
break;
case "article":
article();
break;
case "product":
product();
break;
case "feedback":
feedback();
break;
case "member":
member();
break;
case "webtool":
webtool();
break;
case "service":
service();
break;
case "hr":
hr();
break;
default:
config();
break;
}
?>

</div>
<!--第二种左栏样式--->

</div>
<!--Page Left-->
</body>
</html>