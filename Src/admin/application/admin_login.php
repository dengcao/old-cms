<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="css/Login.css" rel="stylesheet" type="text/css" />
<?php
!defined('IN_CMS') && exit('Access Denied');
?>
<title>网站后台管理系统登陆</title>
<script language='JavaScript'> 
if (top.location != self.location)top.location=self.location;
</script>
<script language='JavaScript' src='Js/ValiDate.js'></script>
</head>

<body id="loginbody" oncontextmenu=self.event.returnValue=false>
    <form name="UserLogin" method="post" action="admin.php?action=LoginCheck" onSubmit="return CheckFormLogin();">

    <div id="wrap">
	<div id="loginBox">
		<h1>品络后台管理系统</h1>
		<h2>用户登录</h2>
		<ul>
			<li><label for="UserName">用户名：</label>
			    <input name="UserName" type="text" maxlength="20" id="UserName" class="inText" />
			</li>
			<li><label for="UserPassword">密　码：</label>
			    <input name="UserPassword" type="password" maxlength="50" id="UserPassword" class="inText" />
			</li>
			<li id="LiSiteManageCode" class="text">
			    <label for="CheckCode">验证码：</label>
			    <input name="CheckCode" type="text" maxlength="20" id="CheckCode" class="inText" style="width:98px;" /> <img src="admin.php?action=validatorcode&now=<?php echo time();?>" align="absmiddle" style="cursor:pointer" onClick="this.src+='?'+parseInt(Math.random()*10)" alt="看不清楚？点击更换下一张。">
			</li>
			
		</ul>
		<div id="buttonBar">
		    <input type="submit" name="IbtnEnter" style="cursor:pointer" value="登录管理平台" id="IbtnEnter" class="loginButton" />
		</div>
		<div class="errorMsg">
		    
		</div>
		<p id="copyRight">&copy;<a href="https://gitee.com/caozha" target="_blank" title="我的码云"><font color="#999999">邓草</font></a></p>
	</div>	
    </div>
</div>
</form>
<script language="javascript">
<!--
function CheckFormLogin()
{
	var ObjUserLogin = document.UserLogin;
	
	//判断输入的内容
	/*if (ObjUserLogin.UserName.value == "")
	{
		alert("用户帐号不能为空,请您输入!");
		ObjUserLogin.UserName.focus();
	}*/
	if ( IsBlank( ObjUserLogin.UserName,"管理员帐号" ) )
		return false;
	if ( IsBlank( ObjUserLogin.UserPassword,"登陆密码" ) )
		return false;
	if ( IsBlank( ObjUserLogin.CheckCode,"验证码" ) )
		return false; 
	if ( CheckNumber( ObjUserLogin.CheckCode,"验证码" ) ) 
		return false;
	ObjUserLogin.submit();
}

	//定位光标的位置
	SetFocus(document.UserLogin.UserName);
	 
//-->
</script>
</body>
</html>