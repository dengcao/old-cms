<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
!defined('IN_CMS') && exit('Access Denied');
?>
<title>网站后台管理系统</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css">
</head>

<body>
<br>
		<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2"><table width="550" height="42" border="0" cellpadding="0" cellspacing="0" background="Images/Manage/01.jpg">
						<tr>
							<td width="21">&nbsp;</td>
							<td width="177" class="15green">网站后台管理中心</td>
							<td width="352" class="15green">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="2%" height="340" valign="top"><img src="Images/Manage/01_2.jpg" width="13" height="297"></td>
				<td width="98%" valign="bottom"><table width="100%" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td bgcolor="#DDEEEB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="4%" align="center"><img src="Images/Manage/12.gif" width="7" height="7"></td>
										<td width="96%" class="eng"><strong>Welcome to</strong> <span class="red"><strong>our 
													website </strong></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F1F9F5">
						<tr>
							<td height="302" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td class="15blue">&nbsp;</td>
									</tr>
									<tr>
										<td height="38" class="15green">尊敬的管理员[<?=$_SESSION["adminname"]?>]，您好！欢迎登陆网站后台管理系统！</td>
									</tr>
									
												
											
									<tr>
										<td>
											<table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#bdc6de">
												<tr>
													<td></td>
												</tr>
											</table>
											
											<table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
												<tr>
													<td></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
										
												<tr>
													<td height="18">&nbsp;</td>
													<td height="18" colspan="2">&nbsp;</td>
												</tr>
												<tr>
													<td height="27" colspan="2" class="main12"><strong>&nbsp;&nbsp;&nbsp;系统特别提示：</strong></td>
													<td width="33%" rowspan="6" align="center" valign="top" class="main12"><!--iframe src="http://m.weather.com.cn/m/pn12/weather.htm " width="205" height="110" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" allowtransparency="true"></iframe--></td>
												</tr>
												<tr>
													<td width="4%" height="27">&nbsp;</td>
													<td width="63%" height="27" style="font-size:12px; color:#666">在线编辑器应用页面如下载不完全，敬请刷新页面再操作！</td>
												</tr>
												<tr>
													<td height="27">&nbsp;</td>
													<td height="27" style="font-size:12px;color:#666">请定期下载备份网站源文件、数据库及修改登陆密码！维护好网络安全，以免造成不必要的损失！
													</td>
												</tr>
												<tr>
												  <td height="47" colspan="2" class="main12"> </td>
										  </tr>
												<tr>
												  <td>&nbsp;</td>
												  <td style="font-size:12px;color:#666"><!--script language="JavaScript" src="http://www.caozha.com/api/getnews/"></script--></td>
										  </tr>
												</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<?php
require_once 'application/admin_footer.php';		//调用脚部
?>
</body>
</html>
