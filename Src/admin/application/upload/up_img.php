<?php
!defined('IN_CMS') && exit('Access Denied');
//上传配置
    $config = array(
        "uploadPath"=>"../5300/upload/img/",                          //保存路径
        "fileType"=>array(".gif",".png",".jpg",".jpeg",".bmp"),   //文件允许格式
        "fileSize"=>2024                                          //文件大小限制，单位KB
    );

$input_name=$_GET["input_name"];
pl_session_open();//启用session
Check_Admin();//检查权限
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件</title>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <form action="admin.php?action=upload_img&input_name=<?=$input_name?>" method="post" enctype="multipart/form-data">
  <tr>  
    <td width="10">&nbsp;</td>
    <td height="30"><br>
      选择图片文件：
<input type="file" name="up_picture"/>
      <input type="submit" name="button" id="button" value=" 上传 " /></td>
  </tr>
    </form>
  <tr>  
    <td width="10">&nbsp;</td>
    <td height="70">
<?php
if(!empty($_FILES[up_picture][name])){		//判断上传内容是否为空
	if($_FILES['up_picture']['error']>0){		//判断文件是否可以上传到服务器
		echo "上传错误:";
		switch($_FILES['up_picture']['error']){
			case 1:
				echo "上传文件大小超出配置文件规定值";
			break;
			case 2:
				echo "上传文件大小超出表单中约定值";
			break;
			case 3:
				echo "上传文件不全";
			break;
			case 4:
				echo "没有上传文件";
			break;	
		}
	}else{
		$state=true;//初始化上传状态
        $path_dir  = $config['uploadPath'].date("Ym",time())."/";    //保存路径
		if(!is_dir("$path_dir")){				//判断指定目录是否存在
			mkdir("$path_dir",0777);					//创建目录
		}
		   //格式验证
		  $current_type = strtolower(strrchr($_FILES['up_picture']['name'], '.')); //获取上传格式
		  if(!in_array($current_type, $config['fileType'])){
			  $state = false;
			  $error_alert_current_type=implode(",",$config['fileType']);//将数组转换为字符
			  $error_alert_text=$error_alert_text."*上传文件的格式不合法，正确的后缀格式为：".$error_alert_current_type."。<br>";
           }
		   //大小验证
           $file_size = 1024 * $config['fileSize'];
           if( $_FILES['up_picture']['size'] > $file_size ){
              $state = false;
			  $error_alert_text=$error_alert_text."*上传文件的大小超出限制，最大允许：".$config['fileSize']."KB。<br>";
           }
		$up_file_name=date('Ymd_His',time())."_".rand (1,99999).$current_type; //定义上传文件名称
		$path=$path_dir.$up_file_name;		//定义上传文件名称和存储位置
		if(is_uploaded_file($_FILES['up_picture']['tmp_name']) && $state==true){	//判断文件是否是HTPP POST上传
			if(!move_uploaded_file($_FILES['up_picture']['tmp_name'],$path)){	//执行上传操作
				echo "<font color='red'>上传失败。</font>";
			}else{
				if(WEB_ISWATERMARK!=0){
					require_once("../system/libs/image.inc.php");//载入图片处理类，为图片添加水印
				    $WaterMark = new image();//类的实例化
				    $WaterMark->watermark($path);	//执行添加方法
					}
				 
				//echo "文件/".str_replace("../","",$path)."上传成功，大小为：".$_FILES['up_picture']['size']."字节。";	
				echo "<script language=\"javascript\">opener.document.getElementById('$input_name').value='"."/".str_replace("../","",$path)."';window.self.close();</script>";
				//以上当用于window.open时使用，以下为window.showModalDialog使用
				//echo "<script language=\"javascript\">var parentWin=window.dialogArguments;parentWin.document.getElementById('$input_name').value='"."/".str_replace("../","",$path)."';window.self.close();<\/script>";
			}
		}else{
			echo "<font color='red' size='+1'>上传文件失败！</font>原因：<br>".$error_alert_text;
		}
	}
}
?>
</td>
  </tr>
</table>
<script language="javascript">//两种调用方式
       function upload_file(input_name,wwidth,wheight){
			var A=window.open("admin.php?action=upload_img&input_name="+input_name,"up_input_name","width="+wwidth+",height="+wheight+",menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
		}
		
	   function upload_file_showModalDialog(input_name,wwidth,wheight) {
  var x=(screen.Width-wwidth)/2;
  var y=(screen.Height-wheight)/2;
  window.showModalDialog("admin.php?action=upload_img&input_name="+input_name,"up_input_name",'dialogWidth:'+wwidth+'px;dialogHeight:'+wheight+'px;dialogLeft:'+x+'px;dialogTop:'+y+'px;center:yes;help:no;resizable:yes;status:no;scroll:yes');
}
                              </script>
</body>
</html>