<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("service");//检查已登陆管理员是否具备管理此页面的权限
$parentid_all=13;//定义标签的总分类ID
$item_name_all="在线客服";//定义项目总名称，比如标签
global $conn;
$action_app=$_POST["action_app"];
if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
	
switch ($action_app){
   case "saveadd":
	$classid=trim($_POST["classid"]);
	$s_type=trim($_POST["s_type"]);
	$name=trim($_POST["name"]);
	$username=trim($_POST["username"]);
	$gotourl=trim($_POST["gotourl"]);
	$orderid=trim($_POST["orderid"]);
	if (!is_numeric($classid)){$classid=0;}
	if (!is_numeric($orderid)){$orderid=0;}
	
	if ($name==""){
	   echo_js("alert('客服名称为空！');history.back();");
	   exit;
	   }
	if ($username==""){
	   echo_js("alert('账号为空！');history.back();");
	   exit;
	   }	
		$sql_into="insert into pl_service set classid=$classid,s_type=$s_type,name='$name',username='$username',gotourl='$gotourl',orderid=$orderid";
			$result=mysql_query($sql_into,$conn);
	        if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=service\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
	mysql_close($conn);
	break;
   case "saveedit":
    $id=trim($_POST["id"]);
    $classid=trim($_POST["classid"]);
	$s_type=trim($_POST["s_type"]);
	$name=trim($_POST["name"]);
	$username=trim($_POST["username"]);
	$gotourl=trim($_POST["gotourl"]);
	$orderid=trim($_POST["orderid"]);
	if (!is_numeric($classid)){$classid=0;}
	if (!is_numeric($orderid)){$orderid=0;}
	
	if ($id==""){
	   echo_js("alert('参数丢失！');history.back();");
	   exit;
	   }
	if ($name==""){
	   echo_js("alert('客服名称为空！');history.back();");
	   exit;
	   }
	if ($username==""){
	   echo_js("alert('账号为空！');history.back();");
	   exit;
	   }
			$sql_edit="update pl_service set classid=$classid,s_type=$s_type,name='$name',username='$username',gotourl='$gotourl',orderid=$orderid where id=$id";
			$result=mysql_query($sql_edit,$conn);
	        if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=service\";");
		   }else{
		   echo_js("alert('修改成功！');history.back();");
			   }
	mysql_close($conn);
	break;
	case "del":
	$id=trim($_GET["id"]);
	Del($id);
	break;
	case "ListDel":
	$id=$_POST["delid"];
	   if (is_array($id)){
	       $id=implode(",",$id);//将数组转换为字符
	       Del($id);}
    break;
	case "rank":
	$id=$_POST["id"];
	$rank=$_POST["rank"];
	updateRank($id,$rank);
	break;
	}
	
function updateRank($id,$rank){//更新排序
    global $conn;
	if (!$id&&!$rank){
		echo_js("alert('请先选择要更新的数据！');history.back();");
	    exit;
		}else{
			foreach($id as $key=>$value){				
				if (!is_numeric($rank[$key])){$rank[$key]=0;}
			    $result=mysql_query("update pl_service set orderid='$rank[$key]' where id=$value",$conn);
			}
			   if ($result){
	               echo_js("alert('更新成功！');location.href=\"admin.php?action=service\";");
	           }else{
		           echo_js("alert('更新失败！');history.back();");
			   }
		}
	mysql_close($conn);
	exit;
	}
	
function Del($id){//批量删除数据
	global $conn;
	if (!$id){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_service where id in(".$id.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=service\";");
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>维护<?=$item_name_all?></title>
<link href="Css/pl.css" rel="stylesheet" type="text/css" />
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>

<?php
if ($action_app=="add"){
?>
    
<form action="admin.php?action=service" method="post" name="add" id="add">
<br />
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">添加<?=$item_name_all?></span></td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td width="86%"></td>
							</tr>
							<tr>
							  <td height="14" align="center">&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
                          <tr style="display:none">
								<td width="14%" height="37" align="right"><?=$item_name_all?>分类：</td>
								<td><select name="classid" id="classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">客服类型：</td>
								<td><select name="s_type" id="s_type" onchange="show_s_type();">
                                    <option value="1">QQ</option>
                                    <option value="2">邮箱</option>
                                    <option value="3">电话</option>
                                    <option value="4">MSN</option>                                    
                                    <option value="5">Skype</option>
                                    <option value="6">微博</option>
                                    <option value="7">新浪UC</option>
                                    <option value="8">网易泡泡</option>                                    
                                    <option value="0">其他</option>
                                </select>
                                <script language="javascript">
                                function show_s_type(){
									//var this_option=document.getElementById("s_type").options[document.getElementById("s_type").selectedIndex].value;
									var this_option_name=document.getElementById("s_type").options[document.getElementById("s_type").selectedIndex].innerHTML;
									document.getElementById("s_type_text").innerHTML=this_option_name;
									}
                                </script>
                                </td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right">客服名称：</td>
								<td>
								  <input name="name" type="text" id="name" size="60" maxlength="255"  style="width:150px;" />
									<font color="#ff0000">*</font> <font color="#999999">如客服姓名、昵称等，前台直接显示</font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><span id="s_type_text">账号</span>：</td>
								<td>
								  <input name="username" type="text"  id="username" size="60" maxlength="255"  style="width:150px;" /> <font color="#ff0000">*</font> <font color="#999999">填写客服的账号，如电话号、QQ号，email等账号</font>
                              </td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right">打开网址：</td>
								<td>
								  <input name="gotourl" type="text"  id="gotourl" size="60" maxlength="500"  style="width:250px;" /> <font color="#999999">前台点击后打开的网址，如此处不设置，系统将用默认的方式</font>
                              </td>
							</tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" />
								<font color="#FF0000"> *</font>（数字，越大越靠前）</td>
							</tr>                           
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 " />
									<input name="reset" type="reset" value=" 重 置 " /> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 " /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveadd" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>			
  
</form>

<?php
}else if($action_app=="edit"){
	
$sql=mysql_query("select * from pl_service where id=".$_GET["id"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

<form action="admin.php?action=service" method="post" name="edit" id="edit">
<br />
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">编辑<?=$item_name_all?></span></td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td width="86%"></td>
							</tr>
							<tr>
							  <td height="14" align="center">&nbsp;</td>
							  <td>&nbsp;</td>
						  </tr>
                          <tr style="display:none">
								<td width="14%" height="37" align="right"><?=$item_name_all?>分类：</td>
								<td><select name="classid" id="classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$myrow['classid'],0);
									?>
                                </select></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">客服类型：</td>
								<td><select name="s_type" id="s_type" onchange="show_s_type();">
                                    <option value="1"<?php if($myrow['s_type']==1){echo " selected=\"selected\"";}?>>QQ</option>
                                    <option value="2"<?php if($myrow['s_type']==2){echo " selected=\"selected\"";}?>>邮箱</option>
                                    <option value="3"<?php if($myrow['s_type']==3){echo " selected=\"selected\"";}?>>电话</option>
                                    <option value="4"<?php if($myrow['s_type']==4){echo " selected=\"selected\"";}?>>MSN</option>
                                    <option value="5"<?php if($myrow['s_type']==5){echo " selected=\"selected\"";}?>>Skype</option>
                                    <option value="6"<?php if($myrow['s_type']==6){echo " selected=\"selected\"";}?>>微博</option>
                                    <option value="7"<?php if($myrow['s_type']==7){echo " selected=\"selected\"";}?>>新浪UC</option>
                                    <option value="8"<?php if($myrow['s_type']==8){echo " selected=\"selected\"";}?>>网易泡泡</option>
                                    <option value="0"<?php if($myrow['s_type']==0){echo " selected=\"selected\"";}?>>其他</option>
                                </select>
                                <script language="javascript">
                                function show_s_type(){
									//var this_option=document.getElementById("s_type").options[document.getElementById("s_type").selectedIndex].value;
									var this_option_name=document.getElementById("s_type").options[document.getElementById("s_type").selectedIndex].innerHTML;
									document.getElementById("s_type_text").innerHTML=this_option_name;
									}
                                </script>
                                </td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right">客服名称：</td>
								<td>
								  <input name="name" type="text" id="name" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['name']?>" />
									<font color="#ff0000">*</font> <font color="#999999">如客服姓名、昵称等，前台直接显示</font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><span id="s_type_text"><?=get_service_s_type_name($myrow['s_type'])?></span>：</td>
								<td>
								  <input name="username" type="text"  id="username" size="60" maxlength="255"  style="width:150px;" value="<?php echo $myrow['username'];?>" /> <font color="#ff0000">*</font> <font color="#999999">填写客服的账号，如电话号、QQ号，email等账号</font>
                              </td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right">打开网址：</td>
								<td>
								  <input name="gotourl" type="text"  id="gotourl" size="60" maxlength="500"  style="width:250px;" value="<?php echo $myrow['gotourl'];?>" /> <font color="#999999">前台点击后打开的网址，如此处不设置，系统将用默认的方式</font>
                              </td>
							</tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" value="<?php echo $myrow['orderid'];?>" size="13" maxlength="11" />
								<font color="#FF0000"> *</font>（数字，越大越靠前）</td>
							</tr>                           
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 " />
									<input name="reset" type="reset" value=" 重 置 " /> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 " /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveedit" /><input name="id" type="hidden" id="id" value="<?php echo $myrow['id'];?>" /></td>
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
								<td colSpan="7" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title"><?=$item_name_all?>列表</span></td>
							</tr>
							<tr>
							  <td colSpan="7" height="10"></td>
						  </tr>
                          
                          <tr>
							  <td colSpan="7" align="center">
                              <form action="admin.php?action=service" method="get" name="searchlist" id="searchlist">
                              <input name="keyword" type="text"  id="SearchKeyword"  value="" size="40" maxlength="60" />
                              <select name="searchclassid" id="searchclassid">
                                    <option value="" selected="selected">--<?=$item_name_all?>分类--</option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select>
                              <select name="searchselect" id="searchselect">
                                <option value="">--搜索选项--</option>
                                <option value="name">客服名称</option>
                                <option value="username">客服账号</option>
                              </select>
                              <input name="Submit" type="submit"  value=" 搜索 " />
							  <input type="reset" value=" 重置 " name="Submit" />
                              <input name="action" type="hidden" value="service" />
                              </form>
                              
                              </td>
						  </tr>
                          
							<tr>
								<td align="center" width="100%">
								
								
								
								
	<form action="admin.php?action=service" method="post" name="list" id="list">							
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#96B3D1" >          
          
          <tr align="center" bgcolor="#DDEEEB" class="list_title">
            <td width="9%" height="25" class="red12">编号</td>
            <td width="20%" class="red12">客服名称</td>
            <td width="13%" class="red12">账号类型</td>
            <td width="26%" class="red12">客服账号</td>
            <td width="12%" class="red12">客服分类</td>
            <td width="8%" class="red12">显示顺序</td>			
            <td width="5%" class="red12">修改</td>
            <td width="7%" class="red12">删除</td>
          </tr>
         
<?php
$keyword=$_POST["keyword"];
if ($keyword==""){
	$keyword=$_GET["keyword"];
	}
$sql="select * from pl_service where id>0";
if ($keyword!=""){
	$keyword=trim($keyword);
	$searchselect=$_POST["searchselect"];
	if (!$searchselect){
	$searchselect=$_GET["searchselect"];
	}
	switch($searchselect){
		case "name":
	      $sql.=" and name like '%".$keyword."%'";
		  break;
		case "username":
	      $sql.=" and username like '%".$keyword."%'";
		  break;
		default:
		  $sql.=" and (name like '%".$keyword."%' or username like '%".$keyword."%') ";
		  break;
	}
  }
$searchclassid=trim($_POST["searchclassid"]);
if (!$searchclassid){
	$searchclassid=trim($_GET["searchclassid"]);
	} 
if (is_numeric($searchclassid) && $searchclassid!=""){
	$sql.=" and classid = ".$searchclassid."";
	}
	
$sql.=" order by orderid desc,id desc";

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
            <td align="center"><?=$info['id']?><input name="id[]" type="hidden" value="<?=$info['id']?>" /></td>
            <td align="left"> <a href="admin.php?action=service&id=<?=$info['id']?>&action_app=edit"><?=$info['name']?></a></td>           
            <td align="center"><?=get_service_s_type_name($info['s_type'])?></td>
            <td align="left"> <a href="<?=$info['gotourl']?>" target="_blank"><?=$info['username']?></a></td>
            <td align="center"> <a href="admin.php?action=service&searchclassid=<?=$info['classid']?>"><?=getClassName($info['classid'])?></a></td>
            <td align="center"><input name="rank[]" type="text" value="<?=$info['orderid']?>" size="8" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" /></td>
			
            <td align="center">
              <a href="admin.php?action=service&id=<?=$info['id']?>&action_app=edit">修改</a>  
            </td>
            <td align="center">                        
              <input name="delid[]" type="checkbox" value="<?=$info['id']?>" />
              <a href="admin.php?action=service&action_app=del&id=<?=$info['id']?>" onClick="return confrim();">删除</a>              
		    </td>
          </tr>
   <?php 
}
?>          
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="8" align="center" >
            <div style="margin:5px auto 25px auto;">  
            
            <style type="text/css">
            #page{font:12px/16px arial;text-align:center}
            #page span{margin:0px 3px;}
            #page a{margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
            #page a.now_page,#page a:hover{color:#fff;background:#7db1d8}
            </style>
            <div id="page">          
            <?php
            echo $page->show(4); //打印样式,1,2,3,4
			?>
            </div>
            
              </div>
            
			<input name="Submit" type="submit" class="button" value="更新排序" onClick="this.form.action_app.value='rank'" />
			
              <input name="Submit2" type="submit" class="button" value="删除选定" onClick="this.form.action_app.value='ListDel';return confrim();" />
<input name="chkall" type="checkbox" value="" class="button" onClick="javascript:CheckAll(this.form)" />
<input name="Submit3" type="reset" class="button" value="重置表单" />  
                <input name="reload" type="button" class="button" id="reload" onClick="window.location.reload()" value=" 刷 新 " /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" />
           &nbsp;&nbsp;
            <input name="action_app" type="hidden" id="action_app" value="" />

<br />
<div style="color:#999;padding:20px 0px 20px 20px;text-align:left;">温馨提示：要使用系统集成的在线客服功能，请先到网站配置里设置启用。</div>
</td>
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