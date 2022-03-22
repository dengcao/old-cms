<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("product");//检查已登陆管理员是否具备管理此页面的权限
$parentid_all=1;//定义产品的总分类ID
$item_name_all="产品";//定义项目总名称，比如产品
global $conn;
$action_app=$_POST["action_app"];
if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
	
switch ($action_app){
   case "saveadd":
	$ProName=trim($_POST["ProName"]);
	$Classid=trim($_POST["Classid"]);
	$ProSummary=trim($_POST["ProSummary"]);
	$ProContent=trim($_POST["ProContent"]);
	$ProImg1=trim($_POST["ProImg1"]);
	$ProImg2=trim($_POST["ProImg2"]);
	$ProPrice1=trim($_POST["ProPrice1"]);
	$ProPrice2=trim($_POST["ProPrice2"]);
	$UpdateTime=trim($_POST["UpdateTime"]);	
	$Shenhe=trim($_POST["Shenhe"]);
	$SEO_Title=trim($_POST["SEO_Title"]);
	$SEO_Keyword=trim($_POST["SEO_Keyword"]);
	$SEO_Description=trim($_POST["SEO_Description"]);
	$Hits=trim($_POST["Hits"]);
	if (!is_numeric($Hits)){$Hits=0;}
	$OrderID=trim($_POST["OrderID"]);	
	if (!is_numeric($OrderID)){$OrderID=0;}
	$Tuijian=$_POST["Tuijian"];
	if (!is_numeric($Tuijian)){$Tuijian=0;}
	if (!is_numeric($Shenhe)){$Shenhe=1;}
	if (!is__date($UpdateTime)){$UpdateTime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	
	if ($ProName==""){
	   echo_js("alert('名称不能为空！');history.back();");
	   exit;
	   }
	/*$sql = mysql_query("select ProName from pl_product where ProName='$ProName'",$conn) or die('执行错误');//执行查询;	
	$info=mysql_num_rows($sql);//获取查询结果
	    if ($info>0){
	    echo_js("alert('产品：".$ProName." 已经存在！请您重新输入！');history.back();");
	    exit;
		}else{}*/
	$result=mysql_query("insert into pl_product set classid=$Classid,proname='$ProName',prosummary='$ProSummary',procontent='$ProContent',proimg1='$ProImg1',proimg2='$ProImg2',proprice1=$ProPrice1,proprice2=$ProPrice2,orderid=$OrderID,tuijian=$Tuijian,updatetime='$UpdateTime',hits=$Hits,shenhe=$Shenhe,seo_title='$SEO_Title',seo_keyword='$SEO_Keyword',seo_description='$SEO_Description'",$conn);
	        if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=product\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
			
	mysql_close($conn);
	break;
   case "saveedit":
    $ProID=trim($_POST["ProID"]);
    $ProName=trim($_POST["ProName"]);
	$Classid=trim($_POST["Classid"]);
	$ProSummary=trim($_POST["ProSummary"]);
	$ProContent=trim($_POST["ProContent"]);
	$ProImg1=trim($_POST["ProImg1"]);
	$ProImg2=trim($_POST["ProImg2"]);
	$ProPrice1=trim($_POST["ProPrice1"]);
	$ProPrice2=trim($_POST["ProPrice2"]);
	$UpdateTime=trim($_POST["UpdateTime"]);	
	$Shenhe=trim($_POST["Shenhe"]);
	$SEO_Title=trim($_POST["SEO_Title"]);
	$SEO_Keyword=trim($_POST["SEO_Keyword"]);
	$SEO_Description=trim($_POST["SEO_Description"]);
	$Hits=trim($_POST["Hits"]);
	if (!is_numeric($Hits)){$Hits=0;}
	$OrderID=trim($_POST["OrderID"]);	
	if (!is_numeric($OrderID)){$OrderID=0;}
	$Tuijian=$_POST["Tuijian"];
	if (!is_numeric($Tuijian)){$Tuijian=0;}
	if (!is_numeric($Shenhe)){$Shenhe=1;}
	if (!is__date($UpdateTime)){$UpdateTime=date('Y-m-d H:i:s',time());}//检查时间格式合法性	
	if ($ProName==""){
	   echo_js("alert('名称不能为空！');history.back();");
	   exit;
	   }
	   
	/*$sql = mysql_query("select ProName from pl_product where ProName='$ProName' and ProID<>$ProID",$conn) or die('执行错误');//执行查询;	
	$info=mysql_num_rows($sql);//获取查询结果
	    if ($info>0){
	    echo_js("alert('产品：".$ProName." 已经存在！请您重新输入！');history.back();");
	    exit;
		}else{}*/
	$result=mysql_query("update pl_product set classid=$Classid,proname='$ProName',prosummary='$ProSummary',procontent='$ProContent',proimg1='$ProImg1',proimg2='$ProImg2',proprice1=$ProPrice1,proprice2=$ProPrice2,orderid=$OrderID,tuijian=$Tuijian,updatetime='$UpdateTime',hits=$Hits,shenhe=$Shenhe,seo_title='$SEO_Title',seo_keyword='$SEO_Keyword',seo_description='$SEO_Description' where proid=$ProID",$conn);
	        if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=product\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
	mysql_close($conn);
	break;
	case "del":
	$ProID=trim($_GET["ProID"]);
	Delproduct($ProID);
	break;
	case "ListDel":
	$ProID=$_POST["delProID"];
	   if (is_array($ProID)){
	       $ProID=implode(",",$ProID);//将数组转换为字符
	       Delproduct($ProID);}
    break;
	case "rank":
	$ProID=$_POST["ProID"];
	$ProRank=$_POST["ProRank"];
	updateRank($ProID,$ProRank);
	break;
	}
	
function updateRank($ProID,$ProRank){//更新排序
    global $conn;
	if (!$ProID&&!$ProRank){
		echo_js("alert('请先选择要更新的数据！');history.back();");
	    exit;
		}else{
			foreach($ProID as $key=>$value){				
				if (!is_numeric($ProRank[$key])){$ProRank[$key]=0;}
			    $result=mysql_query("update pl_product set orderid='$ProRank[$key]' where proid=$value",$conn);
			}
			   if ($result){
	               echo_js("alert('更新成功！');location.href=\"admin.php?action=product\";");
	           }else{
		           echo_js("alert('更新失败！');history.back();");
			   }
		}
	mysql_close($conn);
	exit;
	}
	
function Delproduct($ProID){//批量删除数据
	global $conn;
	if (!$ProID){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_product where proid in(".$ProID.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=product\";");
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
<title>维护<?=$item_name_all?></title>
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

     <script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
     <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>     
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css"/>    
    <script language="javascript" type="text/javascript" src="Js/My97DatePicker/WdatePicker.js"></script>
    
    
<form action="admin.php?action=product" method="post" name="add" id="add">
<br>
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
								<td><select name="Classid" id="Classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select></td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>名称：</td>
								<td>
								  <input name="ProName" type="text" id="ProName" size="60" maxlength="255"  style="width:250px;">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>小图：</td>
								<td>
								  <input name="ProImg1" type="text"  id="ProImg1" size="60" maxlength="500"  style="width:150px;">
							  <input type="button" id="upload_image1" value="选择图片" />							  &nbsp;&nbsp;&nbsp;<?=$item_name_all?>大图：<input name="ProImg2" type="text"  id="ProImg2" size="60" maxlength="500"  style="width:150px;"> <input type="button" id="upload_image2" value="选择图片" />
        
        <link rel="stylesheet" href="../editor2/themes/default/default.css" />
        <script src="../editor2/kindeditor.js"></script>
		<script src="../editor2/lang/zh_CN.js"></script>
		<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_image1').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#ProImg1').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#ProImg1').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				K('#upload_image2').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#ProImg2').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#ProImg2').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				
			});
		</script>
                              </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>简介：</td>
								<td><textarea name="ProSummary" cols="80" rows="3" id="ProSummary"></textarea>								  <a href="javascript:admin_Size(-3,'ProSummary')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'ProSummary')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a></td>
							</tr>
							<tr>
							  <td height="37" align="right"><?=$item_name_all?>内容：</td>
							  <td><br>
                              
                              <script type="text/plain" id="ProContent" name="ProContent" style="width:800px;"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.minFrameHeight=320;//编辑器高度
	window.UEDITOR_CONFIG.maximumWords=50000;//最多允许字符
	window.UEDITOR_CONFIG.autoHeightEnabled=true;//是否自动长高
	window.UEDITOR_CONFIG.autoFloatEnabled=false;//是否保持toolbar的位置不动
    var editor_a = new baidu.editor.ui.Editor();
    editor_a.render( 'ProContent' );
</script>

                              </td>
						  </tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="OrderID" type="text" id="OrderID" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="Hits" type="text" id="Hits" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" >&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<input name="UpdateTime" type="text" id="UpdateTime" value="<?=date('Y-m-d H:i:s',time())?>" readonly="readonly" size="12" onclick="WdatePicker({el:'UpdateTime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'UpdateTime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle"></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">现价：</td>
								<td>
								  <input name="ProPrice1" type="text"  id="ProPrice1" size="11" maxlength="11" value="0.00" onFocus="if(this.value=='0.00')this.value='';" onBlur="if(this.value=='')this.value='0.00';">								  &nbsp;&nbsp;市场价：
<input name="ProPrice2" type="text"  id="ProPrice2" size="11" maxlength="11" value="0.00" onFocus="if(this.value=='0.00')this.value='';" onBlur="if(this.value=='')this.value='0.00';"></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="Shenhe" id="Shenhe1" value="0" />等待审核 <input name="Shenhe" type="radio" id="Shenhe2" value="1" checked="checked" />通过 <input type="radio" name="Shenhe" id="Shenhe3" value="2" />不通过</td>
							</tr>
                            <tr>
								<td height="37" align="right">推荐：</td>
							  <td><input type="radio" name="Tuijian" id="Tuijian" value="1" />是 <input type="radio" name="Tuijian" id="Tuijian2" value="0" checked />否
									</td>
							</tr>
                            <tr>
								<td height="37" align="right">SEO标题：</td>
							  <td>
                              <input name="SEO_Title" type="text" id="SEO_Title" size="60" maxlength="500"  style="width:250px;">
                              &nbsp;&nbsp;SEO关键词： <input name="SEO_Keyword" type="text" id="SEO_Keyword" size="60" maxlength="500"  style="width:250px;">
                              </td>
							</tr>
                            <tr>
								<td height="37" align="right">SEO描述：</td>
							  <td>
                              <textarea name="SEO_Description" cols="80" rows="3" id="SEO_Description"></textarea>								  <a href="javascript:admin_Size(-3,'SEO_Description')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'SEO_Description')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a>
                              </td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveadd"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>			
  
</form>

<?php
}else if($action_app=="edit"){
	
$sql=mysql_query("select * from pl_product where proid=".$_GET["ProID"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

 
    <script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="../ueditor1/editor_all.js"></script>--> 
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css" />
    
    <script language="javascript" type="text/javascript" src="Js/My97DatePicker/WdatePicker.js"></script>
    
    
<form action="admin.php?action=product" method="post" name="edit" id="edit">
<br>
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
								<td><select name="Classid" id="Classid">
                                    <option value="<?=$parentid_all?>" selected="selected"><?=getClassName($parentid_all)?></option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$myrow['classid'],0);
									?>
                                </select></td>
							</tr>
							<tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>名称：</td>
								<td>
								  <input name="ProName" type="text" id="ProName" size="60" maxlength="255" value="<?php echo $myrow['proname'];?>" style="width:250px;">
									<font color="#ff0000">* </font></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>小图：</td>
								<td>
								  <input name="ProImg1" type="text"  id="ProImg1" size="60" maxlength="500" value="<?php echo $myrow['proimg1'];?>" style="width:150px;"> <input type="button" id="upload_image1" value="选择图片" /> &nbsp;&nbsp;&nbsp;<?=$item_name_all?>大图：<input name="ProImg2" type="text"  id="ProImg2" size="60" maxlength="500" value="<?php echo $myrow['proimg2'];?>" style="width:150px;"> <input type="button" id="upload_image2" value="选择图片" />
        
        <link rel="stylesheet" href="../editor2/themes/default/default.css" />
        <script src="../editor2/kindeditor.js"></script>
		<script src="../editor2/lang/zh_CN.js"></script>
		<script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_image1').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#ProImg1').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#ProImg1').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				K('#upload_image2').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#ProImg2').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#ProImg2').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				
			});
		</script>
                                  
                                  </td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right"><?=$item_name_all?>简介：</td>
								<td><textarea name="ProSummary" cols="80" rows="3" id="ProSummary"><?php echo $myrow['prosummary'];?></textarea>								  <a href="javascript:admin_Size(-3,'ProSummary')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'ProSummary')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a></td>
							</tr>
							<tr>
							  <td height="37" align="right"><?=$item_name_all?>内容：</td>
							  <td><br>
                              
                              <script type="text/plain" id="ProContent" name="ProContent" style="width:800px;"><?php echo $myrow['procontent'];?></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.minFrameHeight=320;//编辑器高度
	window.UEDITOR_CONFIG.maximumWords=50000;//最多允许字符
	window.UEDITOR_CONFIG.autoHeightEnabled=true;//是否自动长高
	window.UEDITOR_CONFIG.autoFloatEnabled=false;//是否保持toolbar的位置不动
    var editor_a = new baidu.editor.ui.Editor();
    editor_a.render( 'ProContent' );
</script>

                              </td>
						  </tr>
							<tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="OrderID" type="text" id="OrderID" value="<?php echo $myrow['orderid'];?>" size="13" maxlength="11" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="Hits" type="text" id="Hits" value="<?php echo $myrow['hits'];?>" size="13" maxlength="11" >&nbsp;&nbsp;&nbsp;&nbsp;发布时间：<input name="UpdateTime" type="text" id="UpdateTime" value="<?php echo $myrow['updatetime'];?>" readonly="readonly" size="12" onclick="WdatePicker({el:'UpdateTime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'UpdateTime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle"></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">现价：</td>
								<td>
								  <input name="ProPrice1" type="text"  id="ProPrice1" size="11" maxlength="11" value="<?php echo $myrow['proprice1'];?>">								  &nbsp;&nbsp;市场价：
<input name="ProPrice2" type="text"  id="ProPrice2" size="11" maxlength="11" value="<?php echo $myrow['proprice2'];?>"></td>
							</tr>
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="Shenhe" id="Shenhe1" value="0"<?php if($myrow['shenhe']==0){?> checked="checked"<?php }?> />等待审核 <input name="Shenhe" type="radio" id="Shenhe2" value="1"<?php if($myrow['shenhe']==1){?> checked="checked"<?php }?> />通过 <input type="radio" name="Shenhe" id="Shenhe3" value="2"<?php if($myrow['shenhe']==2){?> checked="checked"<?php }?> />不通过</td>
							</tr>
                            <tr>
								<td height="37" align="right">推荐：</td>
							  <td><input type="radio" name="Tuijian" id="Tuijian" value="1"<?php if($myrow['tuijian']==1){?> checked="checked"<?php }?> />是 <input type="radio" name="Tuijian" id="Tuijian2" value="0"<?php if($myrow['tuijian']==0){?> checked="checked"<?php }?> />否
									</td>
							</tr>
                            <tr>
								<td height="37" align="right">SEO标题：</td>
							  <td>
                              <input name="SEO_Title" type="text" id="SEO_Title" size="60" maxlength="500" value="<?php echo $myrow['seo_title'];?>" style="width:250px;">
                              &nbsp;&nbsp;SEO关键词： <input name="SEO_Keyword" type="text" id="SEO_Keyword" size="60" maxlength="500" value="<?php echo $myrow['seo_keyword'];?>" style="width:250px;">
                              </td>
							</tr>
                            <tr>
								<td height="37" align="right">SEO描述：</td>
							  <td>
                              <textarea name="SEO_Description" cols="80" rows="3" id="SEO_Description"><?php echo $myrow['seo_description'];?></textarea>								  <a href="javascript:admin_Size(-3,'SEO_Description')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'SEO_Description')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a>
                              </td>
							</tr>
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveedit"><input name="ProID" type="hidden" id="ProID" value="<?php echo $myrow['proid'];?>"></td>
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
                              <form action="admin.php?action=product" method="get" name="searchlist" id="searchlist">
                              <input name="keyword" type="text"  id="SearchKeyword"  value="" size="40" maxlength="60" >
                              <select name="searchclassid" id="searchclassid">
                                    <option value="" selected="selected">--<?=$item_name_all?>分类--</option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select>
                              <select name="searchselect" id="searchselect">
                                <option value="">--类型--</option>
                                <option value="ProName">名称</option>
                                <option value="ProContent">内容</option>
                                <option value="ProSummary">简介</option>
                                <option value="SEO_Title">SEO标题</option>
                              </select>
                              <select name="searchtuijian" id="searchtuijian">
                                <option value="">--推荐--</option>
                                <option value="1">推荐</option>
                                <option value="0">不推荐</option>
                              </select>
                              <select name="searchshenhe" id="searchshenhe">
                                <option value="">--状态--</option>
                                <option value="0">等待审核</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核不通过</option>
                              </select>
                              <input name="Submit" type="submit"  value=" 搜索 ">
							  <input type="reset" value=" 重置 " name="Submit">
                              <input name="action" type="hidden" value="product" />
                              </form>
                              
                              </td>
						  </tr>
                          
							<tr>
								<td align="center" width="100%">
								
								
								
								
	<form action="admin.php?action=product" method="post" name="list" id="list">							
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#96B3D1" >          
          
          <tr align="center" bgcolor="#DDEEEB" class="list_title">
            <td width="9%" height="25" class="red12">编号</td>
            <td width="26%" class="red12"><?=$item_name_all?>名称</td>
            <td width="19%" class="red12"><?=$item_name_all?>类别</td>
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
$sql="select * from pl_product where proid>0";
if ($keyword!=""){
	$keyword=trim($keyword);
	$searchselect=$_POST["searchselect"];
	if (!$searchselect){
	$searchselect=$_GET["searchselect"];
	}
	switch($searchselect){
		case "ProName":
	      $sql.=" and proname like '%".$keyword."%'";
		  break;
		case "ProContent":
	      $sql.=" and procontent like '%".$keyword."%'";
		  break;
		case "ProSummary":
	      $sql.=" and prosummary like '%".$keyword."%'";
		  break;
		case "SEO_Title":
	      $sql.=" and seo_title like '%".$keyword."%'";
		  break;
		default:
		  $sql.=" and (proname like '%".$keyword."%' or procontent like '%".$keyword."%' or prosummary like '%".$keyword."%' or seo_title like '%".$keyword."%')";
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
$searchtuijian=$_POST["searchtuijian"];
if (!$searchtuijian){
	$searchtuijian=$_GET["searchtuijian"];
	}
if ($searchtuijian!=""){
	$sql.=" and tuijian = ".$searchtuijian."";
	}
	
$sql.=" order by orderid desc,updatetime desc,proid desc";

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
            <td align="center"><?=$info[proid]?><input name="ProID[]" type="hidden" value="<?=$info[proid]?>"></td>
            <td align="left"> <a href="admin.php?action=product&ProID=<?=$info[proid]?>&action_app=edit"><?=$info[proname]?></a><?php if($info[tuijian]==1){echo " <font color=red>(荐)</font>";}?></td>
            <td align="left"> <a href="admin.php?action=product&searchclassid=<?=$info[classid]?>"><?=getClassName($info[classid])?></a></td>
            <td align="center"><?=$info[updatetime]?></td>
            <td align="center"><input name="ProRank[]" type="text" value="<?=$info[orderid]?>" size="8" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" ></td>
			<td align="center"><?=$info[hits]?></td>
            <td align="center"><?php if($info[shenhe]==1){echo "通过";}else if($info[shenhe]==2){echo "<font color=\"#777777\">不通过</font>";}else if($info[shenhe]==0){echo "<font color=red>待审</font>";}?></td>
            <td align="center">
 <a href="admin.php?action=product&ProID=<?=$info[proid]?>&action_app=edit">修改</a>  
			</td>
            <td align="center">                        
              <input name="delProID[]" type="checkbox" value="<?=$info[proid]?>" >
              <a href="admin.php?action=product&action_app=del&ProID=<?=$info[proid]?>" onClick="return confrim();">删除</a>              
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
            
			<input name="Submit" type="submit" class="button" value="更新排序" onClick="this.form.action_app.value='rank'" >
			
              <input name="Submit2" type="submit" class="button" value="删除选定" onClick="this.form.action_app.value='ListDel';return confrim();" >
<input name="chkall" type="checkbox" value="" class="button" onClick="javascript:CheckAll(this.form)">
<input name="Submit3" type="reset" class="button" value="重置表单">  
                <input name="reload" type="button" class="button" id="reload" onClick="window.location.reload()" value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4">
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
}
mysql_close($conn);	
require_once 'application/admin_footer.php';		//调用脚部
?>
</body>
</html>