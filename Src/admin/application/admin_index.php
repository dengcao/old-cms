<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
!defined('IN_CMS') && exit('Access Denied');
?>
<title>网站后台管理系统</title>
</head>
<frameset style="width:100%;text-align:center;" border=0 name=topset id="topset" framespacing=0 rows=88,* frameborder=no>
<frame name=topframe src="admin.php?action=top" noresize scrolling="no">
<frameset border=0 name=middleset id="middleset" framespacing=0 rows=* frameborder=no cols=167,*>
<frame name=leftframe id="leftframe" src="admin.php?action=left" noresize scrolling="no">
<frameset border=0 framespacing=0 rows=* frameborder=no cols=10,*>
<frame name=spliterframe src="admin.php?action=switch" noresize scrolling="no">
<frame name=mainframe id="mainframe" src="admin.php?action=main">
</frameset></frameset></frameset>

<noframes><body>
对不起，您的浏览器不支持框架！请使用IE6以上的浏览器登陆网站后台管理系统。
</body>
</noframes></html>