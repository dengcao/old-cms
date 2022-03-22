<?php
   !defined('IN_CMS') && exit('Access Denied');
   global $conn;
   $Action2=trim($_POST["action2"]);
   if (!$Action2){
	$Action2=trim($_GET["action2"]);
	}
	
  if($Action2!="my"){
	  CheckUserPopedom("administrator");//检查已登陆管理员是否具备管理此页面的权限
	  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>维护管理用户</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>

<?php
if($Action2=="add"){
?>
<form action="admin.php?action=admin_op" method="post" name="Add" id="Add">
<table cellSpacing="0"  cellPadding="" width="98%" align="center"
				 border="0">
				<tr>
					<td>
						<table width="100%"  border="0" align="center" cellPadding="0"  cellSpacing="0" bgcolor="#F3F8FF">
							<TBODY>
								<tr>
									<td  colSpan="3" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">添加管理用户</span></td>
								</tr>
								<tr>
								  <td width="1%"  align="center"></td>
									<td width="12%" height="0"  align="center"></td>
									<td width="87%" ></td>
								</tr>
								<tr>
								  <td height="10" colspan="3" ></td>
							  </tr>
								
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">管理员帐号：</td>
									<td ><input name="AdminName" type="text"  id="AdminName" title=" 请输入用户新帐号!" maxlength="60" style="width:150px" /><font color="#ff0000">*
										</font>（6-20字符，请不要输入如<font color="#ff0000">
											&amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">登陆密码：</td>
									<td ><input name="AdminPassword1" type="password"  id="AdminPassword1" title=" 请输入用户新密码！" maxlength="60" style="width:150px" /><font color="#ff0000">*
										</font>
									（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center" >&nbsp;</td>
									<td align="right" >验证密码：</td>
								  <td ><input name="AdminPassword2" type="password"  id="AdminPassword2" title=" 请输入验证新密码！" maxlength="60" style="width:150px" /><font color="#ff0000">* </font>（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">真实姓名：</td>
					    <td ><input name="RealName" type="text"  id="RealName" title=" 请输入真实姓名!" maxlength="60" style="width:150px" /><font color="#ff0000">*										</font>（6-20字符，请不要输入如<font color="#ff0000">
											&amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">联系电话：</td>
								  <td ><input name="Mobile" type="text"  id="Mobile" title=" 请输入联系电话!" maxlength="60" style="width:150px" /></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">邮箱地址：</td>
								  <td ><input name="Email" type="text"  id="Email" title=" 请输入邮箱地址!" maxlength="60" style="width:150px" /></td>
								</tr>
								
								
								<tr>
									<td align="center" >&nbsp;</td>
									<td  height="25" align="right">是否启用：</td>
								  <td><input name="AdminPassed" type="CheckBox" value="1" checked />
								  <font color="#ff0000"></font></td>
								</tr>
								<tr>
								  <td align="center" >&nbsp;</td>
								  <td  height="25" align="right"><span class="bgcolor4">管理权限：</span></td>
								  <td><span class="bgcolor1">
	<?php
		$user_popedom=UserPopedom();
		foreach($user_popedom as $key=>$value){		
		?>
        <input name="UserPopedom[]" type="checkbox" value="<?=$key?>" checked /><?=$value?>
		<?php
		$i+=1;
		if(($i%7)==0){echo "<br>";}
        }
		?>
                                  </span></td>
							  </tr>
								<tr>
								  <td  align="center"></td>
									<td  align="center" height="1"></td>
									<td ></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td  align="center" height="25">&nbsp;</td>
								  <td height="45" >
									<input name="Submit" type="Submit" class="button" value=" 提 交 " title=" 单击提交表单！ " />
									<input  type="reset" value=" 重 置 " name="Submit2" /> <input  onClick="window.location.reload()" type="button" value=" 刷 新 " name="Submit3" /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /><input name="Action2" type="hidden" id="Action2" value="Add" /></td>
								</tr>
							</TBODY>
					  </table>
					</td>
				</tr>
			</table>
			
			
			
  
</form>
<?php
}else if($_GET["id"]){
	
$AdminID=$_GET["id"];

$sql=mysql_query("select * from pl_admin where AdminID=".$AdminID,$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

<form action="admin.php?action=admin_op" method="post" name="Mod" id="Mod">
<table cellSpacing="0"  cellPadding="" width="98%" align="center"
				 border="0">
				<tr>
					<td>
						<table width="100%"  border="0" align="center" cellPadding="0"  cellSpacing="0" bgcolor="#F3F8FF">
							<TBODY>
								<tr>
									<td  colSpan="3" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">修改管理用户</span></td>
								</tr>
								<tr>
								  <td width="1%"  align="center"></td>
									<td width="12%" height="0"  align="center"></td>
									<td width="87%" ></td>
								</tr>
								<tr>
								  <td height="10" colspan="3" ></td>
							  </tr>
								
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">管理员帐号：</td>
								  <td ><input name="AdminName" type="text"  id="AdminName" style="width:150px"  value="<?php echo $myrow['AdminName'];?>" maxlength="60" />
									<font color="#ff0000">*								    </font>（6-20字符，请不要输入如<font color="#ff0000">
										  &amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">登陆密码：</td>
									<td ><input name="AdminPassword1" type="password"  id="AdminPassword1" title=" 请输入用户新密码！" maxlength="60" style="width:150px" />
									<font color="#ff0000">*										</font>
									（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center" >&nbsp;</td>
									<td align="right" >验证密码：</td>
									<td ><input name="AdminPassword2" type="password"  id="AdminPassword2" title=" 请输入验证新密码！" maxlength="60" style="width:150px" />
								    <font color="#ff0000">* </font>（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">真实姓名：</td>
								  <td ><input name="RealName" type="text"  id="RealName" style="width:150px" title=" 请输入真实姓名!" value="<?php echo $myrow['RealName'];?>" maxlength="60" />
								  <font color="#ff0000">*										</font> （6-20字符，请不要输入如<font color="#ff0000">
											&amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">联系电话：</td>
								  <td ><input name="Mobile" type="text"  id="Mobile" style="width:150px" title=" 请输入联系电话!" value="<?php echo $myrow['Mobile'];?>" maxlength="60" /></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">邮箱地址：</td>
								  <td ><input name="Email" type="text"  id="Email" style="width:150px" title=" 请输入邮箱地址!" value="<?php echo $myrow['Email'];?>" maxlength="60" /></td>
								</tr>
								
								
								<tr>
									<td align="center" >&nbsp;</td>
									<td  height="25" align="right">是否启用：</td>
								  <td><input name="AdminPassed" type="CheckBox" value="1" <?php if ($myrow['AdminPassed']==1){echo " checked";}?> />
								  <font color="#ff0000"></font></td>
								</tr>
								<tr>
								  <td align="center" >&nbsp;</td>
								  <td  height="25" align="right"><span class="bgcolor4">管理权限：</span></td>
								  <td><span class="bgcolor1">
        <?php
		$NowPopedom=explode(",",$myrow['UserPopedom']);//当前权限数组
		$user_popedom=UserPopedom();//系统权限数组
		foreach($user_popedom as $key=>$value){		
		?>
        <input name="UserPopedom[]" type="checkbox" value="<?=$key?>"<?php if(is_str_in_array($key,$NowPopedom)){?> checked<?php }?> /><?=$value.$NowPopedom[$key]?>
		<?php
		$i+=1;
		if(($i%7)==0){echo "<br>";}
        }
		?>
								  </span><br /><br /><font color="#777777">(提示：修改权限后须重新登陆账号才生效。)</font><br />&nbsp;</td>
							  </tr>
								<tr>
									<td align="center" >&nbsp;</td>
									<td  height="25" align="right">其它信息：</td>
								  <td>登陆IP：<font color="#FF0000"><?php echo $myrow['LastLoginIP'];?></font>&nbsp;&nbsp;登陆时间：<font color="#FF0000"><?php echo $myrow['LastLoginTime'];?></font>&nbsp;&nbsp;登陆次数：<font color="#FF0000"><?php echo $myrow['LoginTimes'];?></font>								 </td>
								</tr>
								<tr>
								  <td  align="center"></td>
									<td  align="center" height="1"></td>
									<td ></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td  align="center" height="25">&nbsp;</td>
								  <td height="45" >
									<input name="Submit" type="Submit" class="button" value=" 提 交 "  title=" 单击提交表单！ " />
									<input  type="reset" value=" 重 置 " name="Submit2" /> <input  onClick="window.location.reload()" type="button" value=" 刷 新 " name="Submit3" />  <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /><input name="Action2" type="hidden" id="Action2" value="Mod" /><input name="AdminID" type="hidden" id="AdminID" value="<?php echo $myrow['AdminID'];?>" /></td>
								</tr>
							</TBODY>
					  </table>
					</td>
				</tr>
			</table>

</form>
<?php
}
}else if($Action2=="my"){
	
$AdminID=$_SESSION["adminid"];

$sql=mysql_query("select * from pl_admin where AdminID=".$AdminID,$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

<form action="admin.php?action=admin_op" method="post" name="Mod" id="Mod">
<table cellSpacing="0"  cellPadding="" width="98%" align="center"
				 border="0">
				<tr>
					<td>
						<table width="100%"  border="0" align="center" cellPadding="0"  cellSpacing="0" bgcolor="#F3F8FF">
							<TBODY>
								<tr>
									<td  colSpan="3" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">修改管理用户</span></td>
								</tr>
								<tr>
								  <td width="1%"  align="center"></td>
									<td width="12%" height="0"  align="center"></td>
									<td width="87%" ></td>
								</tr>
								<tr>
								  <td height="10" colspan="3" ></td>
							  </tr>
								
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">管理员帐号：</td>
								  <td ><input name="AdminName" type="text"  id="AdminName" style="width:150px" readonly="readonly"  value="<?php echo $myrow['AdminName'];?>" maxlength="60" />
									<font color="#ff0000">*								    </font>（6-20字符，请不要输入如<font color="#ff0000">
										  &amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">登陆密码：</td>
									<td ><input name="AdminPassword1" type="password"  id="AdminPassword1" title=" 请输入用户新密码！" maxlength="60" style="width:150px" />
									<font color="#ff0000">*										</font>
									（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center" >&nbsp;</td>
									<td align="right" >验证密码：</td>
									<td ><input name="AdminPassword2" type="password"  id="AdminPassword2" title=" 请输入验证新密码！" maxlength="60" style="width:150px" />
								    <font color="#ff0000">* </font>（6-20字符）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">真实姓名：</td>
								  <td ><input name="RealName" type="text"  id="RealName" style="width:150px" title=" 请输入真实姓名!" value="<?php echo $myrow['RealName'];?>" maxlength="60" />
								  <font color="#ff0000">*										</font> （6-20字符，请不要输入如<font color="#ff0000">
											&amp;?&amp;;,'% </font>之类的字符！）</td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">联系电话：</td>
								  <td ><input name="Mobile" type="text"  id="Mobile" style="width:150px" title=" 请输入联系电话!" value="<?php echo $myrow['Mobile'];?>" maxlength="60" /></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td height="25" align="right">邮箱地址：</td>
								  <td ><input name="Email" type="text"  id="Email" style="width:150px" title=" 请输入邮箱地址!" value="<?php echo $myrow['Email'];?>" maxlength="60" /></td>
								</tr>
								<tr>
								  <td align="center" >&nbsp;</td>
								  <td  height="25" align="right"><span class="bgcolor4">管理权限：</span></td>
								  <td><span class="bgcolor1">
        <?php
		$NowPopedom=explode(",",$myrow['UserPopedom']);//当前权限数组
		$user_popedom=UserPopedom();//系统权限数组
		foreach($user_popedom as $key=>$value){		
		?>
        <input name="UserPopedom[]" type="checkbox" disabled="disabled" readonly="readonly" value="<?=$key?>"<?php if(is_str_in_array($key,$NowPopedom)){?> checked<?php }?> /><?=$value.$NowPopedom[$key]?>
		<?php
		$i+=1;
		if(($i%7)==0){echo "<br>";}
        }
		?>
								  </span></td>
							  </tr>
								<tr>
									<td align="center" >&nbsp;</td>
									<td  height="25" align="right">其它信息：</td>
								  <td>登陆IP：<font color="#FF0000"><?php echo $myrow['LastLoginIP'];?></font>&nbsp;&nbsp;登陆时间：<font color="#FF0000"><?php echo $myrow['LastLoginTime'];?></font>&nbsp;&nbsp;登陆次数：<font color="#FF0000"><?php echo $myrow['LoginTimes'];?></font>								 </td>
								</tr>
								<tr>
								  <td  align="center"></td>
									<td  align="center" height="1"></td>
									<td ></td>
								</tr>
								<tr>
								  <td  align="center">&nbsp;</td>
									<td  align="center" height="25">&nbsp;</td>
								  <td height="45" >
									<input name="Submit" type="Submit" class="button" value=" 提 交 "  title=" 单击提交表单！ " />
									<input  type="reset" value=" 重 置 " name="Submit2" /> <input  onClick="window.location.reload()" type="button" value=" 刷 新 " name="Submit3" /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /><input name="Action2" type="hidden" id="Action2" value="my_Mod" /></td>
								</tr>
							</TBODY>
					  </table>
					</td>
				</tr>
			</table>

</form>
<?php
}
}

else{
?>

<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table cellSpacing="0" cellPadding="0" width="100%" border="0">
                          <tr>
                            <td height="3"></td>
                          </tr>
                        </table>
						<table width="100%" border="0" align="center" cellPadding="0"  cellSpacing="0" bgcolor="#F3F8FF">
							<tr>
								<td colSpan="7" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">管理用户列表</span></td>
							</tr>
							<tr>
							  <td colSpan="7" height="10"></td>
						  </tr>
							<tr>
								<td align="center">
								
								
								
								
								
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#C8DDD9" >
          
          
          <tr align="center"  bgcolor="#DDEEEB" class="list_title">
            <td width="8%" height="30" class="red12">编号</td>
            <td width="12%" class="red12">管理员帐号</td>
			<td width="12%" class="red12">真实姓名</td>
            <td width="17%" class="red12">登陆IP</td>
            <td width="16%" class="red12">登陆时间</td>
            <td width="12%" class="red12">登陆次数</td>
			<td width="7%" class="red12">是否启用</td>
            <td width="8%" class="red12">修改信息</td>
            <td width="8%" class="red12">删除信息</td>
          </tr>
         
<?php
$sql="select * from pl_admin order by AdminID asc";
$pl_SQL=mysql_query($sql,$conn);

include '../system/libs/page.inc.php';
$options = array(
	'total_rows' => mysql_num_rows($pl_SQL),//总行数
	'list_rows'  => '10',  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=mysql_query($sql." limit $page->first_row , $page->list_rows",$conn);//执行查询
for($i=0;$i<count($info=mysql_fetch_array($sql_query));$i++){//循环输出数据库中数据
    if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}
?>
          <tr bgcolor="<?=$bgcolor?>" >
            <td align="center"><?=$info[AdminID]?></td>
            <td align="center"><?=$info[AdminName]?></td>
			<td align="center"><?=$info[RealName]?></td>
            <td align="center"><?=$info[LastLoginIP]?></td>
            <td align="center"><?=$info[LastLoginTime]?></td>
            <td align="center"><?=$info[LoginTimes]?></td>
			
			<td align="center">
            <?php
			if ($info[AdminPassed] == 1){
		echo "<font color=red><b>√</b></font>";
	}else{
		echo "<font color=red><b>×</b></font>";
	}
			?>
			</td>
            <td align="center">
			<a href="admin.php?action=admin&id=<?=$info[AdminID]?>">修改</a>
			</td>
            <td align="center"><a href="admin.php?action=admin_op&AdminID=<?=$info[AdminID]?>&Action2=Del" onClick="return confrim();">删除</a>
		    </td>
          </tr>
<?php 
}
?>

<tr bgcolor="#F3F8FF" >
            <td height="25" colspan="9" align="center">            
            <div class="main_list_showpage">  
            
            <style type="text/css">
            #page{font:12px/16px arial;text-align:center}
            #page span{margin:0px 3px;}
            #page a{margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
            #page a.now_page,#page a:hover{color:#fff;background:#7db1d8}
            </style>
            <div id="page">          
            <?php
            echo $page->show(1); //打印样式,1,2,3,4
			?>
            </div>
            
              </div></td>
          </tr>
          
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="9" align="center" ><input name="reload" type="button" class="button" id="reload"  title=" 单击刷新当前页面！ " onClick="window.location.reload()" value=" 刷 新 " /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /></td>
          </tr>

      </table>							
								
								</td>
							</tr>
							
							
					  </table>
				  </td>
				</tr>
			</table>
			
<?php
}

mysql_close($conn);	
require_once 'application/admin_footer.php';		//调用脚部
?>
</body>
</html>