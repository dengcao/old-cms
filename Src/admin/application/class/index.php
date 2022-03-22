<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("class");//检查已登陆管理员是否具备管理此页面的权限
global $conn;
$parentid_all=$_POST["parentid_all"]; //父分类总ID，比如产品=1，新闻=2等，具体看数据表
if (!$parentid_all){
$parentid_all=trim($_GET["parentid_all"]);
}
$parentid=$_POST["parentid"]; //父分类ID
if (!$parentid){
$parentid=trim($_GET["parentid"]);
}

$action_app=$_POST["action_app"];

if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
switch ($action_app){
   case "saveadd";
    $parentid=trim($_POST["parentid"]);
	if (!is_numeric($parentid)){$parentid=0;}
	$classname=trim($_POST["classname"]);
	$orderby=trim($_POST["orderby"]);
	if (!is_numeric($orderby)){$orderby=0;}
	$classcontents=trim($_POST["classcontents"]);
	$imgurl=trim($_POST["imgurl"]);
	$isout=trim($_POST["isout"]);
	if (!is_numeric($isout)){$isout=0;}
	$outurl=trim($_POST["outurl"]);
	$visible=trim($_POST["visible"]);
	if (!is_numeric($visible)){$visible=0;}
	$seo_title=trim($_POST["seo_title"]);
	$seo_keyword=trim($_POST["seo_keyword"]);
	$seo_description=trim($_POST["seo_description"]);
	if ($classname==""){
	   echo_js("alert('分类名称不能为空！');history.back();");
	   exit;
	   }
	   
	$result=PinLuo_AddClass($classname,$imgurl,$seo_title,$seo_keyword,$seo_description,$classcontents,$parentid,$isout,$outurl,$visible,$orderby);
	if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=class&parentid_all=$parentid_all\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
	mysql_close($conn);
	break;
   case "saveedit";
    $classid=trim($_POST["classid"]);
    $parentid=trim($_POST["parentid"]);
	if (!is_numeric($parentid)){$parentid=0;}
	$classname=trim($_POST["classname"]);
	$orderby=trim($_POST["orderby"]);
	if (!is_numeric($orderby)){$orderby=0;}
	$classcontents=trim($_POST["classcontents"]);
	$imgurl=trim($_POST["imgurl"]);
	$isout=trim($_POST["isout"]);
	if (!is_numeric($isout)){$isout=0;}
	$outurl=trim($_POST["outurl"]);
	$visible=trim($_POST["visible"]);
	if (!is_numeric($visible)){$visible=0;}
	$seo_title=trim($_POST["seo_title"]);
	$seo_keyword=trim($_POST["seo_keyword"]);
	$seo_description=trim($_POST["seo_description"]);
	if ($classid==""){
	   echo_js("alert('请选择修改的分类！');history.back();");
	   exit;
	   }
	if ($classname==""){
	   echo_js("alert('分类名称不能为空！');history.back();");
	   exit;
	   }	   	
		 $result=mysql_query("update pl_class set classname='$classname',classcontents='$classcontents',imgurl='$imgurl',isout=$isout,outurl='$outurl',visible=$visible,seo_title='$seo_title',seo_keyword='$seo_keyword',seo_description='$seo_description',orderby=$orderby where classid=$classid",$conn);
	        if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=class&parentid_all=$parentid_all\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
	mysql_close($conn);
	break;
	case "del";
	$classid=trim($_GET["classid"]);
	if (!$classid){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}
	$result_del=PinLuo_DeleteInfoClass($classid);//执行删除
	mysql_close($conn);
	if ($result_del){
	       echo_js("alert('删除成功！');location.href=\"admin.php?action=class&parentid_all=$parentid_all\";");
		   }else{
		   echo_js("alert('删除失败！');history.back();");
			   }
	break;
	}
	
function getParentClassName($parentid){//获取父分类名称
	global $conn;
	if (!$parentid){
	return "";
	}else{
		$sql=mysql_query("select classname from pl_class where classid=".$parentid,$conn) or die('执行错误');//执行查询
        while($myrow=mysql_fetch_array($sql)){
			return $myrow['classname'];
			}
	}
	}
	
function getSubcategoriesNum($classid){//获取父分类的小分类个数
	global $conn;
	if (!$classid){
	return 0;
	}else{
		$sql=mysql_query("select classname from pl_class where parentid=".$classid,$conn) or die('执行错误');//执行查询
        $info=mysql_num_rows($sql);//获取查询结果
		return $info;
	}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>维护分类</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css">
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>

<?php
if ($action_app=="add"){
?>
<script language="javascript">
function ShowLink(t){
	if(t==1){
		document.getElementById("Showlink").style.display="";
		}else{
		document.getElementById("Showlink").style.display="none";
		}
	}
function Showmore(){	
		document.getElementById("Showmore_button").style.display="none";
		for(i=1;i<=5;i++){
		  document.getElementById("Showmore"+i).style.display="";
		}
	}
</script>
<script charset="utf-8" src="../editor2/kindeditor-min.js"></script>
		<script charset="utf-8" src="../editor2/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="classcontents"]', {
					allowFileManager : true
				});				
			});
		</script>
<form action="admin.php?action=class&parentid_all=<?=$parentid_all?>" method="post" name="classadd" id="classadd">
<br>
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">添加分类</span></td>
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
								<td width="15%" height="37" align="right">上级分类：</td>
								<td>
                                  <select name="parentid" id="parentid">
                                  <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>                                  <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid,0);								   
									?>
                                    
                                </select></td>
						  </tr>
							<tr>
								<td width="15%" height="37" align="right">分类名称：</td>
								<td>
								  <input name="classname" type="text"  id="classname" size="60" maxlength="255"  style="width:250px;">
									<font color="#ff0000">* </font></td>
							</tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderby" type="text" id="orderby" value="0" size="13" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）</td>
							</tr>
                            <tr>
		<td width="15%" height="37" align="right">是否隐藏：</td>
		<td><label>
		  <input type="radio" name="visible" id="radio" value="1" />
		  是&nbsp;&nbsp;&nbsp;
		</label>
		  <input name="visible" type="radio" id="radio2" value="0" checked="checked" /> 
		  否
</td>
		</tr>
		<tr>
		<td width="15%" height="37" align="right">外部链接：</td>
		<td><label>
		  <input type="radio" name="isout" id="radio" value="1" onclick="ShowLink(1)" />
		  是&nbsp;&nbsp;&nbsp;
		</label>
		  <input name="isout" type="radio" id="radio2" value="0" checked="checked" onclick="ShowLink(0)" /> 
		  否
</td>
		</tr>
        <tr id="Showlink" style="display:none;">
		<td width="15%" height="37" align="right">链接地址：</td>
		<td><input type='text' size='30' maxlength='255' name='outurl' style="width:250px;">&nbsp;&nbsp;(为外部链接时填写)</td>
		</tr>
                            <tr id="Showmore_button" style="display:;">
								<td height="37" align="right"> </td>
							  <td>
									<a href="javascript:;" onclick="Showmore();" style="color:#888">点击填写更多选项</a></td>
							</tr>                            
                   
                            <tr style="display:none" id="Showmore1">
								<td width="15%" height="37" align="right">分类图片：</td>
								<td>
								  <input name="imgurl" type="text"  id="imgurl" size="60" maxlength="255"  style="width:250px;"> <input type="button" id="upload_image1" value="选择图片" />
                                  <script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_image1').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#imgurl').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#imgurl').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				
				
			});
		</script>
                                  </td>
							</tr>                            
                            <tr style="display:none" id="Showmore2">
								<td width="15%" height="37" align="right">SEO标题：</td>
								<td>
								  <input name="seo_title" type="text"  id="seo_title" size="60" maxlength="255"  style="width:250px;"></td>
							</tr>
                            <tr style="display:none" id="Showmore3">
								<td width="15%" height="37" align="right">SEO关键词：</td>
								<td>
								  <input name="seo_keyword" type="text"  id="seo_keyword" size="60" maxlength="255"  style="width:250px;"></td>
							</tr>
                            <tr style="display:none" id="Showmore4">
								<td width="15%" height="37" align="right">SEO描述：</td>
								<td>
								  <textarea name="seo_description" cols="80" rows="3" id="seo_description"></textarea>								  <a href="javascript:admin_Size(-3,'seo_description')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'seo_description')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a></td>
							</tr>                            
                            <tr style="display:none" id="Showmore5">
								<td width="15%" height="37" align="right">分类内容：</td>
								<td>
								  <textarea name="classcontents" style="width:680px;height:200px;visibility:hidden;"></textarea></td>
							</tr>
           </span>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" title=" 单击刷新当前页面！ " onClick="window.location.reload()"
										value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveadd"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
  
</form>
<?php
}else if($action_app=="edit"){
	
$sql=mysql_query("select * from pl_class where classid=".$_GET["classid"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>
<script language="javascript">
function ShowLink(t){
	if(t==1){
		document.getElementById("Showlink").style.display="";
		}else{
		document.getElementById("Showlink").style.display="none";
		}
	}
function Showmore(){	
		document.getElementById("Showmore_button").style.display="none";
		for(i=1;i<=5;i++){
		  document.getElementById("Showmore"+i).style.display="";
		}
	}
</script>
<script charset="utf-8" src="../editor2/kindeditor-min.js"></script>
		<script charset="utf-8" src="../editor2/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="classcontents"]', {
					allowFileManager : true
				});				
			});
		</script>
<form action="admin.php?action=class&parentid_all=<?=$parentid_all?>" method="post" name="classedit" id="classedit">
<br>
<table cellSpacing="0" cellPadding="0" width="98%" align="center" border="0">
				<tr>
					<td>
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f3f8ff">
							<tr>
								<td height="30" colspan="2" bgcolor="#c0d5f0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon2.gif" /><span style="float:left" class="Main_box_header_title">编辑分类</span></td>
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
								<td width="15%" height="37" align="right">上级分类：</td>
								<td>
                                  <select name="parentid" id="parentid" disabled="disabled" title="不允许修改">
                                  <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>                                  <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$myrow['parentid'],0);
									?>
                                    
                                </select></td>
						  </tr>
							<tr>
								<td width="15%" height="37" align="right">分类名称：</td>
								<td>
								  <input name="classname" type="text"  id="classname" size="60" maxlength="255"  style="width:250px;" value="<?php echo $myrow['classname'];?>">
									<font color="#ff0000">* </font></td>
							</tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderby" type="text" id="orderby" value="<?php echo $myrow['orderby'];?>" size="13" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）</td>
							</tr>
                            <tr>
		<td width="15%" height="37" align="right">是否隐藏：</td>
		<td><label>
		  <input type="radio" name="visible" id="radio" value="1"<?php if($myrow['visible']==1){?> checked="checked"<?php }?> />
		  是&nbsp;&nbsp;&nbsp;
		</label>
		  <input name="visible" type="radio" id="radio2" value="0"<?php if($myrow['visible']==0){?> checked="checked"<?php }?> /> 
		  否
</td>
		</tr>
		<tr>
		<td width="15%" height="37" align="right">外部链接：</td>
		<td><label>
		  <input type="radio" name="isout" id="radio" value="1" onclick="ShowLink(1)"<?php if($myrow['isout']==1){?> checked="checked"<?php }?> />
		  是&nbsp;&nbsp;&nbsp;
		</label>
		  <input name="isout" type="radio" id="radio2" value="0" onclick="ShowLink(0)"<?php if($myrow['isout']==0){?> checked="checked"<?php }?> /> 
		  否
</td>
		</tr>
        <tr id="Showlink" style="display:<?php if($myrow['isout']==0){echo "none";}?>;">
		<td width="15%" height="37" align="right">链接地址：</td>
		<td><input type='text' size='30' maxlength='255' name='outurl' style="width:250px;" value="<?php echo $myrow['outurl'];?>">&nbsp;&nbsp;(为外部链接时填写)</td>
		</tr>
                            <tr id="Showmore_button" style="display:;">
								<td height="37" align="right"> </td>
							  <td>
									<a href="javascript:;" onclick="Showmore();" style="color:#888">点击填写更多选项</a></td>
							</tr>
                   
                            <tr style="display:none" id="Showmore1">
								<td width="15%" height="37" align="right">分类图片：</td>
								<td>
								  <input name="imgurl" type="text"  id="imgurl" size="60" maxlength="255"  style="width:250px;" value="<?php echo $myrow['imgurl'];?>"> <input type="button" id="upload_image1" value="选择图片" />
                                  <script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_image1').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#imgurl').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#imgurl').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				
				
			});
		</script>
                                  </td>
							</tr>                            
                            <tr style="display:none" id="Showmore2">
								<td width="15%" height="37" align="right">SEO标题：</td>
								<td>
								  <input name="seo_title" type="text"  id="seo_title" size="60" maxlength="255"  style="width:250px;" value="<?php echo $myrow['seo_title'];?>"></td>
							</tr>
                            <tr style="display:none" id="Showmore3">
								<td width="15%" height="37" align="right">SEO关键词：</td>
								<td>
								  <input name="seo_keyword" type="text"  id="seo_keyword" size="60" maxlength="255"  style="width:250px;" value="<?php echo $myrow['seo_keyword'];?>"></td>
							</tr>
                            <tr style="display:none" id="Showmore4">
								<td width="15%" height="37" align="right">SEO描述：</td>
								<td>
								  <textarea name="seo_description" cols="80" rows="3" id="seo_description"><?php echo $myrow['seo_description'];?></textarea>								  <a href="javascript:admin_Size(-3,'seo_description')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'seo_description')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a></td>
							</tr>                            
                            <tr style="display:none" id="Showmore5">
								<td width="15%" height="37" align="right">分类内容：</td>
								<td>
								  <textarea name="classcontents" style="width:680px;height:200px;visibility:hidden;"><?php echo htmlspecialchars($myrow['classcontents']);?></textarea></td>
							</tr>
           </span>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" title=" 单击刷新当前页面！ " onClick="window.location.reload()"
										value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveedit"><input name="classid" type="hidden" id="classid" value="<?php echo $myrow['classid'];?>"></td>
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
<style type="text/css">
.classlist{
	font-size:12px;
	text-align:left;
	font-weight:bold;
}
.classlist li{
	list-style:none;
	padding:2px 0px;
	height:25px;
	}
*+body .classlist li{padding:2px 18px;}
.classlist li span{
	padding-left:20px;
	}
.classlist #class2{background:url(images/arr2.png) no-repeat;}

</style>
<script language="javascript">
function ShowMenu(id){
	document.getElementById("M"+id).style.display=""
	}
function HideMenu(id){
	document.getElementById("M"+id).style.display="none"
	}
function cf(t){
if(confirm("您确定删除【"+t+"】这个分类吗？\n\n删除此分类将同时删除其下级分类。此操作将无法恢复，请慎重操作。")==true){
	return true;
	}else{
	return false;	
		}
	}
</script>

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
								<td colSpan="7" height="30" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title"><?=getParentClassName($parentid_all)?> - 分类列表</span></td>
							</tr>
							<tr>
							  <td colSpan="7" height="10"></td>
						  </tr>
							<tr>
								<td align="center">
                                
                                
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table1">
		<tr>
		  <td colspan="2" style="text-align:left;padding:5px 10px;">
          <ul class="classlist">
<?php
	PinLuo_ViewClass($parentid_all,10,"admin.php?action=class&parentid_all=$parentid_all&");
?>
</ul>
<div><br><br><br><a href='admin.php?action=class&parentid_all=<?=$parentid_all?>&action_app=add' style="background:url(images/add_alt.gif) no-repeat;padding-left:20px;display:block;height:20px;font-weight:normal">添加分类</a>
<br><br /><br />
          <font style="color:#aaa; font-weight:normal">说明：( )内数字代表包含下属分类，[ ]内数字代表排序号，“隐”代表隐藏分类，“外”代表外部链接。</font></div></td>
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