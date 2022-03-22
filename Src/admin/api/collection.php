<?php
!defined('IN_CMS') && exit('Access Denied');
//采集入库工具
//URL：http://lrc.5300.cn/pl_admin/api/collection.php?action=collection&api=&song=&geshou=&lrccontent=&zhuanji=&shenhe=1&username=lrc&orderby=0&tuijian=0
require_once("../../include/conn.php");
//require_once("../include/class.php");
    //global $conn;
	//$api=$_POST["api"];已经注销
	$action=$_POST["action"];
	$api2="sadf###@!";//定义API，防止恶意入库
if($action=="collection" && $api==$api2){
    $song=trim($_POST["song"]);
	$geshou=trim($_POST["geshou"]);
	$lrccontent=trim($_POST["lrccontent"]);
	$lrccontent=str_ireplace("<br>","\n",$lrccontent);
	$lrccontent=str_ireplace("www.qqlrc.com","www.5300.cn",$lrccontent);
	$lrccontent=str_ireplace("qqlrc.com","www.5300.cn",$lrccontent);
	$lrccontent=str_ireplace("QQLRC","5300",$lrccontent);
	$zhuanji=trim($_POST["zhuanji"]);
	$shenhe=trim($_POST["shenhe"]);
	$username=trim($_POST["username"]);
	$orderby=trim($_POST["orderby"]);
	if (!is_numeric($orderby)){$orderby=0;}
	$tuijian=$_POST["tuijian"];
	if (!is_numeric($tuijian)){$tuijian=0;}
	if ($song==""){
	   echo("失败：歌曲名称不能为空！");
	   exit;
	   }
	if ($lrccontent==""){
	   echo("失败：LRC内容不能为空！");
	   exit;
	   }	
	$sql = mysql_query("select * from pl_geci where song='$song' and geshou='$geshou'",$conn) or die('失败：执行错误'.mysql_error());//执行查询;	
	$info=mysql_num_rows($sql);//获取查询结果
	    if ($info>0){
	    echo("失败：歌曲".$song."(".$geshou.")已经存在！");
	    exit;
		}else{
			$nowtimes=date('Y-m-d H:i:s',time());
			$result=mysql_query("insert into pl_geci set song='$song',geshou='$geshou',lrccontent='$lrccontent',zhuanji='$zhuanji',shenhe=$shenhe,username='$username',orderby=$orderby,tuijian=$tuijian,updatetime='$nowtimes',jiangli=1",$conn);
	        if ($result){
	       echo("添加成功！");
		   }else{
		   echo("添加失败！");
			   }
			}
	mysql_close($conn);
}else{
	echo("失败：参数不正确！");
	}