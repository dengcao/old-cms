<?php
!defined('IN_CMS') && exit('Access Denied');
require_once("../include/conn.php");
require_once("include/class.php");
pl_session_open();//启用session
Check_Admin();//检查权限

$upload_img_files="../5300/upload/img/";//上传图片文件夹
$upload_file_files="../5300/upload/file/";//上传文件的文件夹
$upload_flash_files="../5300/upload/flash/";//上传flash文件夹
$upload_media_files="../5300/upload/media/";//上传媒体文件的文件夹
$web_all_files="../";//网站总空间

$img_dirsize=get_dirsize($upload_img_files)/1024/1024;//转换为Kb
$img_dirsize=number_format($img_dirsize,2,".","");//格式化数字字符串

$file_dirsize=get_dirsize($upload_file_files)/1024/1024;//转换为Kb
$file_dirsize=number_format($file_dirsize,2,".","");//格式化数字字符串

$flash_dirsize=get_dirsize($upload_flash_files)/1024/1024;//转换为Kb
$flash_dirsize=number_format($flash_dirsize,2,".","");//格式化数字字符串

$media_dirsize=get_dirsize($upload_media_files)/1024/1024;//转换为Kb
$media_dirsize=number_format($media_dirsize,2,".","");//格式化数字字符串

$web_get_db_size=round(show_db_size()/1024 , 2); //转换单位MB

$web_dirsize=get_dirsize($web_all_files)/1024/1024;//转换为Kb
$web_dirsize=number_format($web_dirsize,2,".","");//格式化数字字符串
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title>系统文件占用空间情况</title>
<link href="Css/pl.css" rel="stylesheet" type="text/css">
<script language='JavaScript' src='Js/ValiDate.js'></script>
<script language='JavaScript' src='Js/AlertTxt.js'></script>
<script language='JavaScript' src='Js/tooltip.js'></script>
<script language='JavaScript' src='Js/pop.js'></script>
</head>

<body>
<style type="text/css">
.bgcolor4 strong{
	color:#3880b6;
	}
</style>

<?php
require_once("../include/config.inc.php");
?>

  <table width="98%" border="0" align="center" cellpadding="1" cellspacing="0"  class="bgcolor5">
    <tr>
      <td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#96B3D1" class="bgcolor5">
          <tr>
            <td height="30" colspan="2" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">文件统计情况</span></td>
          </tr>
<tr>
            <td width="86%" height="15" align="center" bgcolor="#F3F8FF" class="bgcolor4"></td>
            <td width="86%" bgcolor="#F3F8FF" class="bgcolor1"></td>
          </tr>
          <tr>
            <td colspan="2" align="right" bgcolor="#F3F8FF" class="bgcolor4">
            
            <table class='table1' width='100%' border='0' cellpadding='0' cellspacing='0'>  <tr>    <td height='22' colspan="2" align='center' valign='middle' class='tableleft1' style='text-align:center'><b>系统文件占用空间情况</b></td>  </tr>  <tr>    <td width='22%' height='32' align="right" valign='middle'>上传图片占用空间：&nbsp;</td>
                <td width='78%' valign='middle'><img src='images/bar.gif' width='<?=ceil($img_dirsize)+1?>' height='10' />&nbsp;<font face=verdana><?=$img_dirsize?>&nbsp;MB</td>
            </tr>
              <tr>
                <td height='32' align="right" valign='middle'>上传附件占用空间：&nbsp;</td>
                <td valign='middle'><img src='images/bar.gif' width='<?=ceil($file_dirsize)+1?>' height='10' />&nbsp;<font face="verdana"><?=$file_dirsize?>&nbsp;MB</font></td>
              </tr>
              <tr>
                <td height='32' align="right" valign='middle'>上传Flash占用空间：&nbsp;</td>
                <td valign='middle'><img src='images/bar.gif' width='<?=ceil($file_dirsize)+1?>' height='10' />&nbsp;<font face="verdana"><?=$flash_dirsize?>&nbsp;MB</font></td>
              </tr>
              <tr>
                <td height='32' align="right" valign='middle'>上传媒体占用空间：&nbsp;</td>
                <td valign='middle'><img src='images/bar.gif' width='<?=ceil($media_dirsize)+1?>' height='10' />&nbsp;<font face="verdana"><?=$media_dirsize?>&nbsp;MB</font></td>
              </tr>
              <tr>
                <td height='32' align="right" valign='middle'>网站文件占用空间总计：&nbsp;</td>
                <td valign='middle'><img src='images/bar.gif' width='<?=ceil($web_dirsize)+1?>' height='10' />&nbsp;<font face="verdana"><?=$web_dirsize?>&nbsp;MB</font></td>
              </tr>
              <tr>
                <td height='32' align="right" valign='middle'>本站MYSQL数据库大小：&nbsp;</td>
                <td valign='middle'><img src='images/bar.gif' width='<?=ceil($web_get_db_size)+1?>' height='10' />&nbsp;<font face="verdana"><?=$web_get_db_size?>&nbsp;MB</font></td>
              </tr>
              <tr>
                <td height='32' align="right" valign='middle'>&nbsp;</td>
                <td valign='middle'>&nbsp;</td>
              </tr>
            </table>
            
            </td>
          </tr>
      </table></td>
    </tr>
  </table>

<?php
require_once 'application/admin_footer.php';		//调用脚部

mysql_close($conn);
?>
<div id="toolTipLayer" style="width:500px;position:absolute;visibility:hidden; font-size:14px;"></div>
<script>initToolTips()</script>
</body>
</html>
