<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
!defined('IN_CMS') && exit('Access Denied');
?>
<title>头部——后台管理系统</title>
<link href="Css/pl.css" rel="stylesheet" />
<script type="text/javascript">
function switchtop(){

	var obj = document.getElementById('head_01');
	var head= document.getElementById('head');
	var topset=window.top.document.getElementById('topset');
	if(obj.style.display == 'none'){
		obj.style.display = '';
		head.style.cssText="height:88px;";
	}else{
		obj.style.display = 'none';
		head.style.cssText="height:35px;";
	}
	if(topset.rows!='35,*'){
	topset.rows='35,*';
	window.scroll(0,88);
	}else{
	topset.rows='88,*'};
}

var mainframe=window.top.document.getElementById('mainframe');
var leftframe=window.top.document.getElementById('leftframe');

function main_reload(){
parent.mainframe.location.reload();
}
function main_print(){
parent.mainframe.focus();
parent.mainframe.print();
}

function Location_href(left,main){
parent.leftframe.location.href=left;
parent.mainframe.location.href=main;
}
</script>

</head>

<body>
<div id="container">
<!--页面顶部开始--->
<div class="head" id="head">
<div class="head_01" id="head_01">
<div class="logo"><a href="http://www.5300.cn" target="_blank"><img src="Images/logo.gif" /></a></div>
<div class="wzglxt"><ul><li class="wzglxt_01">网站后台管理</li><li class="wzglxt_02">WELCOME TO HERE !</li></ul></div>
<div class="head_link"><a href="../" target="_blank">网站首页</a> | <a href="admin.php?action=main" target="mainframe">管理首页</a> | <a href="admin.php?action=admin&action2=my" target="mainframe">修改密码</a> | <a href="http://caozha.com" target="_blank">关于我</a></div>
</div>
<!--导航开始-->
<div class="menu">
<ul>
<li class="menu_index"><a href="javascript:" onclick="Location_href('admin.php?action=left&get=config','admin.php?action=webconfig');">网站设置</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=admin','admin.php?action=admin');">管理员</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=member','admin.php?action=member');">会员管理</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=product','admin.php?action=product');">产品管理</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=article','admin.php?action=article');">新闻管理</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=feedback','admin.php?action=feedback');">留言反馈</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=hr','admin.php?action=hr');">人才招聘</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=service','admin.php?action=service');">在线客服</a></li>
<li><a href="javascript:" onclick="Location_href('admin.php?action=left&get=webtool','admin.php?action=database');">网站工具</a></li>
<li><a href="#" title="收缩到顶部" onclick="switchtop();">收缩</a></li><li><A onclick="main_reload();" href="#">刷新</A></li>
<li><a onclick="if (!window.confirm('您确认退出当前帐户吗？')){return false;}" href="admin.php?action=logout" target="mainframe">退出</a></li>
</ul>
</div>
</div>
<!--页面顶部结束--->
</div>
</body>
</html>