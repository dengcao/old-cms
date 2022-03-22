<?php
!defined('IN_CMS') && exit('Access Denied');
CheckUserPopedom("feedback");//检查已登陆管理员是否具备管理此页面的权限
$parentid_all=3;//定义留言的总分类ID
$item_name_all="留言";//定义项目总名称，比如留言反馈
global $conn;
$action_app=$_POST["action_app"];
if (!$action_app){
	$action_app=trim($_GET["action_app"]);
	}
	
switch ($action_app){
   case "saveadd":
	$classid=trim($_POST["classid"]);
	$fbtitle=trim($_POST["fbtitle"]);
	$fbcontent=trim($_POST["fbcontent"]);
	$author=trim($_POST["author"]);
	$updatetime=trim($_POST["updatetime"]);
	//$userid=trim($_POST["userid"]);
	$userid=0; //会员ID，预留
	$myphone=trim($_POST["myphone"]);
	$email=trim($_POST["email"]);	
	$qq=trim($_POST["qq"]);
	$address=trim($_POST["address"]);
	$replycontent=trim($_POST["replycontent"]);
	$replytime=trim($_POST["replytime"]);
	$replyman=trim($_POST["replyman"]);
	$hits=trim($_POST["hits"]);
	if (!is_numeric($hits)){$hits=0;}
	$orderid=trim($_POST["orderid"]);	
	if (!is_numeric($orderid)){$orderid=0;}
	$tuijian=$_POST["tuijian"];
	if (!is_numeric($tuijian)){$tuijian=0;}
	$shenhe=$_POST["shenhe"];
	if (!is_numeric($shenhe)){$shenhe=1;}
	if (!is__date($updatetime)){$updatetime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	if (!is__date($replytime)){$replytime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	
	if ($fbtitle==""){
	   echo_js("alert('标题不能为空！');history.back();");
	   exit;
	   }
	$sql_into="insert into pl_feedback set classid=$classid,fbtitle='$fbtitle',fbcontent='$fbcontent',author='$author',updatetime='$updatetime',userid=$userid,myphone='$myphone',email='$email',address='$address',qq='$qq',replycontent='$replycontent',replytime='$replytime',replyman='$replyman',tuijian=$tuijian,shenhe=$shenhe,hits=$hits,orderid=$orderid";
	$result=mysql_query($sql_into,$conn);
	        if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=feedback\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
	mysql_close($conn);
	break;
   case "saveedit":
    $fbid=trim($_POST["fbid"]);
    $classid=trim($_POST["classid"]);
	$fbtitle=trim($_POST["fbtitle"]);
	$fbcontent=trim($_POST["fbcontent"]);
	$author=trim($_POST["author"]);
	$updatetime=trim($_POST["updatetime"]);
	//$userid=trim($_POST["userid"]);
	$userid=0; //会员ID，预留
	$myphone=trim($_POST["myphone"]);
	$email=trim($_POST["email"]);	
	$address=trim($_POST["address"]);
	$qq=trim($_POST["qq"]);
	$replycontent=trim($_POST["replycontent"]);
	$replytime=trim($_POST["replytime"]);
	$replyman=trim($_POST["replyman"]);
	$hits=trim($_POST["hits"]);
	if (!is_numeric($hits)){$hits=0;}
	$orderid=trim($_POST["orderid"]);	
	if (!is_numeric($orderid)){$orderid=0;}
	$tuijian=$_POST["tuijian"];
	if (!is_numeric($tuijian)){$tuijian=0;}
	$shenhe=$_POST["shenhe"];
	if (!is_numeric($shenhe)){$shenhe=1;}
	if (!is__date($updatetime)){$updatetime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	if (!is__date($replytime)){$replytime=date('Y-m-d H:i:s',time());}//检查时间格式合法性
	
	if ($fbtitle==""){
	   echo_js("alert('标题不能为空！');history.back();");
	   exit;
	   }else if(!is_numeric($fbid)){
		echo_js("alert('参数传递错误！');history.back();");
	    exit;   
		   }
	$result=mysql_query("update pl_feedback set classid=$classid,fbtitle='$fbtitle',fbcontent='$fbcontent',author='$author',updatetime='$updatetime',userid=$userid,myphone='$myphone',email='$email',address='$address',qq='$qq',replycontent='$replycontent',replytime='$replytime',replyman='$replyman',tuijian=$tuijian,shenhe=$shenhe,hits=$hits,orderid=$orderid where fbid=$fbid",$conn);
	if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=feedback\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }

	mysql_close($conn);
	break;
	case "del":
	$fbid=trim($_GET["fbid"]);
	Delfeedback($fbid);
	break;
	case "ListDel":
	$fbid=$_POST["delfbid"];
	   if (is_array($fbid)){
	       $fbid=implode(",",$fbid);//将数组转换为字符
	       Delfeedback($fbid);}
    break;
	case "rank":
	$fbid=$_POST["fbid"];
	$fbrank=$_POST["fbrank"];
	updateRank($fbid,$fbrank);
	break;
	}
	
function updateRank($fbid,$fbrank){//更新排序
    global $conn;
	if (!$fbid&&!$fbrank){
		echo_js("alert('请先选择要更新的数据！');history.back();");
	    exit;
		}else{
			foreach($fbid as $key=>$value){				
				if (!is_numeric($fbrank[$key])){$fbrank[$key]=0;}
			    $result=mysql_query("update pl_feedback set orderid='$fbrank[$key]' where fbid=$value",$conn);
			}
			   if ($result){
	               echo_js("alert('更新成功！');location.href=\"admin.php?action=feedback\";");
	           }else{
		           echo_js("alert('更新失败！');history.back();");
			   }
		}
	mysql_close($conn);
	exit;
	}
	
function Delfeedback($fbid){//批量删除数据
	global $conn;
	if (!$fbid){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_feedback where fbid in(".$fbid.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=feedback\";");
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
    
    
<form action="admin.php?action=feedback" method="post" name="add" id="add">
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
								  <input name="fbtitle" type="text" id="fbtitle" size="60" maxlength="500"  style="width:500px;">
									<font color="#ff0000">* </font></td>
							</tr>
							<tr>
							  <td height="37" align="right"><?=$item_name_all?>内容：</td>
							  <td><br>
                              
                              <script type="text/plain" id="fbcontent" name="fbcontent" style="width:800px;"></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:250,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'fbcontent' );
</script>

                              </td>
						  </tr>                          
                          <tr>
								<td width="14%" height="37" align="right">留言者：</td>
								<td>
								  <input name="author" type="text" id="author" size="30" maxlength="255"  style="width:130px;"> &nbsp;&nbsp;&nbsp;电话：<input name="myphone" type="text" id="myphone" size="30" maxlength="255"  style="width:130px;"> &nbsp;&nbsp;&nbsp;联系QQ：<input name="qq" type="text" id="qq" size="30" maxlength="255"  style="width:130px;"> &nbsp;&nbsp;&nbsp;邮箱：<input name="email" type="text" id="email" size="30" maxlength="255"  style="width:130px;"></td>
							</tr>
                            <tr>
								<td height="37" align="right">联系地址：</td>
							  <td>
									<input name="address" type="text" id="address" value="" size="60" maxlength="500" ></td>
							</tr>
                            <tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="hits" type="text" id="hits" onFocus="if(this.value=='0')this.value='';" onBlur="if(this.value=='')this.value='0';" value="0" size="13" maxlength="11" >&nbsp;&nbsp;&nbsp;&nbsp;留言时间：<input name="updatetime" type="text" id="updatetime" value="<?=date('Y-m-d H:i:s',time())?>" readonly="readonly" size="12" onclick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle"></td>
							</tr>
                            <tr>
                              <td height="37" align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
							                          
                            <tr>
								<td height="37" align="right">管理员回复：</td>
							  <td>
                             <script type="text/plain" id="replycontent" name="replycontent" style="width:800px;"></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:120,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'replycontent' );
</script>
                              </td>
							</tr>
                            <tr>
								<td height="37" align="right">回复人：</td>
							  <td>
                              <input name="replyman" type="text" id="replyman" size="60" maxlength="500" value="<?=$_SESSION["adminname"]?>" style="width:130px;">
                              &nbsp;&nbsp;回复时间：<input name="replytime" type="text" id="replytime" value="<?=date('Y-m-d H:i:s',time())?>" readonly="readonly" size="12" onclick="WdatePicker({el:'replytime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'replytime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle">
                              </td>
							</tr>                            
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="shenhe" id="shenhe1" value="0" />等待审核 <input name="shenhe" type="radio" id="shenhe2" value="1" checked="checked" />通过 <input type="radio" name="shenhe" id="shenhe3" value="2" />不通过 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;推荐：<input type="radio" name="tuijian" id="tuijian" value="1" />是 <input type="radio" name="tuijian" id="tuijian2" value="0" checked />否</td>
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
	
$sql=mysql_query("select * from pl_feedback where fbid=".$_GET["fbid"],$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
?>

 
    <script language="javascript">window.UEDITOR_HOME_URL = "/editor1/";</script>
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_config.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="../ueditor1/editor_all.js"></script>--> 
    <script type="text/javascript" charset="utf-8" src="../editor1/editor_api.js"></script>
    <link rel="stylesheet" type="text/css" href="../editor1/themes/default/ueditor.css" />
    
    <script language="javascript" type="text/javascript" src="Js/My97DatePicker/WdatePicker.js"></script>

<form action="admin.php?action=feedback" method="post" name="edit" id="edit">
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
								  <input name="fbtitle" type="text" id="fbtitle" size="60" maxlength="500"  style="width:500px;" value="<?=$myrow['fbtitle']?>">
									<font color="#ff0000">* </font></td>
							</tr>
							<tr>
							  <td height="37" align="right"><?=$item_name_all?>内容：</td>
							  <td><br>
                              
                              <script type="text/plain" id="fbcontent" name="fbcontent" style="width:800px;"><?=$myrow['fbcontent']?></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:250,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'fbcontent' );
</script>

                              </td>
						  </tr>                          
                          <tr>
								<td width="14%" height="37" align="right">留言者：</td>
								<td>
								  <input name="author" type="text" id="author" size="30" maxlength="255"  style="width:130px;" value="<?=$myrow['author']?>"> &nbsp;&nbsp;&nbsp;电话：<input name="myphone" type="text" id="myphone" size="30" maxlength="255"  style="width:130px;" value="<?=$myrow['myphone']?>"> &nbsp;&nbsp;&nbsp;联系QQ：<input name="qq" type="text" id="qq" size="30" maxlength="255"  style="width:130px;" value="<?=$myrow['qq']?>"> &nbsp;&nbsp;&nbsp;邮箱：<input name="email" type="text" id="email" size="30" maxlength="255"  style="width:130px;" value="<?=$myrow['email']?>"></td>
							</tr>
                            <tr>
								<td height="37" align="right">联系地址：</td>
							  <td>
									<input name="address" type="text" id="address" value="<?=$myrow['address']?>" size="60" maxlength="500" ></td>
							</tr>
                            <tr>
								<td height="37" align="right">显示顺序：</td>
							  <td>
									<input name="orderid" type="text" id="orderid" value="<?=$myrow['orderid']?>" size="13" maxlength="11" >
								<font color="#FF0000"> *</font>（数字，越大越靠前）&nbsp;&nbsp;&nbsp;&nbsp;点击量：<input name="hits" type="text" id="hits" value="<?=$myrow['hits']?>" size="13" maxlength="11" >&nbsp;&nbsp;&nbsp;&nbsp;留言时间：<input name="updatetime" type="text" id="updatetime" value="<?=$myrow['updatetime']?>" readonly="readonly" size="12" onclick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'updatetime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle"></td>
							</tr>
                            <tr>
                              <td height="37" align="right">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
							                          
                            <tr>
								<td height="37" align="right">管理员回复：</td>
							  <td>
                             <script type="text/plain" id="replycontent" name="replycontent" style="width:800px;"><?=$myrow['replycontent']?></script>
<script type="text/javascript">
var editorOption = {
            //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
            toolbars:[['FullScreen', 'Source','fontfamily','fontsize', 'Undo', 'Redo','Bold','italic','forecolor', 'removeformat','formatmatch', 'underline','insertimage','link', 'unlink', 'emotion','inserttable','preview','help']],            
            //autoClearinitialContent:true,//focus时自动清空初始化时的内容            
            wordCount:false,//关闭字数统计         
            elementPathEnabled:false, //关闭elementPath
            minFrameHeight:120,  //编辑器高度置项
			maximumWords:50000,//最多允许字符
			autoHeightEnabled:true,//是否自动长高
			autoFloatEnabled:false//是否保持toolbar的位置不动
        };	
    var editor_a = new baidu.editor.ui.Editor(editorOption);
    editor_a.render( 'replycontent' );
</script>
                              </td>
							</tr>
                            <tr>
								<td height="37" align="right">回复人：</td>
							  <td>
                              <input name="replyman" type="text" id="replyman" size="60" maxlength="500" style="width:130px;" value="<?php if($myrow['replyman']==""){echo $_SESSION["adminname"];}else{echo $myrow['replyman'];}?>">
                              &nbsp;&nbsp;回复时间：<input name="replytime" type="text" id="replytime" value="<?=$myrow['replytime']?>" readonly="readonly" size="12" onclick="WdatePicker({el:'replytime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" /> <img style="cursor:pointer" onClick="WdatePicker({el:'replytime',dateFmt:'yyyy-MM-dd HH:mm:ss',skin:'whyGreen'})" src="Js/My97DatePicker/skin/datePicker.gif" width="16" height="22" title="选择时间" align="absmiddle">
                              </td>
							</tr>                            
                            <tr>
								<td width="14%" height="37" align="right">审核：</td>
								<td><input type="radio" name="shenhe" id="shenhe1" value="0"<?php if($myrow['shenhe']==0){?> checked="checked"<?php }?> />等待审核 <input name="shenhe" type="radio" id="shenhe2" value="1"<?php if($myrow['shenhe']==1){?> checked="checked"<?php }?> />通过 <input type="radio" name="shenhe" id="shenhe3" value="2"<?php if($myrow['shenhe']==2){?> checked="checked"<?php }?> />不通过 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;推荐：<input type="radio" name="tuijian" id="tuijian" value="1"<?php if($myrow['tuijian']==1){?> checked="checked"<?php }?> />是 <input type="radio" name="tuijian" id="tuijian2" value="0"<?php if($myrow['tuijian']==0){?> checked="checked"<?php }?> />否</td>
							</tr>  
							<tr>
								<td height="1" align="center"></td>
								<td></td>
							</tr>
							<tr>
								<td height="37" align="center">&nbsp;</td>
								<td>
									<input name="Submit" type="Submit" value=" 提 交 ">
									<input name="reset" type="reset" value=" 重 置 "> <input name="reload" type="button" id="reload" onClick="window.location.reload()"	value=" 刷 新 "> <input  onClick="history.back();" type="button" value=" 返 回 " name="Submit4"> &nbsp;&nbsp;<input name="action_app" type="hidden" id="action_app" value="saveedit"><input name="fbid" type="hidden" id="fbid" value="<?php echo $myrow['fbid'];?>"></td>
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
                              <form action="admin.php?action=feedback" method="get" name="searchlist" id="searchlist">
                              <input name="keyword" type="text"  id="SearchKeyword"  value="" size="40" maxlength="60" >
                              <select name="searchclassid" id="searchclassid">
                                    <option value="" selected="selected">--<?=$item_name_all?>分类--</option>
                                    <?php
                                   echo $getClass_Option=PinLuo_GetClass_Option($parentid_all,$parentid_all,0);
									?>
                                </select>
                              <select name="searchselect" id="searchselect">
                                <option value="">--类型--</option>
                                <option value="fbtitle">标题</option>
                                <option value="fbcontent">留言内容</option>
                                <option value="author">留言者</option>
                                <option value="email">Email</option>
                                <option value="myphone">电话</option>
                                <option value="replycontent">回复内容</option>
                                <option value="replyman">回复人</option>
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
                              <input name="action" type="hidden" value="feedback" />
                              </form>
                              
                              </td>
						  </tr>
                          
							<tr>
								<td align="center" width="100%">
								
								
								
								
	<form action="admin.php?action=feedback" method="post" name="list" id="list">							
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
$sql="select * from pl_feedback where fbid>0";
if ($keyword!=""){
	$keyword=trim($keyword);
	$searchselect=$_POST["searchselect"];
	if (!$searchselect){
	$searchselect=$_GET["searchselect"];
	}
	switch($searchselect){
		case "fbtitle":
	      $sql.=" and fbtitle like '%".$keyword."%'";
		  break;
		case "fbcontent":
	      $sql.=" and fbcontent like '%".$keyword."%'";
		  break;
		case "author":
	      $sql.=" and author like '%".$keyword."%'";
		  break;
		case "email":
	      $sql.=" and email like '%".$keyword."%'";
		  break;
		case "myphone":
	      $sql.=" and myphone like '%".$keyword."%'";
		  break;
		case "replycontent":
	      $sql.=" and replycontent like '%".$keyword."%'";
		  break;  
		case "replyman":
	      $sql.=" and replyman like '%".$keyword."%'";
		  break;    
		default:
		  $sql.=" and (fbtitle like '%".$keyword."%' or fbcontent like '%".$keyword."%' or author like '%".$keyword."%' or replycontent like '%".$keyword."%')";
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
	
$sql.=" order by orderid desc,updatetime desc,fbid desc";
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
            <td align="center"><?=$info['fbid']?><input name="fbid[]" type="hidden" value="<?=$info['fbid']?>"></td>
            <td align="left"> <a href="admin.php?action=feedback&fbid=<?=$info['fbid']?>&action_app=edit"><?=$info['fbtitle']?></a><?php if($info['tuijian']==1){echo " <font color=red>(荐)</font>";}?></td>
            <td align="left"> <a href="admin.php?action=feedback&searchclassid=<?=$info['classid']?>"><?=getClassName($info['classid'])?></a></td>
            <td align="center"><?=$info['updatetime']?></td>
            <td align="center"><input name="fbrank[]" type="text" value="<?=$info['orderid']?>" size="8"></td>
			<td align="center"><?=$info['hits']?></td>
            <td align="center"><?php if($info['shenhe']==1){echo "通过";}else if($info['shenhe']==2){echo "<font color=\"#777777\">不通过</font>";}else if($info['shenhe']==0){echo "<font color=red>待审</font>";}?></td>
            <td align="center">
 <a href="admin.php?action=feedback&fbid=<?=$info['fbid']?>&action_app=edit">修改</a>  
			</td>
            <td align="center">                        
              <input name="delfbid[]" type="checkbox" value="<?=$info['fbid']?>" >
              <a href="admin.php?action=feedback&action_app=del&fbid=<?=$info['fbid']?>" onClick="return confrim();">删除</a>              
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