<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
!defined('IN_CMS') && exit('Access Denied');
?>
<title>左边部分-后台管理系统</title>
<link href="Css/pl.css" rel="stylesheet" />
<script type="text/javascript">
function switchBar1(){

	var obj = window.top.document.getElementById('middleset');
	if(obj.cols=='0,*'){
        obj.cols='167,*'
	}
}

function switchBar2(){

	var obj = window.top.document.getElementById('middleset');
	if(obj.cols!='0,*'){
        obj.cols='0,*';
	}else{
        obj.cols='167,*';
	}
}
//if(top != self) {
//	top.location = self.location;
//}
</script>
</head>

<body onmouseover="switchBar1();" style="CURSOR:pointer;" onclick="switchBar2();" 
bgColor=#51c94f leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
<!--Page Middle-->
<div class="Middle_swich" id="switchSysBar"><img title="关闭/打开左栏" id="swith_botton" src="Images/middle_swith.gif" /></div>
<!--Page Middle-->
</body>
</html>
