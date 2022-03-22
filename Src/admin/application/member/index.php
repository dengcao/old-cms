<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("member");//检查已登陆管理员是否具备管理此页面的权限
global $conn;
$action2=$_POST["action2"];

if (!$action2){
	$action2=trim($_GET["action2"]);
	}
switch ($action2){
   case "saveadd";
	$username=trim($_POST["username"]);
	$password=md5($_POST["password"]);
	$nickname=trim($_POST["nickname"]);
	$xingbie=trim($_POST["xingbie"]);
	$QQ=trim($_POST["QQ"]);
	$email=trim($_POST["email"]);
	$jifen=trim($_POST["jifen"]);
	$locked=trim($_POST["locked"]);
	$jianjie=trim($_POST["jianjie"]);
	$shenhe=trim($_POST["shenhe"]);
	if (!is_numeric($jifen)){$jifen=0;}
	if ($username==""){
	   echo_js("alert('用户名不能为空！');history.back();");
	   exit;
	   }
	$sql = mysql_query("select * from pl_member where username='".$username."'",$conn) or die('执行错误');//执行查询;	
	$info=mysql_num_rows($sql);//获取查询结果
	    if ($info>0){
	    echo_js("alert('用户名[".$username."]已经存在！请您重新输入！');history.back();");
	    exit;
		}else{
			$nowtimes=date('Y-m-d H:i:s',time());
			$result=mysql_query("insert into pl_member set username='$username',password='$password',nickname='$nickname',xingbie=$xingbie,QQ='$QQ',email='$email',regtime='$nowtimes',logintime='$nowtimes',jifen=$jifen,logincount=0,locked=$locked,jianjie='$jianjie',shenhe=$shenhe",$conn);
	        if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=member\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
			}
	mysql_close($conn);
	break;
   case "saveedit";
    $userid=trim($_POST["userid"]);
    $username=trim($_POST["username"]);
	$password=trim($_POST["password"]);
	$nickname=trim($_POST["nickname"]);
	$xingbie=trim($_POST["xingbie"]);
	$QQ=trim($_POST["QQ"]);
	$email=trim($_POST["email"]);
	$jifen=trim($_POST["jifen"]);
	$locked=trim($_POST["locked"]);
	$jianjie=trim($_POST["jianjie"]);
	$shenhe=trim($_POST["shenhe"]);
	if (!is_numeric($jifen)){$jifen=0;}
	if ($username==""){
	   echo_js("alert('用户名不能为空！');history.back();");
	   exit;
	   }
	$sql = mysql_query("select * from pl_member where username='".$username."' and userid<>$userid",$conn) or die('执行错误');//执行查询;	
	$info=mysql_num_rows($sql);//获取查询结果
	    if ($info>0){
	    echo_js("alert('用户名[".$username."]已经存在！请您重新输入！');history.back();");
	    exit;
		}else{
			if ($password){
			  $password=md5($password);
			  $result=mysql_query("update pl_member set username='$username',password='$password',nickname='$nickname',xingbie=$xingbie,QQ='$QQ',email='$email',jifen=$jifen,locked=$locked,jianjie='$jianjie',shenhe=$shenhe where userid=$userid",$conn);
			  }else{
			  $result=mysql_query("update pl_member set username='$username',nickname='$nickname',xingbie=$xingbie,QQ='$QQ',email='$email',jifen=$jifen,locked=$locked,jianjie='$jianjie',shenhe=$shenhe where userid=$userid",$conn);
				  }
	        if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=member\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
			}
	mysql_close($conn);
	break;
	case "del";
	$userid=$_GET["userid"];
	Delmember($userid);
	break;
	case "ListDel";
	$userid=$_POST["deluserid"];
	  if (is_array($userid)){
    	$userid=implode(",",$userid);//将数组转换为字符
	    Delmember($userid);}
	break;
	}	
	
function Delmember($userid){//批量删除数据
	global $conn;
	if (!$userid){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_member where userid in(".$userid.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=member\";");
	}else{
		   echo_js("alert('删除失败！');history.back();");
			   }
		}
	mysql_close($conn);
	exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>会员管理</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css">
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>

<?php
if ($action2=="add"){
?>

<script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="../ueditor1/editor_all.js"></script>--> 
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css" />
    
<form action="admin.php?action=member" method="post" name="memberadd" id="memberadd">
<br>
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">添加会员</span></td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
							  <td height="14" align="center">&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
							<tr>
								<td width="15%" height="37" align="right">用户名：</td>
								<td>
								  <input name="username" type="text"  id="username" size="25" maxlength="255">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">密码：</td>
								<td>
								  <input name="password" type="password"  id="password" size="25" maxlength="100">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">Email：</td>
								<td>
								  <input name="email" type="text"  id="email" size="25" maxlength="255">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">昵称：</td>
								<td>
								  <input name="nickname" type="text"  id="nickname" size="25" maxlength="255"></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">性别：</td>
								<td>
								  <input name="xingbie" type="radio" value="1" />男 <input type="radio" name="xingbie" value="2" />女 <input type="radio" name="xingbie" value="0" checked="checked" />保密</td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">QQ：</td>
								<td>
								  <input name="QQ" type="text"  id="QQ" size="25" maxlength="11"></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">积分：</td>
								<td>
								  <input name="jifen" type="text"  id="jifen" size="15" maxlength="11" value="0"></td>
							</tr>
							<tr>
								<td height="37" align="right">是否锁定：</td>
							  <td><input name="locked" type="radio" id="locked" value="1" />是 <input type="radio" name="locked" id="locked" value="0" checked="checked" />否</td>
							</tr>
                            <tr>
								<td height="37" align="right">审核：</td>
							  <td><input name="shenhe" type="radio" id="shenhe1" value="1" checked="checked" />审核通过 <input type="radio" name="shenhe" id="shenhe2" value="2" />审核不通过 <input type="radio" name="shenhe" id="shenhe3" value="0" />未审核</td>
							</tr>
                            <tr>
								<td height="37" align="right">会员简介：</td>
							  <td>
                              <script type="text/plain" id="jianjie" name="jianjie" style="width:600px;"></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:320,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'jianjie' );
</script>
                              </td>
							</tr>
							<tr>
								<td height="15" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" title=" 单击刷新当前页面！ " onClick="window.location.reload()"
										value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action2" type="hidden" id="action2" value="saveadd"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
  
</form>
<?php
}else if(is_numeric($_GET["userid"])){
	
$sql=mysql_query("select * from pl_member where userid=".$_GET["userid"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

<script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="../ueditor1/editor_all.js"></script>--> 
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css" />
    
<form action="admin.php?action=member" method="post" name="memberedit" id="memberedit">
<br>
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">编辑会员资料</span></td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
                            <tr>
							  <td height="14" align="center">&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
							<tr>
								<td width="15%" height="37" align="right">用户名：</td>
								<td>
								  <input name="username" type="text"  id="username" size="25" maxlength="255" value="<?php echo $myrow['username'];?>">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">密码：</td>
								<td>
								  <input name="password" type="password"  id="password" size="25" maxlength="100" value="">
									如不修改，请留空</td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">Email：</td>
								<td>
								  <input name="email" type="text"  id="email" size="25" maxlength="255" value="<?php echo $myrow['email'];?>">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">昵称：</td>
								<td>
								  <input name="nickname" type="text"  id="nickname" size="25" maxlength="255" value="<?php echo $myrow['nickname'];?>"></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">性别：</td>
								<td>
								  <input name="xingbie" type="radio" value="1"<?php if($myrow['xingbie']==1){echo " checked=\"checked\"";}?> />男 <input type="radio" name="xingbie" value="2"<?php if($myrow['xingbie']==2){echo " checked=\"checked\"";}?> />女 <input type="radio" name="xingbie" value="0"<?php if($myrow['xingbie']==0){echo " checked=\"checked\"";}?> />保密</td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">QQ：</td>
								<td>
								  <input name="QQ" type="text"  id="QQ" size="25" maxlength="11" value="<?php echo $myrow['QQ'];?>"></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">积分：</td>
								<td>
								  <input name="jifen" type="text"  id="jifen" size="15" maxlength="11" value="<?php echo $myrow['jifen'];?>"></td>
							</tr>
							<tr>
								<td height="37" align="right">是否锁定：</td>
							  <td><input name="locked" type="radio" id="locked" value="1"<?php if($myrow['locked']==1){echo " checked=\"checked\"";}?> />是 <input type="radio" name="locked" id="locked" value="0"<?php if($myrow['locked']==0){echo " checked=\"checked\"";}?> />否</td>
							</tr>
                            <tr>
								<td height="37" align="right">审核：</td>
							  <td><input name="shenhe" type="radio" id="shenhe1" value="1"<?php if($myrow['shenhe']==1){echo " checked=\"checked\"";}?> />审核通过 <input type="radio" name="shenhe" id="shenhe2" value="2"<?php if($myrow['shenhe']==2){echo " checked=\"checked\"";}?> />审核不通过 <input type="radio" name="shenhe" id="shenhe3" value="0"<?php if($myrow['shenhe']==0){echo " checked=\"checked\"";}?> />未审核</td>
							</tr>
                            <tr>
								<td height="37" align="right">会员简介：</td>
							  <td>
                              <script type="text/plain" id="jianjie" name="jianjie" style="width:600px;"><?=$myrow['jianjie']?></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:320,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'jianjie' );
</script>
                              </td>
							</tr>
                            
                            <tr>
								<td width="15%" height="37" align="right">注册时间：</td>
								<td><?php echo $myrow['regtime'];?></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">登陆时间：</td>
								<td><?php echo $myrow['logintime'];?></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">登陆次数：</td>
								<td><?php echo $myrow['logincount'];?></td>
							</tr>
                            <tr>
								<td width="15%" height="37" align="right">已绑定：</td>
								<td><?php if($myrow['opentype']==1){echo "QQ，Openid：".$myrow['openid'];}else if($myrow['opentype']==2){echo "新浪微博，Openid：".$myrow['openid'];};?></td>
							</tr>
                            
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" title=" 单击刷新当前页面！ " onClick="window.location.reload()" value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action2" type="hidden" id="action2" value="saveedit"><input name="userid" type="hidden" id="userid" value="<?php echo $myrow['userid'];?>"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
  
</form>
<?php
 }
}else{
?>


<table cellSpacing="0" cellPadding="0" width="98%" align="center"
				 border="0">
				<tr>
					<td>
						<table cellSpacing="0" cellPadding="0" width="100%" border="0">
                          <tr>
                            <td height="3"></td>
                          </tr>
                        </table>
						<table width="100%" border="0" align="center" cellPadding="0"  cellSpacing="0" bgcolor="#F3F8FF">
							<tr>
								<td colSpan="7" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">会员列表</span></td>
							</tr>
							<tr>
							  <td colSpan="7" height="10"></td>
						  </tr>
							<tr>
							  <td colSpan="7" align="center">
                              <form action="admin.php?action=member" method="post" name="memberlist" id="memberlist">
                              <input name="keyword" type="text"  id="SearchKeyword"  value="" size="40" maxlength="60" >
                              <select name="searchselect" id="SearchSelect">
                                <option>--类型--</option>
                                <option value="username">用户名</option>
                                <option value="nickname">昵称</option>
                                <option value="QQ">QQ</option>
                                <option value="email">Email</option>
                                <option value="opentype">绑定</option>
                              </select>
                              <select name="searchshenhe" id="searchshenhe">
                                <option value="">--审核--</option>
                                <option value="0">等待审核</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核不通过</option>
                              </select>
                              <input name="Submit" type="submit"  value=" 搜索 ">
							  <input type="reset" value=" 重置 " name="Submit">
                              </form>
                              
                              </td>
						  </tr>
                          
                          
                          
							<tr>
								<td align="center" width="100%">	
	
    <form action="admin.php?action=member" method="post" name="memberlist" id="memberlist">
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#96B3D1" >          
          
          <tr align="center" bgcolor="#DDEEEB" class="list_title">
            <td width="10%" height="25" class="red12">编号</td>
            <td width="13%" class="red12">用户名</td>
            <td width="13%" class="red12">昵称</td>
			<td width="12%" class="red12">Email</td>
            <td width="3%" class="red12">性别</td>
            <td width="6%" class="red12">积分</td>
            <td width="12%" class="red12">注册日期</td>
            <td width="12%" class="red12">登陆日期</td>            
            <td width="3%" class="red12">锁定</td>                
            <td width="4%" class="red12">审核</td> 
            <td width="6%" class="red12">修改</td>
            <td width="6%" class="red12">删除</td>
          </tr>
         
<?php
$keyword=$_POST["keyword"];
if ($keyword==""){
	$keyword=$_GET["keyword"];
	}

$sql="select * from pl_member where userid>0";
if ($keyword!=""){
	$keyword=trim($keyword);
	$searchselect=$_POST["searchselect"];
	if (!$searchselect){
	$searchselect=$_GET["searchselect"];
	}
	switch($searchselect){
		case "username":
	      $sql.=" and username like '%".$keyword."%'";
		  break;
		case "nickname":
	      $sql.=" and nickname like '%".$keyword."%'";
		  break;
		case "QQ":
	      $sql.=" and QQ like '%".$keyword."%'";
		  break;
		case "email":
	      $sql.=" and email like '%".$keyword."%'";
		  break;
		case "opentype":
	      $sql.=" and opentype = ".$keyword."";
		  break;
		default:
		  $sql.=" and (username like '%".$keyword."%' or nickname like '%".$keyword."%' or QQ like '%".$keyword."%' or email like '%".$keyword."%')";
		  break;
	}
  }
  
$searchshenhe=$_POST["searchshenhe"];
if (!$searchshenhe){
	$searchshenhe=$_GET["searchshenhe"];
	}
if ($searchshenhe!=""){
	$sql.=" and shenhe = ".$searchshenhe."";
	}
  
$sql.=" order by userid desc";

$pl_SQL_result=mysql_query(str_ireplace("*"," count(*) as total ",$sql),$conn);
$all_mysql_num_rows=mysql_result($pl_SQL_result,0,'total'); //变量表示查询出结果的数量

include '../system/libs/page.inc.php';
$options = array(
	'total_rows' => $all_mysql_num_rows,//总行数
	'list_rows'  => '20',  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=mysql_query($sql." limit $page->first_row , $page->list_rows",$conn);//执行查询

$get_my_num_rows=mysql_num_rows($sql_query);//获取总数
for($i=0;$i<$get_my_num_rows;$i++){//循环输出数据库中数据
    $info=mysql_fetch_array($sql_query);
    if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}
?>
          <tr bgcolor="<?=$bgcolor?>" >
            <td align="center"><?=$info[userid]?><input name="userid[]" type="hidden" value="<?=$info[userid]?>"></td>
            <td align="left"><a href="admin.php?action=member&userid=<?=$info[userid]?>"><?=$info[username]?></a></td>
            <td align="left"><a href="admin.php?action=member&userid=<?=$info[userid]?>"><?=$info[nickname]?></a></td>
			<td align="left"><?=$info[email]?></td>
            <td align="center"><?php if($info[xingbie]==1){echo "男";}else if($info[xingbie]==2){echo "女";}else{echo "保密";}?></td>
            <td align="center"><?=$info[jifen]?></td>
            <td align="center"><?=$info[regtime]?></td>
            <td align="center"><?=$info[logintime]?></td>
            <td align="center"><?php if($info[locked]==1){echo "是";}else if($info[locked]==0){echo "否";}else{echo "未知";}?></td>
            <td align="center"><?php if($info[shenhe]==1){echo "通过";}else if($info[shenhe]==2){echo "不过";}else if($info[shenhe]==0){echo "<font color=red>未审</font>";}?></td>
            <td align="center">
              <a href="admin.php?action=member&userid=<?=$info[userid]?>">修改</a>  
            </td>
            <td align="center">                        
              <input name="deluserid[]" type="checkbox" value="<?=$info[userid]?>" >
              <a href="admin.php?action=member&action2=del&userid=<?=$info[userid]?>" onClick="return confrim();">删除</a>              
		    </td>
          </tr>
   <?php 
}
?>

          
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="12" align="center" >
            <div style="margin:5px auto 25px auto;">  
            
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
            
              </div>			
              <input name="Submit2" type="submit" class="button" value="删除选定" onClick="this.form.action2.value='ListDel'" >
<input name="chkall" type="checkbox" value="" class="button" onClick="javascript:CheckAll(this.form)">
<input name="Submit3" type="reset" class="button" value="重置表单">  
                <input name="reload" type="button" class="button" id="reload" onClick="window.location.reload()" value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4">
           &nbsp;&nbsp;
            <input name="action2" type="hidden" id="action2" value=""></td>
          </tr>
	
      </table>
		</form>	
								
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