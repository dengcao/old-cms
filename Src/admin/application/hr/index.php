<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("hr");//检查已登陆管理员是否具备管理此页面的权限
$parentid_all=7;//定义人才招聘的总分类ID
$item_name_all="招聘";//定义项目总名称，比如新闻
global $conn;
$action_app=$_POST["action_app"];
if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
	
switch ($action_app){
   case "saveadd":
    $classid=trim($_POST["classid"]);
	$hr_title=trim($_POST["hr_title"]);
	$hr_education=trim($_POST["hr_education"]);
	$hr_num=trim($_POST["hr_num"]);
	$hr_age=trim($_POST["hr_age"]);
	$hr_experience=trim($_POST["hr_experience"]);
	$hr_sex=trim($_POST["hr_sex"]);
	$hr_stature=trim($_POST["hr_stature"]);
	$hr_salary=trim($_POST["hr_salary"]);
	$hr_address=trim($_POST["hr_address"]);
	$hr_useful_life=trim($_POST["hr_useful_life"]);
	if (!is__date($hr_useful_life)){$hr_useful_life=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	$hr_content=trim($_POST["hr_content"]);		
	$updatetime=trim($_POST["updatetime"]);
	$hits=trim($_POST["hits"]);
	if (!is_numeric($hits)){$hits=0;}
	$orderid=trim($_POST["orderid"]);	
	if (!is_numeric($orderid)){$orderid=0;}
	$tuijian=$_POST["tuijian"];
	if (!is_numeric($tuijian)){$tuijian=0;}
	$shenhe=$_POST["shenhe"];
	if (!is_numeric($shenhe)){$shenhe=1;}
	if (!is__date($updatetime)){$updatetime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	
	if ($hr_title==""){
	   echo_js("alert('标题不能为空！');history.back();");
	   exit;
	   }
	$sql_into="insert into pl_hr set classid=$classid,hr_title='$hr_title',hr_education='$hr_education',hr_num='$hr_num',hr_age='$hr_age',hr_experience='$hr_experience',hr_sex='$hr_sex',hr_stature='$hr_stature',hr_salary='$hr_salary',hr_address='$hr_address',hr_useful_life='$hr_useful_life',hr_content='$hr_content',hits=$hits,updatetime='$updatetime',orderid=$orderid,tuijian=$tuijian,shenhe=$shenhe";
	$result=mysql_query($sql_into,$conn);
	        if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=hr\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
	mysql_close($conn);
	break;
   case "saveedit":
    $hrid=trim($_POST["hrid"]);
    $classid=trim($_POST["classid"]);
	$hr_title=trim($_POST["hr_title"]);
	$hr_education=trim($_POST["hr_education"]);
	$hr_num=trim($_POST["hr_num"]);
	$hr_age=trim($_POST["hr_age"]);
	$hr_experience=trim($_POST["hr_experience"]);
	$hr_sex=trim($_POST["hr_sex"]);
	$hr_stature=trim($_POST["hr_stature"]);
	$hr_salary=trim($_POST["hr_salary"]);
	$hr_address=trim($_POST["hr_address"]);
	$hr_useful_life=trim($_POST["hr_useful_life"]);
	if (!is__date($hr_useful_life)){$hr_useful_life=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	$hr_content=trim($_POST["hr_content"]);		
	$updatetime=trim($_POST["updatetime"]);
	$hits=trim($_POST["hits"]);
	if (!is_numeric($hits)){$hits=0;}
	$orderid=trim($_POST["orderid"]);	
	if (!is_numeric($orderid)){$orderid=0;}
	$tuijian=$_POST["tuijian"];
	if (!is_numeric($tuijian)){$tuijian=0;}
	$shenhe=$_POST["shenhe"];
	if (!is_numeric($shenhe)){$shenhe=1;}
	if (!is__date($updatetime)){$updatetime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	
	if ($hr_title==""){
	   echo_js("alert('标题不能为空！');history.back();");
	   exit;
	   }else if(!is_numeric($hrid)){
		echo_js("alert('参数传递错误！');history.back();");
	    exit;   
		   }
	$result=mysql_query("update pl_hr set classid=$classid,hr_title='$hr_title',hr_education='$hr_education',hr_num='$hr_num',hr_age='$hr_age',hr_experience='$hr_experience',hr_sex='$hr_sex',hr_stature='$hr_stature',hr_salary='$hr_salary',hr_address='$hr_address',hr_useful_life='$hr_useful_life',hr_content='$hr_content',hits=$hits,updatetime='$updatetime',orderid=$orderid,tuijian=$tuijian,shenhe=$shenhe where hrid=$hrid",$conn);
	if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=hr\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }

	mysql_close($conn);
	break;
	case "del":
	$hrid=trim($_GET["hrid"]);
	Del($hrid);
	break;
	case "ListDel":
	$hrid=$_POST["delid"];
	   if (is_array($hrid)){
	       $hrid=implode(",",$hrid);//将数组转换为字符
	       Del($hrid);}
    break;
	case "rank":
	$hrid=$_POST["hrid"];
	$rank=$_POST["rank"];
	updateRank($hrid,$rank);
	break;
	}
	
function updateRank($hrid,$rank){//更新排序
    global $conn;
	if (!$hrid&&!$rank){
		echo_js("alert('请先选择要更新的数据！');history.back();");
	    exit;
		}else{
			foreach($hrid as $key=>$value){				
				if (!is_numeric($rank[$key])){$rank[$key]=0;}
			    $result=mysql_query("update pl_hr set orderid='$rank[$key]' where hrid=$value",$conn);
			}
			   if ($result){
	               echo_js("alert('更新成功！');location.href=\"admin.php?action=hr\";");
	           }else{
		           echo_js("alert('更新失败！');history.back();");
			   }
		}
	mysql_close($conn);
	exit;
	}
	
function Del($hrid){//批量删除数据
	global $conn;
	if (!$hrid){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_hr where hrid in(".$hrid.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=hr\";");
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

     <script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
     <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>     
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css"/>    
    <script language="javascript" type="text/javascript" src="Js/My97DatePicker/WdatePicker.js"></script>
    
    
<form action="admin.php?action=hr" method="post" name="add" id="add">
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
                          <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>分类：</td>
								<td><select name="classid" id="classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select></td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>标题：</td>
								<td>
								  <input name="hr_title" type="text" id="hr_title" size="60" maxlength="255"  style="width:250px;" />
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">招聘人数：</td>
								<td>
								  <input name="hr_num" type="text"  id="hr_num" size="60" maxlength="255" style="width:150px;" value="" /> <font color="#999999">招聘人数，如填：1人，若干等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">学历要求：</td>
								<td>
								  <input name="hr_education" type="text"  id="hr_education" size="60" maxlength="255" style="width:150px;" value="" /> <font color="#999999">学历要求，如填：初中文化、中专、大学专科，大学本科，硕士，研究生等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">年龄要求：</td>
								<td>
								  <input name="hr_age" type="text"  id="hr_age" size="60" maxlength="255"  style="width:150px;" value="" /> <font color="#999999">年龄要求，如填：18至35岁</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">工作经验：</td>
								<td>
								  <input name="hr_experience" type="text"  id="hr_experience" size="60" maxlength="255"  style="width:150px;" /> <font color="#999999">工作经验，如填：不限、毕业生、至少1年工作经历等等</font>
                              </td>
							</tr>                            
                            <tr>
								<td width="14%" height="37" align="right">性别要求：</td>
								<td>
								  <input name="hr_sex" type="text"  id="hr_sex" size="60" maxlength="255"  style="width:150px;" /> <font color="#999999">性别要求，如填：男性，女性，不限等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">身高要求：</td>
								<td>
								  <input name="hr_stature" type="text"  id="hr_stature" size="60" maxlength="255"  style="width:150px;" /> <font color="#999999">身高要求，如填：不限，155CM以上等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">薪水待遇：</td>
								<td>
								  <input name="hr_salary" type="text"  id="hr_salary" size="60" maxlength="255"  style="width:150px;" /> <font color="#999999">薪水待遇，如填：面谈，3000元/月以上等等</font>
                              </td>
                            </tr>
                            <tr>
								<td width="14%" height="37" align="right">工作地点：</td>
								<td>
								  <input name="hr_address" type="text"  id="hr_address" size="60" maxlength="255"  style="width:150px;" /> <font color="#999999">比如：广州天河区，北京朝阳区等</font>
                              </td>
                            </tr>
                            <tr>
								<td width="14%" height="37" align="right">职位有效期：</td>
								<td>
								  <input name="hr_useful_life" type="text" id="hr_useful_life" value="<?=date('Y-m-d H:i:s',time())?>" readonly="readonly" size="12" onclick="WdatePicker({el:'hr_useful_life',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'hr_useful_life',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle" /></font>
                              </td>
                            </tr>
							<tr>
							  <td height="37" align="right">招聘详情：</td>
							  <td><br />
                              
                              <script type="text/plain" id="hr_content" name="hr_content" style="width:800px;"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.minFrameHeight=320;//编辑器高度
	window.UEDITOR_CONFIG.maximumWords=50000;//最多允许字符
	window.UEDITOR_CONFIG.autoHeightEnabled=true;//是否自动长高
	window.UEDITOR_CONFIG.autoFloatEnabled=false;//是否保持toolbar的位置不动
    var editor_a = new baidu.editor.ui.Editor();
    editor_a.render( 'hr_content' );
</script>

                              </td>
						  </tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" />
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="hits" type="text" id="hits" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" />&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<input name="updatetime" type="text" id="updatetime" value="<?=date('Y-m-d H:i:s',time())?>" readonly="readonly" size="12" onclick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle" /></td>
							</tr>
                            <tr>
								<td height="37" align="right">推荐：</td>
							  <td><input type="radio" name="tuijian" id="tuijian" value="1" />是 <input type="radio" name="tuijian" id="tuijian2" value="0" checked="checked" />否
									</td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="shenhe" id="shenhe1" value="0" />等待审核 <input name="shenhe" type="radio" id="shenhe2" value="1" checked="checked" />通过 <input type="radio" name="shenhe" id="shenhe3" value="2" />不通过</td>
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
	
$sql=mysql_query("select * from pl_hr where hrid=".$_GET["hrid"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

     <script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
     <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>     
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css"/>    
    <script language="javascript" type="text/javascript" src="Js/My97DatePicker/WdatePicker.js"></script>

<form action="admin.php?action=hr" method="post" name="edit" id="edit">
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
                          <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>分类：</td>
								<td><select name="classid" id="classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$myrow['classid'],0);
									?>
                                </select></td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>标题：</td>
								<td>
								  <input name="hr_title" type="text" id="hr_title" size="60" maxlength="255"  style="width:250px;" value="<?=$myrow['hr_title']?>" />
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">招聘人数：</td>
								<td>
								  <input name="hr_num" type="text"  id="hr_num" size="60" maxlength="255" style="width:150px;" value="<?=$myrow['hr_num']?>" /> <font color="#999999">招聘人数，如填：1人，若干等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">学历要求：</td>
								<td>
								  <input name="hr_education" type="text"  id="hr_education" size="60" maxlength="255" style="width:150px;" value="<?=$myrow['hr_education']?>" /> <font color="#999999">学历要求，如填：初中文化、中专、大学专科，大学本科，硕士，研究生等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">年龄要求：</td>
								<td>
								  <input name="hr_age" type="text"  id="hr_age" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['hr_age']?>" /> <font color="#999999">年龄要求，如填：18至35岁</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">工作经验：</td>
								<td>
								  <input name="hr_experience" type="text"  id="hr_experience" size="60" maxlength="255" style="width:150px;" value="<?=$myrow['hr_experience']?>" /> <font color="#999999">工作经验，如填：不限、毕业生、至少1年工作经历等等</font>
                              </td>
							</tr>                            
                            <tr>
								<td width="14%" height="37" align="right">性别要求：</td>
								<td>
								  <input name="hr_sex" type="text"  id="hr_sex" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['hr_sex']?>" /> <font color="#999999">性别要求，如填：男性，女性，不限等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">身高要求：</td>
								<td>
								  <input name="hr_stature" type="text"  id="hr_stature" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['hr_stature']?>" /> <font color="#999999">身高要求，如填：不限，155CM以上等等</font>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">薪水待遇：</td>
								<td>
								  <input name="hr_salary" type="text"  id="hr_salary" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['hr_salary']?>" /> <font color="#999999">薪水待遇，如填：面谈，3000元/月以上等等</font>
                              </td>
                            </tr>
                            <tr>
								<td width="14%" height="37" align="right">工作地点：</td>
								<td>
								  <input name="hr_address" type="text"  id="hr_address" size="60" maxlength="255"  style="width:150px;" value="<?=$myrow['hr_address']?>" /> <font color="#999999">比如：广州天河区，北京朝阳区等</font>
                              </td>
                            </tr>
                            <tr>
								<td width="14%" height="37" align="right">职位有效期：</td>
								<td>
								  <input name="hr_useful_life" type="text" id="hr_useful_life" value="<?=$myrow['hr_useful_life']?>" readonly="readonly" size="12" onclick="WdatePicker({el:'hr_useful_life',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'hr_useful_life',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle" /></font>
                              </td>
                            </tr>
							<tr>
							  <td height="37" align="right">招聘详情：</td>
							  <td><br />
                              
                              <script type="text/plain" id="hr_content" name="hr_content" style="width:800px;"><?=$myrow['hr_content']?></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.minFrameHeight=320;//编辑器高度
	window.UEDITOR_CONFIG.maximumWords=50000;//最多允许字符
	window.UEDITOR_CONFIG.autoHeightEnabled=true;//是否自动长高
	window.UEDITOR_CONFIG.autoFloatEnabled=false;//是否保持toolbar的位置不动
    var editor_a = new baidu.editor.ui.Editor();
    editor_a.render( 'hr_content' );
</script>

                              </td>
						  </tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" value="<?=$myrow['orderid']?>" size="13" maxlength="11" />
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="hits" type="text" id="hits" value="<?=$myrow['hits']?>" size="13" maxlength="11" />&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<input name="updatetime" type="text" id="updatetime" value="<?=$myrow['updatetime']?>" readonly="readonly" size="12" onclick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle" /></td>
							</tr>
                            <tr>
								<td height="37" align="right">推荐：</td>
							  <td><input type="radio" name="tuijian" id="tuijian" value="1"<?php if($myrow['tuijian']==1){?> checked="checked"<?php }?> />是 <input type="radio" name="tuijian" id="tuijian2" value="0"<?php if($myrow['tuijian']==0){?> checked="checked"<?php }?> />否
									</td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="shenhe" id="shenhe1" value="0"<?php if($myrow['shenhe']==0){?> checked="checked"<?php }?> />等待审核 <input name="shenhe" type="radio" id="shenhe2" value="1"<?php if($myrow['shenhe']==1){?> checked="checked"<?php }?> />通过 <input type="radio" name="shenhe" id="shenhe3" value="2"<?php if($myrow['shenhe']==2){?> checked="checked"<?php }?> />不通过</td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 " />
									<input name="reset" type="reset" value=" 重 置 " /> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 " /> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4" /> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveedit" /><input name="hrid" type="hidden" id="hrid" value="<?php echo $myrow['hrid'];?>" /></td>
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
                              <form action="admin.php?action=hr" method="get" name="searchlist" id="searchlist">
                              <input name="keyword" type="text"  id="SearchKeyword"  value="" size="40" maxlength="60" />
                              <select name="searchclassid" id="searchclassid">
                                    <option value="" selected="selected">--<?=$item_name_all?>分类--</option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select>
                              <select name="searchselect" id="searchselect">
                                <option value="">--类型--</option>
                                <option value="hr_title">标题</option>
                                <option value="hr_content">内容</option>
                              </select>
                              <select name="searchshenhe" id="searchshenhe">
                                <option value="">--状态--</option>
                                <option value="0">等待审核</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核不通过</option>
                              </select>
                              <input name="Submit" type="submit"  value=" 搜索 " />
							  <input type="reset" value=" 重置 " name="Submit" />
                              <input name="action" type="hidden" value="hr" />
                              </form>
                              
                              </td>
						  </tr>
                          
							<tr>
								<td align="center" width="100%">
								
								
								
								
	<form action="admin.php?action=hr" method="post" name="list" id="list">							
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#96B3D1" >          
          
          <tr align="center" bgcolor="#DDEEEB" class="list_title">
            <td width="9%" height="25" class="red12">编号</td>
            <td width="26%" class="red12"><?=$item_name_all?>标题</td>
            <td width="19%" class="red12">分类</td>
            <td width="12%" class="red12">发布时间</td>
            <td width="9%" class="red12">显示顺序</td>
			<td width="9%" class="red12">浏览次数</td>
            <td width="4%" class="red12">审核</td>
            <td width="5%" class="red12">修改</td>
            <td width="7%" class="red12">删除</td>
          </tr>
         
<?php
$keyword=$_POST["keyword"];
if ($keyword==""){
	$keyword=$_GET["keyword"];
	}
$sql="select * from pl_hr where hrid>0";
if ($keyword!=""){
	$keyword=trim($keyword);
	$searchselect=$_POST["searchselect"];
	if (!$searchselect){
	$searchselect=$_GET["searchselect"];
	}
	switch($searchselect){
		case "hr_title":
	      $sql.=" and hr_title like '%".$keyword."%'";
		  break;
		case "hr_content":
	      $sql.=" and hr_content like '%".$keyword."%'";
		  break;
		default:
		  $sql.=" and (hr_title like '%".$keyword."%' or hr_content like '%".$keyword."%')";
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
$searchshenhe=$_POST["searchshenhe"];
if (!$searchshenhe){
	$searchshenhe=$_GET["searchshenhe"];
	}
if ($searchshenhe!=""){
	$sql.=" and shenhe = ".$searchshenhe."";
	}	
$sql.=" order by orderid desc,updatetime desc,hrid desc";

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
            <td align="center"><?=$info['hrid']?><input name="hrid[]" type="hidden" value="<?=$info['hrid']?>" /></td>
            <td align="left"> <a href="admin.php?action=hr&hrid=<?=$info['hrid']?>&action_app=edit"><?=$info['hr_title']?></a><?php if($info['tuijian']==1){echo " <font color=red>(荐)</font>";}?></td>
            <td align="left"> <a href="admin.php?action=hr&searchclassid=<?=$info['classid']?>"><?=getClassName($info['classid'])?></a></td>
            <td align="center"><?=$info['updatetime']?></td>
            <td align="center"><input name="rank[]" type="text" value="<?=$info['orderid']?>" size="8" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" /></td>
			<td align="center"><?=$info['hits']?></td>
            <td align="center"><?php if($info['shenhe']==1){echo "通过";}else if($info['shenhe']==2){echo "<font color=\"#777777\">不通过</font>";}else if($info['shenhe']==0){echo "<font color=red>待审</font>";}?></td>
            <td align="center">
 <a href="admin.php?action=hr&hrid=<?=$info['hrid']?>&action_app=edit">修改</a>  
			</td>
            <td align="center">                        
              <input name="delid[]" type="checkbox" value="<?=$info['hrid']?>" />
              <a href="admin.php?action=hr&action_app=del&hrid=<?=$info['hrid']?>" onClick="return confrim();">删除</a>              
		    </td>
          </tr>
   <?php 
}
?>          
          <tr bgcolor="#F3F8FF" >
            <td height="25" colspan="9" align="center" >
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
            <input name="action_app" type="hidden" id="action_app" value="" /></td>
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