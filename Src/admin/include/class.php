<?php
/**
 * ====================================================================================
 * 后台主体函数库，类库
 * $Author: 邓草   http://caozha.com
 * GitHub：https://github.com/cao-zha
 * Gitee： https://gitee.com/caozha
 * 基于木兰宽松许可证 2.0（Mulan PSL v2）免费开源，您可以自由复制、修改、分发或用于商业用途，但需保留作者版权等声明。详见开源协议：http://license.coscl.org.cn/MulanPSL2
 * old-cms (Software Name) is licensed under Mulan PSL v2. Please refer to: http://license.coscl.org.cn/MulanPSL2
 * ====================================================================================
**/

!defined('IN_CMS') && exit('Access Denied');
//数据库连接
global $conn;
$mysql_conn=new mysql();
$conn=$mysql_conn->ConnStr;


function UserPopedom(){//定义用户权限数组
	$str_config=array("webconfig"=>"网站配置","class"=>"分类管理","label"=>"标签管理","channel"=>"栏目管理","administrator"=>"管理员管理","member"=>"会员管理","product"=>"产品管理","article"=>"新闻管理","feedback"=>"留言反馈","hr"=>"人才招聘","service"=>"在线客服","database"=>"数据库管理");
	return $str_config;
	}

function WriteErrMsg($txt,$gotourl){//输出错误信息
	if ($gotourl==""){$gotourl="javascript:history.back();";}
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<link href=\"Css/pl.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<table width=100% height=100% border=0 align=center cellpadding=0 cellspacing=0><tr><td valign=top>";
echo "<form name=UserLogin method=post runat=server><table cellSpacing=0 cellPadding=0 width=480 align=center border=0><tr><td height=99></td></tr></table>";
echo "<table width=500 border=0 align=center cellPadding=0 cellSpacing=0 style='border:1px #66cc66 solid;' bgcolor=#DDEEEB><tr><td valign=top><table width=100% border=0 align=center cellPadding=4 cellSpacing=0><tr><td height=26 colspan=3 bgcolor=#BAF692>&nbsp;<span class=15green><b class=15green><img src=Images/Manage/arr04.gif width=7 height=8>&nbsp;&nbsp;系统提示信息</b></span></td></tr><tr><td height=10 colspan=3></td></tr><tr><td height=127 colSpan=3 align=left valign=top style='padding-left:12px;' ><font color=red style='font-size:12px;line-height:150%;'>". $txt ."</font></td></tr><tr><td height=27 colSpan=3 align=center ><a href=\"".$gotourl."\" class=bgcolor1>返	回</a></td></tr></table></td></tr></table></form></td></TD></tr></table>";
	}
function Echo_Js($txts){//输出JS
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	echo "<script language=\"javascript\">".$txts."</script>";
	}
/////////////////////////////////////////////////////////////////////////////////////////
//	过程名：CheckComeUrl
//	作  用：禁止直接输入地址访问后台
//	参  数：无
////////////////////////////////////////////////////////////////////////////////////////
function CheckComeUrl(){	
	$strComeUrl = trim(str_ireplace("http://","",strtolower($_SERVER["HTTP_REFERER"])));	
	
	if ($strComeUrl==""){
		$FoundErr = true;
		$ErrMsg = $ErrMsg . "<br><li>对不起，为了系统安全，不允许直接输入地址访问本系统的后台管理页面。</li>";		
		}else{
		
		$strAdminUrl = $_SERVER["SERVER_NAME"];
		
		         if (count(explode(":",$strComeUrl))>1){
			     $strAdminUrl=$strAdminUrl . ":" . $_SERVER["SERVER_PORT"];
		           }
		
		         $strAdminUrl=trim(strtolower($strAdminUrl . $_SERVER["SCRIPT_NAME"]));
				 	
		         if (substr($strComeUrl,0,stripos($strComeUrl,"/"))!=substr($strAdminUrl,0,stripos($strAdminUrl,"/"))){
			      $FoundErr = true;
		          $ErrMsg = $ErrMsg . "<br><li>对不起，为了系统安全，不允许直接输入地址访问本系统的后台管理页面。</li>";
			     }

			}
	   if ($FoundErr == true){
	    WriteErrMsg($ErrMsg,"admin.php?action=login");
		exit;	
	   }
	}
function pl_request($get_post){ //自定义get和post组合方式，先get后post
	if ($_GET[$get_post]){
		return trim($_GET[$get_post]);
		}
	elseif ($_POST[$get_post]){
		return trim($_POST[$get_post]);
		}else{
		return "";
			}
	}
function pl_safe($str){  //过滤非法字符
	if (is_null($str) || trim($str)==""){
		   return "";
		}
	$str=htmlspecialchars($str); //转换文本中的特殊字符	
	$str=str_ireplace("update","",$str);
	$str=str_ireplace("select","",$str);
	$str=str_ireplace("delete","",$str);
	$str=str_ireplace("inner ","",$str);
	$str=str_ireplace("join ","",$str);	
	return trim($str);
	}
function timeoutlogout($outtime){
	//$outtime为超时时间，秒，调用：timeoutlogout(7200000)
	echo "<script language='javascript'>
function timeoutlogout()
{
	alert('由于长时间未操作，为安全起见自动退出系统，如需要管理请重新登录！');
	top.location.href='admin.php?action=logout';
}
var k=setInterval('timeoutlogout()',$outtime);
</script>";
	}

function ValidatorCode(){//生成数字验证码
    header('content-type:image/jpeg');			
$im = imagecreate(55, 20);					
imagefill($im, 0, 0, imagecolorallocate($im, 200, 200, 200));	
for ($i=0;$i<100;$i++){
	imagesetpixel($im,rand()%70,rand()%30,imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255)));
	}
$validatorCode = rand(1000, 9999);//$_GET['code'];
setcookie("validatorCode",$validatorCode);
imagestring($im, rand(3, 5), 5, 3, substr($validatorCode, 0, 1), imagecolorallocate($im, 0, rand(0, 255), rand(0, 255)));
imagestring($im, rand(3, 5), 20, 6, substr($validatorCode, 1, 1), imagecolorallocate($im, rand(0, 255), 0, rand(0, 255)));
imagestring($im, rand(3, 5), 31, 4, substr($validatorCode, 2, 1), imagecolorallocate($im, rand(0, 255), rand(0, 255), 0));
imagestring($im, rand(3, 5), 43, 5, substr($validatorCode, 3, 1), imagecolorallocate($im, 0, rand(0, 255), rand(0, 255)));
imagejpeg($im);
imagedestroy();	
	}
	
function pl_session_open(){//启用session
	include_once("../system/libs/session.inc.php");
	}

function Login_check($AdminName,$AdminPassword,$validatorCode){//验证管理员登陆
  $validatorCode2=$_COOKIE["validatorCode"];
if ($AdminName==""){
	Echo_Js("alert('管理员名称不能为空！');history.back();");
	exit;
	}
else if($AdminPassword==""){
	Echo_Js("alert('管理员密码不能为空！');history.back();");
	exit;
	}
else if($validatorCode==""){
	Echo_Js("alert('验证码不能为空！');history.back();");
	exit;
	}
else if($validatorCode!=$validatorCode2){
	Echo_Js("alert('验证码错误，请刷新页面后重新输入！');location.href='admin.php?action=login';");
	exit;
	}
    global $conn;
	$sql=mysql_query("select * from pl_admin where AdminName='".$AdminName."' and AdminPassword='".md5($AdminPassword)."'",$conn);//执行查询
	$info=mysql_num_rows($sql);//获取查询结果
	 if ($info<=0){
		 $ErrMsg .= "<li>管理员帐号【".$AdminName."】不存在或者登陆密码错误！请您重新输入。</li><br>";
		 WriteErrMsg($ErrMsg,"javascript:history.back();");
   		 exit;
		 }else{
	      while($myrow=mysql_fetch_array($sql)){
			  if ($myrow["AdminPassed"]==0){
		           $ErrMsg .= "<li>帐号【".$AdminName."】已停用！如有任何疑问请与系统管理员联系。</li><br>";
			       WriteErrMsg($ErrMsg,"javascript:history.back();");
	               mysql_close($conn);	
			       exit;
				  }
				  $RndPassword=rand(100000, 999999);
				  $_SESSION["adminid"]=$myrow["AdminID"];
				  $_SESSION["adminname"]=$myrow["AdminName"];
				  $_SESSION["userpopedom"]=$myrow["UserPopedom"];
				  $_SESSION["ranpassword"]=$RndPassword;
				  $result=mysql_query("update pl_admin set LastLoginIP='".getip()."',LastLoginTime='".date("Y-m-d H:i:s",time())."',LoginTimes=".($myrow["LoginTimes"]+1).",RndPassword='".$RndPassword."' where AdminID=".$myrow["AdminID"],$conn);//更新登陆时间
				  Echo_Js("location.href=\"admin.php?action=index\";");
				  //header("location:admin.php?action=index");
				  mysql_close($conn);	
	              exit;
		  }

		}	

	}
	
function Logout(){//退出登陆
	session_destroy();//彻底销毁session
	Echo_Js("top.location.href=\"admin.php?action=login\";");
	exit;
	}
	
function Check_Admin(){//检查是否登陆后台
	if ($_SESSION["adminid"]=="" || $_SESSION["adminname"]=="" || $_SESSION["ranpassword"]==""){
		$ErrMsg .= "<li>登陆已超时，请您重新登陆！您可以<a href='admin.php?action=login' target='_top'>点此重新登录</a>。</li><br>";
		WriteErrMsg($ErrMsg,"admin.php?action=login");
		exit;	
		}else{
		global $conn;
		$pl_SQL=mysql_query("select * from pl_admin where AdminName='".trim($_SESSION["adminname"])."' and RndPassword='".trim($_SESSION["ranpassword"])."'");
		$info=mysql_num_rows($pl_SQL);//获取查询结果
		if ($info<=0){
			$ErrMsg .= "<li>对不起，为了系统安全，本系统不允许两个人使用同一个管理员帐号进行登录！</li><li>因为现在有人已经在其他地方使用此管理员帐号登录了，所以您将不能继续进行网站后台管理操作。您可以<a href='admin.php?action=login' target='_top'>点此重新登录</a>。</li>";
		    WriteErrMsg($ErrMsg,"admin.php?action=login");
			mysql_close($conn);	
		    exit;
			}
	}
	}

function CheckUserPopedom($str){//检查已登陆管理员的权限 $str：管理页面标识，比如webconfig,product,hr,article
    $NowPopedom=explode(",",trim($_SESSION["userpopedom"]));//获取当前登陆用户的权限数组
	$user_popedom=UserPopedom();//系统权限数组
	if(!is_str_in_array($str,$NowPopedom)){
		$ErrMsg .= "<li>抱歉，您没有操作【".$user_popedom[$str]."】的权限；如有任何疑问，请与管理员联系！</li><li>您当前的权限为：".show_my_UserPopedom()."</li><br>";
		WriteErrMsg($ErrMsg,"javascript:history.back();");
		if(is_object($conn)){mysql_close($conn);}
		exit;
		}    
	}

function show_my_UserPopedom(){//获取当前用户的管理权限
	$NowPopedom=explode(",",trim($_SESSION["userpopedom"]));//获取当前登陆用户的权限数组
	$user_popedom=UserPopedom();//系统权限数组
	if($NowPopedom[0]==""){
		return "无权限";
		}
	$UserPopedom_str="";
	foreach($NowPopedom as $key=>$value){
		    if($key==count($NowPopedom)-1){
				    $UserPopedom_str.=$user_popedom[$value];
				}else{
					$UserPopedom_str.=$user_popedom[$value].",";
					}
		}
	return $UserPopedom_str;
	}

function addjifen($username,$jifen){//增加用户积分
    global $conn;
	if(is_numeric($jifen) && $username!=""){
$sql=mysql_query("select jifen from pl_member where username='".$username."'",$conn) or die('执行错误');//执行查询
while($myrow=mysql_fetch_array($sql)){
	  $result=mysql_query("update pl_member set jifen=".($myrow['jifen']+$jifen)." where username='".$username."'",$conn);
   }
     }
	}


function Check_date($date) { //检查日期是否合法日期:2012-01-01
    $dateArr = explode("-", $date);
    if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) {
        return checkdate($dateArr[1],$dateArr[2],$dateArr[0]);
    }
    return false;
}

function Check_time($time) {  //检查时间是否合法时间:12:01:01
    $timeArr = explode(":", $time);
    if (is_numeric($timeArr[0]) && is_numeric($timeArr[1]) && is_numeric($timeArr[2])) {
        if (($timeArr[0] >= 0 && $timeArr[0] <= 23) && ($timeArr[1] >= 0 && $timeArr[1] <= 59) && ($timeArr[2] >= 0 && $timeArr[2] <= 59))
            return true;
        else
            return false;
    }
    return false;
}

function is__date($date_time){//检查时间是否合法:2012-01-01 12:01:01
	 $dateArr = explode(" ", $date_time);
	 if(Check_date($dateArr[0]) && Check_time($dateArr[1])){
		 return true;
		 }else{return false;}
	}


function DateDiff($date1, $date2, $unit = "") { //时间比较函数，返回两个日期相差几秒、几分钟、几小时或几天
    switch ($unit) {
        case 's':
            $dividend = 1;
            break;
        case 'i':
            $dividend = 60;
            break;
        case 'h':
            $dividend = 3600;
            break;
        case 'd':
            $dividend = 86400;
            break;
        default:
            $dividend = 86400;
    }
    $time1 = strtotime($date1);
    $time2 = strtotime($date2);
    if ($time1 && $time2)
        return (float)($time1 - $time2) / $dividend;
    return false;
}


/* 
email地址合法性检查函数 
功能: 
email地址合法性检查 
返回: 
true(地址合法)|false(地址不合法) 
参数: 
$email 待检查的email地址 
*/ 
function emailcheck($email){ 
$ret=false; 
if(strstr($email, '@') && strstr($email, '.')){ 
if(eregi("^([_a-z0-9]+([._a-z0-9-]+)*)@([a-z0-9]{2,}(.[a-z0-9-]{2,})*.[a-z]{2,3})$", $email)){ 
$ret=true; 
} 
} 
return $ret; 
} 

function createtext($file,$data){//生成文本文件，仅适用于生成文本文件
	//$strlen = file_put_contents($file, $data);
	if(!is_dir(dirname($file))){				//判断指定目录是否存在
			@mkdir(dirname($file),0777);	    //创建目录
		}
	if(PHP_OS=="WINNT"){//判断操作系统，以便适应数据中是否将“\n”转义“\r\n”
		$fopen=fopen($file,"wt");
	}else{
		$fopen=fopen($file,"wb");
		}
	$strlen=fwrite($fopen,$data);
	fclose($fopen);
	@chmod($file,0777);
	return $strlen;
}

function PinLuo_GetClass_Option($ParentID,$NowClassid,$k){   //树型列表显示分类名
    //如调用信息类所有栏目：PinLuo_GetClass_Option(0,0,-1)
    if (trim($ParentID)==""){$ParentID=0;}
	$IsOuter_temp="";$visible_temp="";
	global $conn;
	$sql_class=mysql_query("select * from pl_class where parentid=".intval($ParentID)." order by orderby desc,classid asc",$conn) or die('执行错误');//执行查询
	$get_class_num_rows=mysql_num_rows($sql_class);//获取总数
    while($myrow_class=mysql_fetch_array($sql_class)){
		  $strTemp=$strTemp."<option value='".$myrow_class['classid']."' ";
		  if ($NowClassid==$myrow_class['classid']){$strTemp=$strTemp." selected='selected'";}
		  if ($myrow_class['isout']==1){$IsOuter_temp="(外)";}//是否外部链接
		  if ($myrow_class['visible']==1){$visible_temp="(隐)";}//是否隐藏
		  $strTemp=$strTemp.">" . PinLuo_tmp($k,"|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") ."|--&nbsp;".$myrow_class['classname']." ".$IsOuter_temp.$visible_temp."</option>";
		  $strTemp=$strTemp.PinLuo_GetClass_Option($myrow_class['classid'],$NowClassid,$k+1);
		}
	return $strTemp;
}

function PinLuo_tmp($n,$text){   //显示缩进符号
    $PinLuo_tmp="";
	for($i=0;$i<$n;$i++){
		$PinLuo_tmp = $PinLuo_tmp.$text;
	}
	return $PinLuo_tmp;
}

function getClassName($classid){//获取某分类名称
	global $conn;
	if (!$classid){
	return "";
	}else{
		$sql=mysql_query("select classname from pl_class where classid=".$classid,$conn) or die('执行错误');//执行查询
        while($myrow=mysql_fetch_array($sql)){
			return $myrow['classname'];
			}
	}
	}
	
function PinLuo_ViewClass($parentid,$depth,$gotourl){//读取分类列表
	$SqlList = "select A.*, ( select count(B.classid) from pl_class as B where A.classid = B.parentid) as countlist from pl_class as A where A.classid>0 ";
	if ($parentid!=""){
	$SqlList = $SqlList."and parentid=".intval($parentid)." ";
	}else{
	$SqlList = $SqlList."and parentid=0 ";
	}
	if ($depth!=""){ $SqlList = $SqlList."and depth<=".$depth." ";}
	$SqlList = $SqlList."order by A.orderby desc,A.classid ";
	global $conn;
	$sql_class=mysql_query($SqlList,$conn) or die('执行错误');//执行查询
	$get_class_num_rows=mysql_num_rows($sql_class);//获取总数	
    while($myrow_class=mysql_fetch_array($sql_class)){		
		echo "<li id=\"class".$myrow_class["depth"]."\" onmouseover=\"ShowMenu(".$myrow_class["classid"].")\" onmouseout=\"HideMenu(".$myrow_class["classid"].")\"";
	   if ($myrow_class["depth"]>2){
	   echo " style='padding-left:".(($myrow_class["depth"]-2)*25+5)."px;'>|--";
	   }else{
	   echo ">";
	   }
	   if ($gotourl==""){echo $myrow_class["classname"];} else{echo "<a href='".$gotourl."action_app=edit&classid=".$myrow_class["classid"]."'>".$myrow_class["classname"]."</a>";}
	   echo "&nbsp;&nbsp;<font style='color:#999;font-weight:normal'>(".$myrow_class["countlist"].")&nbsp;[".$myrow_class["orderby"]."]</font>";
	   if ($myrow_class["visible"]==1){ echo "&nbsp;<font color=#888888>隐</font>";}
	   if ($myrow_class["isout"]==1){ echo "&nbsp;<font color=red>外</font>";}
	   echo "<span id=\"M".$myrow_class["classid"]."\" style=display:none;font-weight:normal>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$gotourl."action_app=add&parentid=".$myrow_class["classid"]."'>添加小类</a> <a href='".$gotourl."action_app=edit&classid=".$myrow_class["classid"]."'>修改</a> <a href='".$gotourl."action_app=del&classid=".$myrow_class["classid"]."' onclick=\"return cf('".$myrow_class["classname"]."')\">删除</a></span></li>";
	   PinLuo_ViewClass($myrow_class["classid"],$depth,$gotourl);
		}
}

function PinLuo_AddClass($classname,$imgurl,$seo_title,$seo_keyword,$seo_description,$classcontents,$parentid,$isout,$outurl,$visible,$orderby){//添加分类
    if (!is_numeric($parentid)){$parentid=0;}
	if (!is_numeric($orderby)){$orderby=0;}
	global $conn;
	$sql_depth = mysql_query("select depth from pl_class where classid=".$parentid,$conn) or die('执行错误');//执行查询;	
	$info_num=mysql_num_rows($sql_depth);//获取查询结果
	if ($info_num>0){
		while($myrow_depth=mysql_fetch_array($sql_depth)){
			$depth=$myrow_depth['depth']+1;
			}
		}else{
			$depth=1;
			}
		$result=mysql_query("insert into pl_class set classname='$classname',classcontents='$classcontents',imgurl='$imgurl',parentid=$parentid,depth=$depth,isout=$isout,outurl='$outurl',visible=$visible,childid='',seo_title='$seo_title',seo_keyword='$seo_keyword',seo_description='$seo_description',orderby=$orderby",$conn);
	    
		
		//获取当前插入的classid
		$sql_classid = mysql_query("select classid from pl_class where classname='$classname' and imgurl='$imgurl' and parentid=$parentid and depth=$depth and isout=$isout and outurl='$outurl' and visible=$visible and seo_title='$seo_title' and seo_keyword='$seo_keyword' and orderby=$orderby order by classid desc",$conn) or die('执行错误');//执行查询;
		$myrow_classid=mysql_fetch_array($sql_classid);
		if ($myrow_classid){
			$classid=$myrow_classid['classid'];
			}
			
	//更新上级孩子数
	PinLuo_UpdateAddClassChild($classid,$parentid);			
	
	return $result;   

}


function PinLuo_UpdateAddClassChild($NowClassID,$ParentID){//更新父目录的所有子分类，形式如1,2,3...
	global $conn;
	$sql_childid = mysql_query("select * from pl_class where classid=".$ParentID,$conn) or die('执行错误');//执行查询
	while($myrow_childid=mysql_fetch_array($sql_childid)){
			if(is_null($myrow_childid['childid']) || trim($myrow_childid['childid'])==""){
			    $childid=$NowClassID;
				$childid_result=mysql_query("update pl_class set childid='$childid' where classid=".$myrow_childid['classid'],$conn);//更新childid
			   }else{
				$childid=$myrow_childid['childid'].",".$NowClassID;
				$childid_result=mysql_query("update pl_class set childid='$childid' where classid=".$myrow_childid['classid'],$conn);//更新childid				
				   }
			$ParentID=$myrow_childid['parentid'];
			}
	if ($ParentID>0){PinLuo_UpdateAddClassChild($NowClassID,$ParentID);}//循环执行更新			

}

function PinLuo_DeleteInfoClass($classid,$ListDatatable=""){//删除分类，$classid：删除分类的ID，$ListDatatable：删除分类下信息的表名，为空则不删除
    if (!is_numeric($classid)){
		return false;//返回并退出函数
		}
	global $conn;
	$sql_childid = mysql_query("select * from pl_class where classid=".$classid,$conn) or die('执行错误');//执行查询
	while($myrow_childid=mysql_fetch_array($sql_childid)){
		$childid=trim($myrow_childid['childid']);
		if ($childid!="" || !is_null($childid)){
				$result_childid=mysql_query("delete from pl_class where classid in(".$childid.")",$conn);//删除下属分类
					if ($ListDatatable!=""){
				        $result_List=mysql_query("delete from ".$ListDatatable." where classid in(".$childid.")",$conn);//删除下属文章、产品等信息
					}
			}
		$parentid=$myrow_childid['parentid'];
		if ($ListDatatable!=""){
			$result_List=mysql_query("delete from ".$ListDatatable." where classid=".$classid,$conn);//删除下属文章、产品等信息
			}
		}
	$result_myclass=mysql_query("delete from pl_class where classid =".$classid,$conn);//删除分类自身
	//更新上级栏目孩子数
	$childid=$classid.",".$childid;
	PinLuo_UpdateDeleteInfoClassChild($childid,$parentid);
	
	return $result_myclass;
}

function PinLuo_UpdateDeleteInfoClassChild($childid,$parentid){ //更新父目录的所有子分类，形式如1,2,3...
	global $conn;
	$sql_childid = mysql_query("select * from pl_class where classid=".$parentid,$conn) or die('执行错误');//执行查询
	while($myrow_childid=mysql_fetch_array($sql_childid)){
		$childid_my=trim($myrow_childid['childid']);
		if ($childid_my!="" || !is_null($childid_my)){
			  //$ChildIDArr=split(",",$childid);
			  $ChildIDArr=explode(",",$childid);
			  $ChildIDsmtp="|,".$childid_my.",|";
			  foreach ($ChildIDArr as $key=>$value){
				 $value=trim($value);
				 if ($value!=""){
                  $ChildIDsmtp=str_replace(",".$value.",",",",$ChildIDsmtp);
				 }
			  }
			  $ChildIDsmtp=trim(str_replace("|,","",$ChildIDsmtp));
			  $ChildIDsmtp=trim(str_replace(",|","",$ChildIDsmtp));
			  $ChildIDsmtp=trim(str_replace("|","",$ChildIDsmtp));
			  $childid_result=mysql_query("update pl_class set childid='$ChildIDsmtp' where classid=".$myrow_childid['classid'],$conn);//更新childid
			}
			$parentid=$myrow_childid['parentid'];
	}
	if ($parentid>0){PinLuo_UpdateDeleteInfoClassChild($childid,$parentid);}//循环执行更新		
}

 
function RGB2Hex($r=0, $g=0, $b=0){ //RGB转十六进制颜色，RGB2Hex(255,255,255); 
 if($r < 0 || $g < 0 || $b < 0 || $r > 255 || $g > 255|| $b > 255){  
  return false;  
 }  
 return "#".(substr("00".dechex($r),-2)).(substr("00".dechex($g),-2)).(substr("00".dechex($b),-2));  
}  

function Hex2RGB($hexColor){//十六进制颜色转RGB，Hex2RGB("#369fff")
 $color = str_replace("#","",$hexColor);
 if (strlen($color)>3){
  $rgb = array(   
  r => hexdec(substr($color, 0, 2)),   
  g => hexdec(substr($color, 2, 2)),   
  b => hexdec(substr($color, 4, 2))   
  ); 
  }else{   
  $color = str_replace("#","",$hexColor);   
  $r = substr($color, 0, 1) . substr($color, 0, 1);   
  $g = substr($color, 1, 1) . substr($color, 1, 1);   
  $b = substr($color, 2, 1) . substr($color, 2, 1);   
  $rgb = array(   
   r => hexdec($r),   
   g => hexdec($g),   
   b => hexdec($b)   
  );
  }
  return $rgb;
  }   
 
function get_dirsize($dir){//计算某个目录的大小，返回Byte
@$dh = opendir($dir);
$size = 0;
while ($file = @readdir($dh)) {
if ($file != "." and $file != "..") {
$path = $dir."/".$file;
if (is_dir($path)) {
$size += get_dirsize($path);
} elseif (is_file($path)) {
$size += filesize($path);
}
}
}
@closedir($dh);
return $size;
}

function getip() {  //获取IP
	if (getenv ( "HTTP_CLIENT_IP" )) {
		$httpip = getenv ( "HTTP_CLIENT_IP" );
		return $httpip;
	}
	if (getenv ( "HTTP_X_FORWARDED_FOR" )) {
		$httpip = getenv ( "HTTP_X_FORWARDED_FOR" );
		return $httpip;
	}
	if (getenv ( "HTTP_X_FORWARDED" )) {
		$httpip = getenv ( "HTTP_X_FORWARDED" );
		return $httpip;
	}
	if (getenv ( "HTTP_FORWARDED_FOR" )) {
		$httpip = getenv ( "HTTP_FORWARDED_FOR" );
		return $httpip;
	}
	if (getenv ( "HTTP_FORWARDED" )) {
		$httpip = getenv ( "HTTP_FORWARDED" );
		return $httpip;
	}
	$httpip = $_SERVER ['REMOTE_ADDR'];
	
	if (!preg_match("/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/", $httpip)) { 
		$httpip = "127.0.0.1";
	}
	
	return $httpip;
}


function show_db_size(){//获取数据库大小,单位kb
   global $conn;
   $dbsize = 0;
   $tables = mysql_fetch_array(mysql_query("SHOW TABLE STATUS",$conn));
   foreach($tables as $table) {
    $dbsize += $table['Data_length'] + $table['Index_length'];
   }
return $dbsize;
}

function get_table_name($database){//获得数据库的表名
        $result=mysql_list_tables($database);
        $table_name = array();
        for ($i = 0; $i < @mysql_num_rows($result); $i++)
  {
          $table_name[$i]=mysql_tablename($result, $i);
  }
  return $table_name;

     }
	 

function ShowSql_tablelist($db_name=""){//返回数据表列表
        global $conn;
		if ($db_name==""){
			$results = mysql_query("SHOW TABLE STATUS",$conn);
		}else{
			$results = mysql_query("SHOW TABLE STATUS FROM '".$db_name."'",$conn);
			}
		$pl_table = array();
		while($table=mysql_fetch_array($results)){
			$row = array('name'=>$table['Name'],'engine'=>$table['Engine'],'rows'=>$table['Rows'],'size'=>$table['Data_length']+$row['Index_length'],'data_free'=>$table['Data_free'],'collation'=>$table['Collation'],'update_time'=>$table['Update_time']);
			$pl_table[] = $row;
			}
		return $pl_table;
	}


function pl_sizecount($filesize){//格式化字节
	if($filesize >= 1073741824)
	{
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	}
	elseif($filesize >= 1048576)
	{
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	}
	elseif($filesize >= 1024)
	{
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	}
	else
	{
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

function array_to_string($arr,$separator=",",$periphery=""){
	//数组转换为字符串，默认以“,”分开，$periphery为外围，比如'1'，'2','3'……中的'
	if (!is_array($arr)){return $arr;}
	if(!$separator){$separator=",";}
	if(!$periphery){$periphery="";}
	$arr_str="";
	$arr_count=count($arr);
	foreach($arr as $key=>$value){//输出数组
	      if($key==($arr_count-1)){
			  $arr_str.=$periphery.$value.$periphery;
			  }else{
			  $arr_str.=$periphery.$value.$periphery.$separator;
			  }
		}
	return $arr_str;
	}

function get_service_s_type_name($t){
	switch($t){
		case 0:
		  return "其他";
		  break;
		case 1:
		  return "QQ";
		  break;
		case 2:
		  return "邮箱";
		  break;
		case 3:
		  return "电话";
		  break;
		case 4:
		  return "MSN";
		  break;
		case 5:
		  return "Skype";
		  break;
		case 6:
		  return "微博";
		  break;
		case 7:
		  return "新浪UC";
		  break;
		case 8:
		  return "网易泡泡";
		  break;
		default:
		  return "其他";
		  break;
		}
	}
	
function is_str_in_array($str,$arr){//判断某字符串$str是否是数组$arr中的值，返回布尔值
	  if(!is_array($arr) || $str==""){return false;}
	  $is_str_in_array=false;
	  foreach($arr as $key=>$value){
		  if($str==$value){
			  $is_str_in_array=true;
			  break;
			  }
		  }
	  return $is_str_in_array;
	}