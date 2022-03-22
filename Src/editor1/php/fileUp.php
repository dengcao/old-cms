<?php
/**
 * Created by JetBrains PhpStorm.
 * User: taoqili
 * Date: 12-2-8
 * Time: 下午1:20
 * To change this template use File | Settings | File Templates.
 */
error_reporting(E_ERROR|E_WARNING);
require_once("../../include/config.inc.php");//载入网站配置文件
	if(WEB_UPLOAD_FRONT==0){
			require_once("../../include/conn.php");//载入数据库配置文件
			//数据库连接
			global $conn;
			$mysql_conn=new mysql();
			$conn=$mysql_conn->ConnStr;
			require_once("../../system/libs/session.inc.php");
			if ($_SESSION["adminid"]=="" || $_SESSION["adminname"]==""){
				   $state="您没有上传的权限";
				   echo "{'url':'','title':'','original':'','state':'" . $state . "'}";
				   exit;
				}
		}


//上传配置
$config = array(
    "uploadPath" => "../../5300/upload/file/" , //保存路径
    "fileType" => array( ".rar" , ".doc" , ".docx" , ".zip" , ".pdf" , ".txt" , ".swf", ".wmv", ".gz", ".xls", ".xlsx", ".ppt", ".pptx", ".flv", ".rmvb", ".rm", '.mp3', '.wav', '.wma', '.mid', '.avi' ) , //文件允许格式
    "fileSize" => WEB_UPLOAD_MAXSIZE //文件大小限制，单位kb
);

//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜
$state = "SUCCESS";
$fileName = "";
$path = $config[ 'uploadPath' ].date('Ym',time())."/";
if ( !file_exists( $path ) ) {
    mkdir( "$path" , 0777 );
}
$clientFile = $_FILES[ "upfile" ];
if(!isset($clientFile)){
    echo "{'state':'文件大小超出服务器配置！','url':'null','fileType':'null'}";//请修改php.ini中的upload_max_filesize和post_max_size
    exit;
}

//格式验证
$current_type = strtolower( strrchr( $clientFile[ "name" ] , '.' ) );
if ( !in_array( $current_type , $config[ 'fileType' ] ) ) {
    $state = "不支持的文件类型！";
}
//大小验证
$file_size = 1024 * $config[ 'fileSize' ];
if ( $clientFile[ "size" ] > $file_size ) {
    $state = "文件大小超出限制！";
}
//保存文件
if ( $state == "SUCCESS" ) {
    $tmp_file = $clientFile[ "name" ];
    //$fileName = $path . rand( 1 , 10000 ) . time() . strrchr( $tmp_file , '.' );
	$fileName = $path.date('Ymd_His',time())."_".rand (1,99999).strrchr( $tmp_file , '.' );
	$fileName_2 = "/".str_ireplace("../","",$fileName);
    $result = move_uploaded_file( $clientFile[ "tmp_name" ] , $fileName );
    if ( !$result ) {
        $state = "文件保存失败！";
    }
}
//向浏览器返回数据json数据
echo '{"state":"' . $state . '","url":"' . $fileName_2 . '","fileType":"' . $current_type . '","original":"'.$clientFile["name"] .'"}';
?>

