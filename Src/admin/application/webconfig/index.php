<?php
!defined('IN_CMS') && exit('Access Denied');
require_once("../include/conn.php");
require_once("include/class.php");
pl_session_open();//启用session
Check_Admin();//检查权限
CheckUserPopedom("webconfig");//检查已登陆管理员是否具备管理此页面的权限
global $conn;
$Action2=trim($_POST["action2"]);
if ($Action2=="saveconfig"){
	$webname=strip_tags($_POST["webname"]);//去除 HTML、XML 以及 PHP 的标签
	$weburl=strip_tags($_POST["weburl"]);
	$webdir=strip_tags($_POST["webdir"]);
	$weblogo=strip_tags($_POST["weblogo"]);
	$webbanner=strip_tags($_POST["webbanner"]);
	$webseotitle=strip_tags($_POST["webseotitle"]);
	$index_seotitle=strip_tags($_POST["index_seotitle"]);
	$index_seokeywords=strip_tags($_POST["index_seokeywords"]);
	$index_seodescription=strip_tags($_POST["index_seodescription"]);
	$iswatermark=strip_tags($_POST["iswatermark"]);
	$watermark_text=strip_tags($_POST["watermark_text"]);
	$watermark_text_color=strip_tags($_POST["watermark_text_color"]);
	$watermark_text_fontfamily=strip_tags($_POST["watermark_text_fontfamily"]);
	$watermark_text_size=strip_tags($_POST["watermark_text_size"]);
	$watermark_img=strip_tags($_POST["watermark_img"]);
	$iswebclose=strip_tags($_POST["iswebclose"]);
	$webclose_cause=strip_tags($_POST["webclose_cause"]);
	$watermark_minwidth=strip_tags($_POST["watermark_minwidth"]);
	$watermark_minheight=strip_tags($_POST["watermark_minheight"]);
	$watermark_pct=strip_tags($_POST["watermark_pct"]);
	$watermark_quality=strip_tags($_POST["watermark_quality"]);
	$watermark_pos=strip_tags($_POST["watermark_pos"]);
	$isthumb=strip_tags($_POST["isthumb"]);
	$thumb_width=strip_tags($_POST["thumb_width"]);
	$thumb_height=strip_tags($_POST["thumb_height"]);
	$upload_front=strip_tags($_POST["upload_front"]);
	$upload_maxsize=strip_tags($_POST["upload_maxsize"]);
	$isservice_online=strip_tags($_POST["isservice_online"]);
	$web_date_default_timezone=strip_tags($_POST["web_date_default_timezone"]);
	$is_web_cache=strip_tags($_POST["is_web_cache"]);
	$web_cache_time=strip_tags($_POST["web_cache_time"]);
	/*$result=mysql_query("update pl_config set webname='$webname',weburl='$weburl',webdir='$webdir',weblogo='$weblogo',webbanner='$webbanner',webseotitle='$webseotitle',index_seotitle='$index_seotitle',index_seokeywords='$index_seokeywords',index_seodescription='$index_seodescription',iswatermark=$iswatermark,watermark_text='$watermark_text',watermark_text_color='$watermark_text_color',watermark_text_size=$watermark_text_size,watermark_img='$watermark_img',iswebclose=$iswebclose,webclose_cause='$webclose_cause' where id=1",$conn);
	if ($result){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=webconfig\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
*/
$file="../include/config.inc.php";
$data="<?php \n";
$data.="//=========系统初始化配置，以下信息请勿修改===================\n";
$data.="error_reporting(E_ALL & (E_NOITICE) & ~(E_WARNING));//忽略错误警告\n";
$data.="define('SYS_BASE_PATH_ROOT',realpath(dirname(__FILE__).'/../').'/'); //定义服务器的绝对路径\n";
$data.="define('IN_CMS',true);\n";
$data.="//=========系统初始化配置，以上信息请勿修改===================\n";
$data.="\n\n//服务器基本配置\n";
$data.="define('WEB_DATE_DEFAULT_TIMEZONE','".$web_date_default_timezone."');  //系统时区设置\n";
$data.="@date_default_timezone_set('Etc/GMT'.(WEB_DATE_DEFAULT_TIMEZONE > 0 ? '-' : '+').(abs(WEB_DATE_DEFAULT_TIMEZONE)));\n";
$data.="\n//网站基本信息配置\n";
$data.="define('WEB_NAME','".$webname."');  //网站名称\n";
$data.="define('WEB_URL','".$weburl."');  //网站URL地址，由http://开头\n";
$data.="define('WEB_DIR','".$webdir."');  //网站安装目录\n";
$data.="define('WEB_LOGO','".$weblogo."');  //网站LOGO\n";
$data.="define('WEB_BANNER','".$webbanner."');  //网站Banner\n";
$data.="\n//页面缓存设置\n";
$data.="define('WEB_ISCACHE',".$is_web_cache.");  //是否开启缓存\n";
$data.="define('WEB_CACHE_TIME','".$web_cache_time."');  //页面缓存时间，单位：秒\n";
$data.="\n//网站SEO配置\n";
$data.="define('WEB_SEOTITLE','".$webseotitle."');  //全站SEO标题\n";
$data.="define('WEB_SEOTITLE_INDEX','".$index_seotitle."');  //首页SEO标题\n";
$data.="define('WEB_SEOKEYWORDS_INDEX','".$index_seokeywords."');  //首页SEO关键字\n";
$data.="define('WEB_SEODESCRIPTION_INDEX','".$index_seodescription."');  //首页SEO描述\n";
$data.="\n//图片加水印配置\n";
$data.="define('WEB_ISWATERMARK','".$iswatermark."');  //是否启用水印，0为不启用，1为文字水印，2为图片水印\n";
$data.="define('WEB_WATERMARK_TEXT','".$watermark_text."');  //水印文字，比如填网址：www.5300.cn\n";
$data.="define('WEB_WATERMARK_TEXT_COLOR','".$watermark_text_color."');  //水印文字颜色\n";
$data.="define('WEB_WATERMARK_TEXT_FAMILY','".$watermark_text_fontfamily."');  //水印文字字体\n";
$data.="define('WEB_WATERMARK_TEXT_SIZE','".$watermark_text_size."');  //水印字体大小\n";
$data.="define('WEB_WATERMARK_IMG','".$watermark_img."');  //水印图片\n";
$data.="define('WEB_WATERMARK_MINWIDTH','".$watermark_minwidth."');  //设置加水印条件：宽，小于此尺寸的图片将不加水印\n";
$data.="define('WEB_WATERMARK_MINHEIGHT','".$watermark_minheight."');  //设置加水印条件：高，小于此尺寸的图片将不加水印\n";
$data.="define('WEB_WATERMARK_PCT','".$watermark_pct."');  //水印图片透明度，范围为 1~100 的整数，数值越小水印图片越透明\n";
$data.="define('WEB_WATERMARK_QUALITY','".$watermark_quality."');  //JPEG 水印质量，范围为 0~100 的整数，数值越大结果图片效果越好，但尺寸也越大\n";
$data.="define('WEB_WATERMARK_POS','".$watermark_pos."');  //水印添加位置，共1-9个位置\n";
$data.="\n//图片缩略图功能配置\n";
$data.="define('WEB_ISTHUMB','".$isthumb."');  //是否启用缩略图功能，0为不启用，1为启用\n";
$data.="define('WEB_THUMB_WIDTH','".$thumb_width."');  //设置缩略图大小：宽\n";
$data.="define('WEB_THUMB_HEIGHT','".$thumb_height."');  //设置缩略图大小：高\n";
$data.="\n//网站上传附件设置\n";
$data.="define('WEB_UPLOAD_FRONT','".$upload_front."');  //是否允许前台上传\n";
$data.="define('WEB_UPLOAD_MAXSIZE','".$upload_maxsize."');  //允许上传大小\n";
$data.="\n//在线客服设置\n";
$data.="define('WEB_ISSERVICE','".$isservice_online."');  //是否启用在线客服，0为不启用，1为启用\n";
$data.="\n//网站关闭维护设置\n";
$data.="define('WEB_ISWEBCLOSE','".$iswebclose."');  //是否关闭网站，0为不关闭，1为关闭；此设置仅对动态页面生效\n";
$data.="define('WEB_WEBCLOSE_CAUSE','".$webclose_cause."');  //网站关闭原因\n";


if (createtext($file,$data)>0){
	       echo_js("alert('修改成功！');location.href=\"admin.php?action=webconfig\";");
		   }else{
		   echo_js("alert('修改失败！');history.back();");
			   }
mysql_close($conn);
exit;
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title>网站信息配置</title>
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

function checkarray_option($t){
		if($t==WEB_DATE_DEFAULT_TIMEZONE){echo " selected=\"selected\"";}
		}
?>
        <link rel="stylesheet" href="../editor2/themes/default/default.css" />
        <script src="../editor2/kindeditor.js"></script>
		<script src="../editor2/lang/zh_CN.js"></script>
<form action="admin.php?action=webconfig" method="post" name="SiteConfig" id="SiteConfig">
<br>
  <table width="98%" border="0" align="center" cellpadding="1" cellspacing="0"  class="bgcolor5">
    <tr>
      <td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#96B3D1" class="bgcolor5">
          <tr>
            <td height="30" colspan="2" bgcolor="C0D5F0" class="Main_box_header"><img style="float:left" src="Images/Main_box_header_Icon.gif" /><span style="float:left" class="Main_box_header_title">网站信息配置</span></td>
          </tr>
<tr>
            <td width="14%" height="15" align="center" bgcolor="#F3F8FF" class="bgcolor4"></td>
            <td width="86%" bgcolor="#F3F8FF" class="bgcolor1"></td>
          </tr>
          <tr>
            <td width="14%" height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站名称：</strong></td>
            <td width="86%" bgcolor="#F3F8FF" class="bgcolor1"><input name="webname" type="text" class="input" id="webname" value="<?=WEB_NAME?>" size="50" maxlength="255" >
            <font color="#FF0000"> * </font> <font color="#999999">公司名称，网站名称等等。</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站地址：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="weburl" type="text" class="input" id="weburl" value="<?=WEB_URL?>" size="50" maxlength="255" >
            <font color="#FF0000"> * </font> <font color="#999999">网站URL地址,结尾包含/</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站安装目录：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="webdir" type="text" class="input" id="webdir" value="<?=WEB_DIR?>" size="50" maxlength="255" >
            <font color="#FF0000"> * </font> <font color="#999999">结尾包含/,如根目录请填写/</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站LOGO：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="weblogo" type="text" class="input" id="weblogo" value="<?=WEB_LOGO?>" size="35" maxlength="500" > <input type="button" id="upload_weblogo" value="选择图片" />	
             <font color="#999999">网站LOGO图片</font>
             <script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_weblogo').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#weblogo').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#weblogo').val(url);
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
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站Banner：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="webbanner" type="text" class="input" id="webbanner" value="<?=WEB_BANNER?>" size="35" maxlength="500" > <input type="button" id="upload_webbanner" value="选择图片" />	
             <font color="#999999">网站Banner图片</font>
             <script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_webbanner').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#webbanner').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#webbanner').val(url);
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
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>是否开启缓存：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="is_web_cache" type="radio" id="is_web_cache1" value="true" <?php if(WEB_ISCACHE==true){ ?> checked="checked" <?php } ?> />
              <label for="is_web_cache1">是</label> &nbsp;&nbsp;<input type="radio" name="is_web_cache" id="is_web_cache0" value="false"  <?php if(WEB_ISCACHE==false){ ?> checked="checked" <?php } ?> />
              <label for="is_web_cache0">否</label> &nbsp;&nbsp;<font color="#999999">建议开启，可减轻服务器压力，提升访问速度</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>页面缓存时间：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
            <input name='web_cache_time' type='text' id='web_cache_time' value='<?=WEB_CACHE_TIME?>' size='5' maxlength='11'> 秒
             <font color="#FF0000"> * </font>&nbsp;&nbsp; <font color="#999999">建议设置值大于3600秒</font></td>
          </tr>
          
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>允许前台上传：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="upload_front" type="radio" id="upload_front1" value="1" <?php if(WEB_UPLOAD_FRONT==1){ ?> checked="checked" <?php } ?> />
              <label for="upload_front1">是</label> &nbsp;&nbsp;<input type="radio" name="upload_front" id="upload_front0" value="0"  <?php if(WEB_UPLOAD_FRONT==0){ ?> checked="checked" <?php } ?> />
              <label for="upload_front0">否</label> &nbsp;&nbsp;<font color="#999999">为了安全，如无必要，建议关闭前台的上传功能</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>允许上传的文件大小：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
            <input name='upload_maxsize' type='text' id='upload_maxsize' value='<?=WEB_UPLOAD_MAXSIZE?>' size='5' maxlength='5'> Kb
             <font color="#FF0000"> * </font>&nbsp;&nbsp; <font color="#999999">设置允许最大上传文件的大小，当前系统最大允许上传<?=get_cfg_var(upload_max_filesize)?>的文件，请设置小于此值</font></td>
          </tr>
          
          <?php
          if(!extension_loaded('gd')){//检测GD库支持
			  ?>		
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><font color="red">提示：系统检测到您的服务器不支持GD库，将不能使用生成缩略图和水印的功能，请联系您的空间商安装PHP的GD库组件。</font></td>
          </tr>
          <?php	  
			  }
		  ?>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>缩略图功能：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="isthumb" type="radio" id="isthumb0" value="0" <?php if(WEB_ISTHUMB==0){ ?> checked="checked" <?php } ?>  onclick="Showthumb(0);" />
              <label for="isthumb0">不启用</label> &nbsp;&nbsp;<input type="radio" name="isthumb" id="isthumb1" value="1"  <?php if(WEB_ISTHUMB==1){ ?> checked="checked" <?php } ?> onclick="Showthumb(1);" />
              <label for="isthumb1">启用</label></td>
          </tr>
          <script language="javascript">
          function Showthumb(t){
			  if(t==1){
				     for (i=1;i<=2;i++){
				       document.getElementById("Show_thumb"+i).style.display="";					   
					 }
				  }else{
					  for (i=1;i<=2;i++){
				       document.getElementById("Show_thumb"+i).style.display="none";
					  }
				   }
			  }
          </script>
          <tr style="display:<?php if(WEB_ISTHUMB==0){echo "none";}else{echo "";} ?>;" id="Show_thumb1">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>缩略图大小：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
            <input name='thumb_width' type='text' id='thumb_width' value='<?=WEB_THUMB_WIDTH?>' size='5' maxlength='5'> X <input name='thumb_height' type='text' id='thumb_height' value='<?=WEB_THUMB_HEIGHT?>' size='5' maxlength='5'> px
             <font color="#FF0000"> * </font> <font color="#999999">设置缩略图的大小，小于此尺寸的图片附件将不生成缩略图</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISTHUMB==0){echo "none";}else{echo "";} ?>;" id="Show_thumb2">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>缩略图算法：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
            <font color="#999999">宽和高都大于0时，缩小成指定大小，其中一个为0时，按比例缩小</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>上传图片加水印：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="iswatermark" type="radio" id="iswatermark0" value="0" <?php if(WEB_ISWATERMARK==0){ ?> checked="checked" <?php } ?>  onclick="ShowWatermark(0);" />
              <label for="iswatermark0">不加水印</label> &nbsp;&nbsp;<input type="radio" name="iswatermark" id="iswatermark1" value="1"  <?php if(WEB_ISWATERMARK==1){ ?> checked="checked" <?php } ?> onclick="ShowWatermark(1);" />
              <label for="iswatermark1">文字水印</label> &nbsp;&nbsp;<input type="radio" name="iswatermark" id="iswatermark2" value="2"  <?php if(WEB_ISWATERMARK==2){ ?> checked="checked" <?php } ?> onclick="ShowWatermark(2);" />
              <label for="iswatermark2">图片水印</label></td>
          </tr>
          <script language="javascript">
          function ShowWatermark(t){
			  if(t==1){
				     for (i=1;i<=4;i++){
				       document.getElementById("Show_watermark_text"+i).style.display="";					   
					 }
					 for (i=1;i<=2;i++){
				       document.getElementById("Show_watermark_img"+i).style.display="none";
					 }
					 for (i=1;i<=3;i++){
				       document.getElementById("Show_watermark"+i).style.display="";
					 }
				  }else if(t==2){
					  for (i=1;i<=4;i++){
				       document.getElementById("Show_watermark_text"+i).style.display="none";
					 }
					 for (i=1;i<=2;i++){
				       document.getElementById("Show_watermark_img"+i).style.display="";
					 }
					 for (i=1;i<=3;i++){
				       document.getElementById("Show_watermark"+i).style.display="";
					 }
				  }else{
					  for (i=1;i<=4;i++){
				       document.getElementById("Show_watermark_text"+i).style.display="none";
					 }
					 for (i=1;i<=2;i++){
				       document.getElementById("Show_watermark_img"+i).style.display="none";
					 }
					 for (i=1;i<=3;i++){
				       document.getElementById("Show_watermark"+i).style.display="none";
					 }
				   }
			  }
          </script>
          <tr style="display:<?php if(WEB_ISWATERMARK==0){echo "none";}else{echo "";} ?>;" id="Show_watermark1">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印添加条件：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name='watermark_minwidth' type='text' id='watermark_minwidth' value='<?=WEB_WATERMARK_MINWIDTH?>' size='5' maxlength='5'> X <input name='watermark_minheight' type='text' id='watermark_minheight' value='<?=WEB_WATERMARK_MINHEIGHT?>' size='5' maxlength='5'> px
             <font color="#FF0000"> * </font> <font color="#999999">设置加水印条件，小于此尺寸的图片将不加水印</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==1){echo "";}else{echo "none";} ?>;" id="Show_watermark_text1">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印文字：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="watermark_text" type="text" class="input" id="watermark_text" value="<?=WEB_WATERMARK_TEXT?>" size="50" maxlength="255" >
             <font color="#FF0000"> * </font> <font color="#999999">比如填网址：www.5300.cn</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==1){echo "";}else{echo "none";} ?>;" id="Show_watermark_text2">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印文字颜色：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="watermark_text_color" type="text" class="input" id="watermark_text_color" value="<?=WEB_WATERMARK_TEXT_COLOR?>" size="15" maxlength="7" > <font color="#FF0000"> * </font> 
          <input type="button" id="colorpicker" value="选择颜色" /> <font color="#999999">比如黑色为：#000000，红色：#ff0000</font>
           <script language="javascript">
			KindEditor.ready(function(K) {
				var colorpicker;
				K('#colorpicker').bind('click', function(e) {
					e.stopPropagation();
					if (colorpicker) {
						colorpicker.remove();
						colorpicker = null;
						return;
					}
					var colorpickerPos = K('#colorpicker').pos();
					colorpicker = K.colorpicker({
						x : colorpickerPos.x,
						y : colorpickerPos.y + K('#colorpicker').height(),
						z : 19811214,
						selectedColor : 'default',
						noColor : '无颜色',
						click : function(color) {
							K('#watermark_text_color').val(color);
							colorpicker.remove();
							colorpicker = null;
						}
					});
				});
				K(document).click(function() {
					if (colorpicker) {
						colorpicker.remove();
						colorpicker = null;
					}
				});
			});
		</script>
           </td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==1){echo "";}else{echo "none";} ?>;" id="Show_watermark_text3">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印字体：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><select name="watermark_text_fontfamily" id="watermark_text_fontfamily">            
              <optgroup label="自定义字体" title="自定义字体">
              <?php
			  $font_path="../include/fonts/";
              if(is_dir($font_path)){
				  $font_dir=scandir($font_path);//遍历目录，获取文件名
				  foreach($font_dir as $value){
					  if(substr($value,0,1)=="."){//判断是否目录，去除目录
						  continue;
						  }
					  echo "<option value=\"/include/fonts/$value\"";
					  if (WEB_WATERMARK_TEXT_FAMILY=="/include/fonts/".$value){echo "  selected=\"selected\"";}
					  echo ">$value</option>";
					  }
				  }
			  ?>
              </optgroup>
            <optgroup label="Windows字体" title="<?php if (PHP_OS!="WINNT"){echo "您的服务器系统不是Windows，请不要选择Windows字体";}else{echo "Windows字体";}?>">
              <option value="c:/windows/fonts/simli.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/simli.ttf"){echo "  selected=\"selected\"";}?>>隶书</option>
              <option value="c:/windows/fonts/simkai.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/simkai.ttf"){echo "  selected=\"selected\"";}?>>楷体</option>
              <option value="c:/windows/fonts/simhei.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/simhei.ttf"){echo "  selected=\"selected\"";}?>>黑体</option>
              <option value="c:/windows/fonts/simsun.ttc"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/simsun.ttc"){echo "  selected=\"selected\"";}?>>宋体</option>
              <option value="c:/windows/fonts/msyh.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/msyh.ttf"){echo "  selected=\"selected\"";}?>>微软雅黑</option>
              <option value="c:/windows/fonts/arial.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/arial.ttf"){echo "  selected=\"selected\"";}?>>Arial</option>
              <option value="c:/windows/fonts/verdana.ttf"<?php if(PHP_OS!="WINNT"){echo " disabled=\"disabled\"";}else if(WEB_WATERMARK_TEXT_FAMILY=="c:/windows/fonts/verdana.ttf"){echo "  selected=\"selected\"";}?>>Verdana</option>
              </optgroup>
            </select>              <font color="#FF0000"> * </font>&nbsp;&nbsp;
            <font color="#999999">可自定制字体，将字体文件(.ttf)放到网站/include/fonts/目录即可</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==1){echo "";}else{echo "none";} ?>;" id="Show_watermark_text4">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印文字大小：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="watermark_text_size" type="text" class="input" id="watermark_text_size" value="<?=WEB_WATERMARK_TEXT_SIZE?>" size="15" maxlength="3" > px <font color="#FF0000"> * </font>&nbsp;&nbsp;
            <font color="#999999">建议填写数值：10~30</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==2){echo "";}else{echo "none";} ?>;" id="Show_watermark_img1">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印图片：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="watermark_img" type="text" class="input" id="watermark_img" value="<?=WEB_WATERMARK_IMG?>" size="35" maxlength="500" > <font color="#FF0000"> * </font> <input type="button" id="upload_watermark_img" value="选择图片" />&nbsp;&nbsp;<font color="#999999">建议使用透明图片作为水印图片，否则会严重影响图片质量。</font>
            <script>
			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager : true
				});
				
				K('#upload_watermark_img').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							imageUrl : K('#watermark_img').val(),
							clickFn : function(url, title, width, height, border, align) {
								K('#watermark_img').val(url);
								editor.hideDialog();
							}
						});
					});
				});
				
			});
		</script>
            </td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==2){echo "";}else{echo "none";} ?>;" id="Show_watermark_img2">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印图片透明度：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name='watermark_pct' type='text' id='watermark_pct' value='<?=WEB_WATERMARK_PCT?>' size='10' maxlength='10'>
             <font color="#FF0000"> * </font> <font color="#999999">范围为 1~100 的整数，数值越小水印图片越透明</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==0){echo "none";}else{echo "";} ?>;" id="Show_watermark2">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>JPEG 水印质量：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name='watermark_quality' type='text' id='watermark_quality' value='<?=WEB_WATERMARK_QUALITY?>' size='10' maxlength='10'>
             <font color="#FF0000"> * </font> <font color="#999999">范围为 0~100 的整数，数值越大结果图片效果越好，但尺寸也越大</font></td>
          </tr>
          <tr style="display:<?php if(WEB_ISWATERMARK==0){echo "none";}else{echo "";} ?>;" id="Show_watermark3">
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>水印添加位置：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><table cellspacing="1" cellpadding="4" width="160" bgcolor="#dddddd">
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="watermark_pos" value="1" id="watermark_pos1"<?php if(WEB_WATERMARK_POS==1){echo " checked";}?>> <label for="watermark_pos1">#1</label></td><td><input type="radio" name="watermark_pos" value="2" id="watermark_pos2"<?php if(WEB_WATERMARK_POS==2){echo " checked";}?>> <label for="watermark_pos2">#2</label></td><td><input type="radio" name="watermark_pos" value="3" id="watermark_pos3"<?php if(WEB_WATERMARK_POS==3){echo " checked";}?>> <label for="watermark_pos3">#3</label></td></tr>
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="watermark_pos" value="4" id="watermark_pos4"<?php if(WEB_WATERMARK_POS==4){echo " checked";}?>> <label for="watermark_pos4">#4</label></td><td><input type="radio" name="watermark_pos" value="5" id="watermark_pos5"<?php if(WEB_WATERMARK_POS==5){echo " checked";}?>> <label for="watermark_pos5">#5</label></td><td><input type="radio" name="watermark_pos" value="6" id="watermark_pos6"<?php if(WEB_WATERMARK_POS==6){echo " checked";}?>> <label for="watermark_pos6">#6</label></td></tr>
	  <tr align="center" bgcolor="#ffffff"><td><input type="radio" name="watermark_pos" value="7" id="watermark_pos7"<?php if(WEB_WATERMARK_POS==7){echo " checked";}?>> <label for="watermark_pos7">#7</label></td><td><input type="radio" name="watermark_pos" value="8" id="watermark_pos8"<?php if(WEB_WATERMARK_POS==8){echo " checked";}?>> <label for="watermark_pos8">#8</label></td><td><input type="radio" name="watermark_pos" value="9" id="watermark_pos9"<?php if(WEB_WATERMARK_POS==9){echo " checked";}?>> <label for="watermark_pos9">#9</label></td></tr>
	  </table>
            </td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>在线客服：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="isservice_online" type="radio" id="isservice_online1" value="1" <?php if(WEB_ISSERVICE==1){ ?> checked="checked" <?php } ?> />
              <label for="isservice_online1">启用</label> &nbsp;&nbsp;<input type="radio" name="isservice_online" id="isservice_online0" value="0"  <?php if(WEB_ISSERVICE==0){ ?> checked="checked" <?php } ?> />
              <label for="isservice_online0">不启用</label> &nbsp;&nbsp;<font color="#999999">是否使用系统集成的在线客服功能</font></td>
          </tr>
           <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>全站SEO标题：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="webseotitle" type="text" class="input" id="webseotitle" value="<?=WEB_SEOTITLE?>" size="50" maxlength="255" >
             <font color="#999999">针对SEO优化网站标题</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>首页SEO标题：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="index_seotitle" type="text" class="input" id="index_seotitle" value="<?=WEB_SEOTITLE_INDEX?>" size="50" maxlength="255" >
             <font color="#999999">针对网站首页SEO优化的标题</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>首页SEO关键字：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="index_seokeywords" type="text" class="input" id="index_seokeywords" value="<?=WEB_SEOKEYWORDS_INDEX?>" size="50" maxlength="500" >
             <font color="#999999">设置网站首页的关键词，推荐不超过5个关键词，中间用<font color="#FF6600">,</font>分开。</font></td>
          </tr>
          <tr>
            <td height="110" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>首页SEO描述：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
			<textarea name="index_seodescription" cols="70" rows="6" class="textarea" id="index_seodescription"><?=WEB_SEODESCRIPTION_INDEX?></textarea>              
            <a href="javascript:admin_Size(-3,'index_seodescription')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'index_seodescription')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a> <font color="#999999">设置首页的SEO描述，简要描述您网站的内容,最多500字。</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>是否关闭网站：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1"><input name="iswebclose" type="radio" id="iswebclose1" onclick="ShowWebclose(0);" value="0" <?php if(WEB_ISWEBCLOSE==0){ ?> checked="checked" <?php } ?>  />
              <label for="iswebclose1">不关闭</label> &nbsp;&nbsp;<input type="radio" name="iswebclose" id="iswebclose2" onclick="ShowWebclose(1);" value="1" <?php if(WEB_ISWEBCLOSE==1){ ?> checked="checked" <?php } ?>  />
              <label for="iswebclose2">暂时关闭</label> &nbsp;&nbsp;<font color="#999999">（此设置仅对动态页面生效）</font></td>
          </tr>
          <script language="javascript">
          function ShowWebclose(t){
			  if(t==1){
				       document.getElementById("webclose1").style.display="";
				  }else{
					   document.getElementById("webclose1").style.display="none";
				   }
			  }
          </script>
          <tr style="display:<?php if(WEB_ISWEBCLOSE==1){echo "";}else{echo "none";} ?>;" id="webclose1">
            <td height="110" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>网站关闭原因：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
			<textarea name="webclose_cause" cols="70" rows="6" class="textarea" id="webclose_cause"><?=WEB_WEBCLOSE_CAUSE?></textarea>              
            <a href="javascript:admin_Size(-3,'webclose_cause')"><img src="images/minus.gif" width="18" height="18" border='0' unselectable="on"></a> <a href="javascript:admin_Size(3,'webclose_cause')"><img src="images/plus.gif" width="18" height="18" border='0' unselectable="on"></a> <font color="#999999">简述网站关闭的原因供前台查看,最多1000字。</font></td>
          </tr>
          <tr>
            <td height="36" align="right" bgcolor="#F3F8FF" class="bgcolor4"><strong>系统时区设置：</strong></td>
            <td bgcolor="#F3F8FF" class="bgcolor1">            
            <select name="web_date_default_timezone" id="web_date_default_timezone">
                                <option value="-12" <?php checkarray_option('-12');?>>(GMT -12:00) Eniwetok, Kwajalein</option>
								<option value="-11" <?php checkarray_option('-11');?>>(GMT -11:00) Midway Island, Samoa</option>
								<option value="-10" <?php checkarray_option('-10');?>>(GMT -10:00) Hawaii</option>
								<option value="-9" <?php checkarray_option('-9');?>>(GMT -09:00) Alaska</option>
								<option value="-8" <?php checkarray_option('-8');?>>(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
								<option value="-7" <?php checkarray_option('-7');?>>(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
								<option value="-6" <?php checkarray_option('-6');?>>(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
								<option value="-5" <?php checkarray_option('-5');?>>(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
								<option value="-4" <?php checkarray_option('-4');?>>(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
								<option value="-3.5" <?php checkarray_option('-3.5');?>>(GMT -03:30) Newfoundland</option>
								<option value="-3" <?php checkarray_option('-3');?>>(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
								<option value="-2" <?php checkarray_option('-2');?>>(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
								<option value="-1" <?php checkarray_option('-1');?>>(GMT -01:00) Azores, Cape Verde Islands</option>
								<option value="0" <?php checkarray_option('0');?>>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
								<option value="1" <?php checkarray_option('1');?>>(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
								<option value="2" <?php checkarray_option('2');?>>(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
								<option value="3" <?php checkarray_option('3');?>>(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
								<option value="3.5" <?php checkarray_option('3.5');?>>(GMT +03:30) Tehran</option>
								<option value="4" <?php checkarray_option('4');?>>(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
								<option value="4.5" <?php checkarray_option('4.5');?>>(GMT +04:30) Kabul</option>
								<option value="5" <?php checkarray_option('5');?>>(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
								<option value="5.5" <?php checkarray_option('5.5');?>>(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
								<option value="5.75" <?php checkarray_option('5.75');?>>(GMT +05:45) Katmandu</option>
								<option value="6" <?php checkarray_option('6');?>>(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
								<option value="6.5" <?php checkarray_option('6.5');?>>(GMT +06:30) Rangoon</option>
								<option value="7" <?php checkarray_option('7');?>>(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
								<option value="8" <?php checkarray_option('8');?>>(GMT +08:00) &#x5317;&#x4eac;(Beijing), Hong Kong, Perth, Singapore, Taipei</option>
								<option value="9" <?php checkarray_option('9');?>>(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
								<option value="9.5" <?php checkarray_option('9.5');?>>(GMT +09:30) Adelaide, Darwin</option>
								<option value="10" <?php checkarray_option('10');?>>(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
								<option value="11" <?php checkarray_option('11');?>>(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
								<option value="12" <?php checkarray_option('12');?>>(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
                                </select>
                                
             <?php /* <option value="Asia/Shanghai"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Shanghai"){echo "  selected=\"selected\"";}?>>北京时间</option>
              <option value="Asia/Hong-Kong"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Hong-Kong"){echo "  selected=\"selected\"";}?>>香港时间</option>
              <option value="Asia/Taipei"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Taipei"){echo "  selected=\"selected\"";}?>>台北时间</option>
              <option value="Asia/Singapore"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Singapore"){echo "  selected=\"selected\"";}?>>新加坡时间</option>
              <option value="Asia/Seoul"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Seoul"){echo "  selected=\"selected\"";}?>>韩国首尔时间</option>
              <option value="Asia/Tokyo"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Asia/Tokyo"){echo "  selected=\"selected\"";}?>>日本东京时间</option>
              <option value="America/New_York"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="America/New_York"){echo "  selected=\"selected\"";}?>>美国纽约时间</option>
              <option value="Europe/Paris"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/Paris"){echo "  selected=\"selected\"";}?>>法国巴黎时间</option>
              <option value="Europe/Berlin"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/Berlin"){echo "  selected=\"selected\"";}?>>德国柏林时间</option>
              <option value="Europe/Moscow"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/Moscow"){echo "  selected=\"selected\"";}?>>俄罗斯莫斯科时间</option>
              <option value="Europe/Rome"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/Rome"){echo "  selected=\"selected\"";}?>>意大利罗马时间</option>
              <option value="Europe/Madrid"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/Madrid"){echo "  selected=\"selected\"";}?>>西班牙马德里时间</option>
              <option value="Europe/London"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Europe/London"){echo "  selected=\"selected\"";}?>>英国伦敦时间</option>
              <option value="GMT"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="GMT"){echo "  selected=\"selected\"";}?>>英国格林威治时间</option>
              <option value="Africa/Cairo"<?php if(WEB_DATE_DEFAULT_TIMEZONE=="Africa/Cairo"){echo "  selected=\"selected\"";}?>>埃及开罗时间</option> 
			  */?>
            </td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#F3F8FF" class="bgcolor4">&nbsp;</td>
            <td bgcolor="#F3F8FF" class="bgcolor1"> </td>
          </tr>
          <tr>
            <td height="43" align="center" bgcolor="#F3F8FF" class="bgcolor4">&nbsp;</td>
            <td bgcolor="#F3F8FF" class="bgcolor1">
			
		  <input name="Submit" type="submit" class="button" value=" 提 交 " >
                <input name="Submit" type="reset" class="button" value=" 重 置 " title=" 单击重置表单！ ">
                <input name="reload" type="button" class="button" id="reload"  title=" 单击刷新当前页面！ " onClick="window.location.reload()" value=" 刷 新 ">
				&nbsp;&nbsp;<img src="Images/help.gif" width="16" height="16" onMouseOver="toolTip('如使用中遇到任何问题，请联系我：<br>QQ 363685855，微博：https://gitee.com/caozha', '#4A4A4A', '#F6F6F6')" onMouseOut="toolTip()">
            <input name="action2" type="hidden" id="action2" value="saveconfig"></td>
          </tr>
      </table></td>
    </tr>
  </table>

</form>

<?php
require_once 'application/admin_footer.php';		//调用脚部

mysql_close($conn);
?>
<div id="toolTipLayer" style="width:500px;position:absolute;visibility:hidden; font-size:14px;"></div>
<script>initToolTips()</script>
</body>
</html>
