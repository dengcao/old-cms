<?php
    error_reporting( E_ERROR | E_WARNING );
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
        "uploadPath" => "../../5300/upload/img/" , //保存路径
        "fileType" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
        "fileSize" => WEB_UPLOAD_MAXSIZE //文件大小限制，单位KB
    );
    //原始文件名，表单名固定，不可配置
    $oriName = htmlspecialchars( $_POST[ 'fileName' ] , ENT_QUOTES );

    //上传图片框中的描述表单名称，
    $title = htmlspecialchars( $_POST[ 'pictitle' ] , ENT_QUOTES );

    //文件句柄
    $file = $_FILES[ "upfile" ];

    //文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
    $state = "SUCCESS";

    //重命名后的文件名
    $fileName = "";

    //保存路径
    $path = $config[ 'uploadPath' ].date('Ym',time())."/";

    if ( !file_exists( $path ) ) {
        mkdir( "$path" , 0777 );
    }
    //格式验证
    $current_type = strtolower( strrchr( $file[ "name" ] , '.' ) );
    if ( !in_array( $current_type , $config[ 'fileType' ] ) || false == getimagesize( $file[ "tmp_name" ] ) ) {
        $state = "不允许的图片格式";
    }
    //大小验证
    $file_size = 1024 * $config[ 'fileSize' ];
    if ( $file[ "size" ] > $file_size ) {
        $state = "图片大小超出限制";
    }
    //保存图片
    if ( $state == "SUCCESS" ) {
        $tmp_file = $file[ "name" ];
        //$fileName = $path . rand( 1 , 10000 ) . time() . strrchr( $tmp_file , '.' );
		$fileName = $path.date('Ymd_His',time())."_".rand(1,99999).strrchr( $tmp_file , '.' );
		$fileName_2 = "/".str_ireplace("../","",$fileName);
        $result = move_uploaded_file( $file[ "tmp_name" ] , $fileName );
        if ( !$result ) {
            $state = "未知错误";
        }else{
			if(WEB_ISWATERMARK!=0){//为图片添加水印			        
					require_once("../../system/libs/image.inc.php");//载入图片处理类，为图片添加水印
				    $WaterMark = new image();//类的实例化
				    $WaterMark->watermark($fileName);	//执行添加水印方法
					}
			}
    }
    //向浏览器返回数据json数据
    /**
     * 返回数据格式
     * {
     *   'url'      :'a.jpg',   //保存后的文件路径
     *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
     *   'original' :'b.jpg',   //原始文件名
     *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
     * }
     */
    //echo "{'url':'" . $fileName_2 . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";
	echo "{'url':'" . $fileName_2 . "','title':'','original':'" . $oriName . "','state':'" . $state . "'}";

?>

