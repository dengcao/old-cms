<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
!defined('IN_CMS') && exit('Access Denied');
$Action2=trim($_POST["Action2"]);
if (!$Action2){
	$Action2=trim($_GET["Action2"]);
	}
if($Action2!="my_Mod"){
	  CheckUserPopedom("administrator");//检查已登陆管理员是否具备管理此页面的权限
	  }
	  
$AdminID=trim($_POST["AdminID"]);
if (!$AdminID){
	$AdminID=trim($_GET["AdminID"]);
	}

if ($Action2=="Add"){
	Add();
	}
elseif($Action2=="Mod" and $AdminID){
	Mod();
	}
elseif($Action2=="Del" and $AdminID){
	Del($AdminID);
	}
elseif($Action2=="my_Mod"){
	my_Mod();
	}

function Add(){
global $conn;
$AdminName=trim($_POST["AdminName"]);
$AdminPassed=trim($_POST["AdminPassed"]);
$AdminPassword1=trim($_POST["AdminPassword1"]);
$AdminPassword2=trim($_POST["AdminPassword2"]);
$RealName=trim($_POST["RealName"]);
$Mobile=trim($_POST["Mobile"]);
$Email=trim($_POST["Email"]);
$UserPopedom=array_to_string($_POST["UserPopedom"]);//数组转换为字符串
if ($AdminName==""){
	echo_js("alert('管理员名称不能为空！');history.back();");
	exit;
	}
else if($AdminPassword1=="" or $AdminPassword2==""){
	echo_js("alert('管理员密码不能为空！');history.back();");
	exit;
	}
else if($AdminPassword1!=$AdminPassword2){
	echo_js("alert('两次密码验证不一致！');history.back();");
	exit;
	}	
	
$AdminPassword=md5($AdminPassword1); //转为MD5加密
	$sql = mysql_query("select * from pl_admin where AdminName='".$AdminName."'",$conn) or die('执行错误');//执行查询;					//执行查询语句
	$info=mysql_num_rows($sql);//获取查询结果
	if ($info>0){
	echo_js("alert('用户帐号".$AdminName."已经存在！请您重新输入！');history.back();");
	exit;
		}else{

    $LastLoginIP=$_SERVER['REMOTE_ADDR'];
	$LastLoginTime = date("Y-m-d H:i:s",strtotime("now"));
	$LastLogoutTime = date("Y-m-d H:i:s",strtotime("now"));

	if ($AdminPassed==""){
		$AdminPassed = 0;
		}
	$result=mysql_query("insert into pl_admin set AdminName='$AdminName',AdminPassword='$AdminPassword',RealName='$RealName',Mobile='$Mobile',Email='$Email',LastLoginIP='$LastLoginIP',LastLoginTime='$LastLoginTime',LastLogoutTime='$LastLogoutTime',LoginTimes=0,RndPassword='$UserPopedomCheck_',AdminPassed='$AdminPassed',UserPopedom='$UserPopedom'",$conn);
	    if ($result){
	       echo_js("alert('添加成功！');location.href=\"admin.php?action=admin\";");
		   }else{
		   echo_js("alert('添加失败！');history.back();");
			   }
		}
mysql_close($conn);	
}

function Mod(){
global $conn;
$AdminID=trim($_POST["AdminID"]);
$AdminName=trim($_POST["AdminName"]);
$AdminPassed=trim($_POST["AdminPassed"]);
$AdminPassword1=trim($_POST["AdminPassword1"]);
$AdminPassword2=trim($_POST["AdminPassword2"]);
$RealName=trim($_POST["RealName"]);
$Mobile=trim($_POST["Mobile"]);
$Email=trim($_POST["Email"]);
$UserPopedom=array_to_string($_POST["UserPopedom"]);//数组转换为字符串
if ($AdminName==""){
	echo_js("alert('管理员名称不能为空！');history.back();");
	exit;
	}
else if($AdminPassword1!=$AdminPassword2){
	echo_js("alert('两次密码验证不一致！');history.back();");
	exit;
	}
	
	$AdminPassword=md5($AdminPassword1); //转为MD5加密
	
	if ($AdminPassed==""){
		$AdminPassed = 0;
		}
	
	    if ($AdminPassword1!=""){
		$result=mysql_query("update pl_admin set AdminName='$AdminName',AdminPassword='$AdminPassword',RealName='$RealName',Mobile='$Mobile',Email='$Email',AdminPassed='$AdminPassed',UserPopedom='$UserPopedom' where AdminID=".$AdminID,$conn);
		}else{
	    $result=mysql_query("update pl_admin set AdminName='$AdminName',RealName='$RealName',Mobile='$Mobile',Email='$Email',AdminPassed='$AdminPassed',UserPopedom='$UserPopedom' where AdminID=".$AdminID,$conn);
	       }
	    if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=admin\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
mysql_close($conn);	
}


function my_Mod(){
global $conn;
$AdminName=trim($_POST["AdminName"]);
$AdminPassed=trim($_POST["AdminPassed"]);
$AdminPassword1=trim($_POST["AdminPassword1"]);
$AdminPassword2=trim($_POST["AdminPassword2"]);
$RealName=trim($_POST["RealName"]);
$Mobile=trim($_POST["Mobile"]);
$Email=trim($_POST["Email"]);
if ($AdminName==""){
	echo_js("alert('管理员名称不能为空！');history.back();");
	exit;
	}
else if($AdminPassword1!=$AdminPassword2){
	echo_js("alert('两次密码验证不一致！');history.back();");
	exit;
	}
	
$AdminPassword=md5($AdminPassword1); //转为MD5加密

if ($AdminPassword1!=""){
		$result=mysql_query("update pl_admin set AdminName='$AdminName',AdminPassword='$AdminPassword',RealName='$RealName',Mobile='$Mobile',Email='$Email' where AdminID=".$_SESSION["adminid"],$conn);
		}else{
	    $result=mysql_query("update pl_admin set AdminName='$AdminName',RealName='$RealName',Mobile='$Mobile',Email='$Email' where AdminID=".$_SESSION["adminid"],$conn);
	       }
	    if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=admin&action2=my\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }

mysql_close($conn);	
}

function Del($Adminid){
	global $conn;
	if (!$Adminid){
	echo_js("alert('请先选择要删除的数据！');history.back();");
	exit;
	}else{
	$sql = "delete from pl_admin where AdminID in(".$Adminid.")";					//定义查询语句
	$result=mysql_query($sql,$conn);		//执行SQL语句
	if ($result){
	echo_js("alert('删除成功！');location.href=\"admin.php?action=admin\";");
	}else{
		   echo_js("alert('删除失败！');history.back();");
			   }
		}
	}
?>