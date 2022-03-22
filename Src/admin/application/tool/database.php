<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("database");//检查已登陆管理员是否具备管理此页面的权限
global $conn;
$action_app=$_POST["action_app"];
if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
	
switch ($action_app){
   case "check":
	$tables=$_POST["tables"];	
	if ($tables==""){
	   echo_js("alert('请先选择数据表！');history.back();");
	   exit;
	   }
	$result=mysql_query("CHECK TABLE ".$tables,$conn);
	    if ($result){
	       echo_js("alert('检查数据表成功！');location.href=\"admin.php?action=database\";");
		   }else{
		   echo_js("alert('检查数据表失败！');history.back();");
			   }
			
	mysql_close($conn);
	break;
   case "optimize":
	$tables=$_POST["tables"];	
	if ($tables==""){
	   echo_js("alert('请先选择数据表！');history.back();");
	   exit;
	   }
	$tables = array_to_string($tables);//将数组转换为字符串，中间以“,”分隔
	$result=mysql_query("OPTIMIZE TABLE ".$tables,$conn);
	    if ($result){
	       echo_js("alert('优化数据表成功！');location.href=\"admin.php?action=database\";");
		   }else{
		   echo_js("alert('优化数据表失败！');history.back();");
			   }
			
	mysql_close($conn);
	break;
   case "repair":
	$tables=$_POST["tables"];	
	if ($tables==""){
	   echo_js("alert('请先选择数据表！');history.back();");
	   exit;
	   }
	$tables = array_to_string($tables);//将数组转换为字符串，中间以“,”分隔
	$result=mysql_query("REPAIR TABLE ".$tables,$conn);
	    if ($result){
	       echo_js("alert('修复数据表成功！');location.href=\"admin.php?action=database\";");
		   }else{
		   echo_js("alert('修复数据表失败！');history.back();");
			   }			
	mysql_close($conn);
	break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>维护数据库</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css">
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>
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
								<td colSpan="7" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">数据库管理</span></td>
							</tr>
							<tr>
							  <td colSpan="7" height="10"></td>
						  </tr>                          
                         
                          
							<tr>
								<td align="center" width="100%">
								
								
	<form action="admin.php?action=database" method="post" name="list" id="list">							
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#96B3D1" >          
          
          <tr align="center" bgcolor="#DDEEEB" class="list_title">
            <td width="6%" height="25" class="red12">选择</td>
            <td width="20%" class="red12">数据表名</td>
            <td width="13%" class="red12">引擎类型</td>
            <td width="14%" class="red12">整理</td>
            <td width="13%" class="red12">更新时间</td>
            <td width="12%" class="red12">记录条数</td>
            <td width="11%" class="red12">使用空间</td>
            <td width="11%" class="red12">多余碎片</td>
          </tr>
         
         
<?php
	$tables=ShowSql_tablelist();
	if(is_array($tables)) foreach($tables as $k => $tableinfo){
			$i+=1;
	if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}
		?>
	 	<tr bgcolor="<?=$bgcolor?>">
		    <td class="align_c" align="center"><input type="checkbox" name="tables[]" value="<?=$tableinfo['name']?>" checked /></td>
		    <td align="left" class="align_l"><?=$tableinfo['name']?></td>
		    <td align="center" class="align_l"><?=$tableinfo['engine']?></td>
		    <td align="center" class="align_l"><?=$tableinfo['collation']?></td>
		    <td align="center" class="align_l"><?=$tableinfo['update_time']?></td>
		    <td class="align_c" align="center"><?=$tableinfo['rows']?></td>
			<td align="center" class="align_l"><?php echo pl_sizecount($tableinfo['size']);?></td>
			<td align="center" class="align_l"><?php echo pl_sizecount($tableinfo['data_free']);?></td>
		</tr>
		<?php
		$table_size+=$tableinfo['size'];
		$table_data_free+=$tableinfo['data_free'];
		}
		?>
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="8" align="right" style="padding-right:25px;">共有数据表：<?=$i?> 个，数据表合计大小：<?=pl_sizecount($table_size)?>，碎片：<?=pl_sizecount($table_data_free)?></td>
          </tr>
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="8" align="center" >
            <input name="chkall" type="checkbox" value="" class="button" onClick="javascript:CheckAll(this.form)">
			<input style="display:none" name="Submit1" type="submit" class="button" value="检查表" onClick="this.form.action_app.value='check'" >			
            <input name="Submit2" type="submit" class="button" value="优化表" onClick="this.form.action_app.value='optimize';" >
            <input name="Submit3" type="submit" class="button" value="修复表" onClick="this.form.action_app.value='repair'" >	
                <input name="reload" type="button" class="button" id="reload" onClick="window.location.reload()" value="刷新"> <input  onClick="history.back();" type="button" value="返回" name="Submit4">
           &nbsp;&nbsp;
            <input name="action_app" type="hidden" id="action_app" value=""></td>
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
mysql_close($conn);	
require_once 'application/admin_footer.php';		//调用脚部
?>
</body>
</html>