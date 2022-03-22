<?php
/**
 * ====================================================================================
 * 基础类库
 * $Author: 邓草   http://caozha.com
 * GitHub：https://github.com/cao-zha
 * Gitee： https://gitee.com/caozha
 * 基于木兰宽松许可证 2.0（Mulan PSL v2）免费开源，您可以自由复制、修改、分发或用于商业用途，但需保留作者版权等声明。详见开源协议：http://license.coscl.org.cn/MulanPSL2
 * old-cms (Software Name) is licensed under Mulan PSL v2. Please refer to: http://license.coscl.org.cn/MulanPSL2
 * ====================================================================================
**/

class base{
	var $category_html_str;//定义获取分类列表变量
	var $product_list_html_str;//定义获取产品列表变量
	var $article_list_html_str;//定义获取文章列表变量
	var $feedback_list_html_str;
	var $hr_list_html_str;
	
	public static function load_webconfig(){//加载网站基本配置，并返回数组
		$webconfig_arr=array(
		"name"=>WEB_NAME,
		"url"=>WEB_URL,
		"dir"=>WEB_DIR,
		"logo"=>WEB_LOGO,
		"banner"=>WEB_BANNER,
		"seotitle"=>WEB_SEOTITLE,
		"index_seotitle"=>WEB_SEOTITLE_INDEX,
		"index_seokeywords"=>WEB_SEOKEYWORDS_INDEX,
		"index_seodescription"=>WEB_SEODESCRIPTION_INDEX,
		"is_service_online"=>WEB_ISSERVICE,
		"template_path_root"=>WEB_DIR."templates/",//模板根目录
		"template_path"=>WEB_DIR."templates/".Template_FOLDER."/", //默认模板目录
		"template_folder"=>Template_FOLDER, //默认模板文件夹
		"css_path"=>WEB_DIR."templates/".Template_FOLDER."/css/", //默认CSS目录
		"images_path"=>WEB_DIR."templates/".Template_FOLDER."/images/" //默认图片目录
		);
		return $webconfig_arr;
	}
	
	public static function mysql(){//实例化 连接数据库类
		return new mysql();
		}
		
	public function get_label($lbid=""){//获取标签，并且返回以字段值lbmarker为索引的数组,当$lbid为空返回全部标签
		$label_arr=array();
		if(is_num($lbid)){
		        $sql="select * from ".DB_PRE."label where lbid=".intval($lbid);
		        $sql_label=self::mysql()->query($sql);//查询数据库
		        if(@$label_arr=mysql_fetch_array($sql_label)){
					return $label_arr;
					}
		}else{
				$sql="select * from ".DB_PRE."label order by orderid desc,lbid";
				$sql_label=self::mysql()->query($sql);//查询数据库
				while($myrow=mysql_fetch_array($sql_label)){
					   $label_arr[$myrow['lbmarker']]=$myrow['lbcontent'];//向数组添加数据
					   //array_push($label_arr,array($myrow['lbmarker']=>$myrow['lbcontent']));//向二维数组添加数据
					}
				return $label_arr;
		}
	}
	
	public function getClassName($classid){//获取某分类名称
	if (!$classid){
	return "";
	}else{
		$get_classname=@mysql_fetch_array(self::mysql()->query("select classname from ".DB_PRE."class where classid=$classid LIMIT 0,1"));
		if($get_classname){
			return $get_classname["classname"];
		}else{
			return "";
			}
	}
	}
	
	public function get_category($parentid="",$layer="",$visible=0,$htmlstr="",$none_callback="",$num="",$depth=""){//获取类别，$parentid父分类，$layer层次（从1开始），$visible是否显示隐藏分类，$htmlstr显示模板，$num获取数量
	    if($htmlstr==""){return false;}
		$sql="select A.*, ( select count(B.classid) from ".DB_PRE."class as B where A.classid = B.parentid) as countlist from ".DB_PRE."class as A where A.classid>0 ";
		if(is_num($parentid)){
		    $sql.="and parentid=".intval($parentid);				
		}else{
			$sql.="and parentid=0 ";
		}
		        //获取分类的深度
		        if(!is_num($depth)){
				    if ($parentid==0){
					$depth=$layer;
					}else{
				        $get_depth=@mysql_fetch_array(self::mysql()->query("select depth from ".DB_PRE."class where classid=$parentid LIMIT 0,1"));
				        if($get_depth){
					    $depth=$layer+$get_depth["depth"];
					    }else{
						$depth=$layer;
						}
					}
				}
		if(is_num($depth)){			
				$sql.=" and depth<=".$depth;
		}
		if(is_num($visible)){
				$sql.=" and visible=$visible ";
		}
		$sql.=" order by A.orderby desc,A.classid";
		if(is_num($num) && $num>0){			
				$sql.=" LIMIT 0,$num";
		}
		$sql_category=self::mysql()->query($sql);//查询数据库
		$get_my_num_rows=mysql_num_rows($sql_category);//获取总数
		if($get_my_num_rows<1){//当没有数据时，返回信息
		  return $none_callback;
		  }
				while($myrow=mysql_fetch_array($sql_category)){
					   $htmlstr_temp=str_ireplace("<classid>",$myrow['classid'],$htmlstr);
					   $htmlstr_temp=str_ireplace("<classname>",$myrow['classname'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<imgurl>",$myrow['imgurl'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<parentid>",$myrow['parentid'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<depth>",$myrow['depth'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<orderby>",$myrow['orderby'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<count>",$myrow['countlist'],$htmlstr_temp);
					   $this->category_html_str.=$htmlstr_temp;
					   self::get_category($myrow['classid'],$layer,$visible,$htmlstr,$none_callback,$num,$depth);
					}
		return $this->category_html_str;
	}
	
	
	public function get_category_level($parentid="",$layer="",$visible=0,$htmlstr="",$none_callback="",$num="",$depth=""){//获取类别，$parentid父分类，$layer层次（从1开始），$visible是否显示隐藏分类，$htmlstr显示模板，$num获取数量
	    if($htmlstr==""){return false;}
		$sql="select A.*, ( select count(B.classid) from ".DB_PRE."class as B where A.classid = B.parentid) as countlist from ".DB_PRE."class as A where A.classid>0 ";
		if(is_num($parentid)){
		    $sql.="and parentid=".intval($parentid);				
		}else{
			$sql.="and parentid=0 ";
		}
		        //获取分类的深度
		        if(!is_num($depth)){
				    if ($parentid==0){
					$depth=$layer;
					}else{
				        $get_depth=@mysql_fetch_array(self::mysql()->query("select depth from ".DB_PRE."class where classid=$parentid LIMIT 0,1"));
				        if($get_depth){
					    $depth=$layer+$get_depth["depth"];
					    }else{
						$depth=$layer;
						}
					}
				}
		if(is_num($depth)){			
				$sql.=" and depth<=".$depth;
		}
		if(is_num($visible)){			
				$sql.=" and visible=$visible ";
		}
		$sql.=" order by A.orderby desc,A.classid";
		if(is_num($num) && $num>0){			
				$sql.=" LIMIT 0,$num";
		}
		$sql_category=self::mysql()->query($sql);//查询数据库
		$get_my_num_rows=mysql_num_rows($sql_category);//获取总数
		if($get_my_num_rows<1){//当没有数据时，返回信息
		  return $none_callback;
		  }
				while($myrow=mysql_fetch_array($sql_category)){					   
					   $htmlstr_temp=str_ireplace("<classid>",$myrow['classid'],$htmlstr);
					   $htmlstr_temp=str_ireplace("<classname>",$myrow['classname'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<imgurl>",$myrow['imgurl'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<parentid>",$myrow['parentid'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<depth>",$myrow['depth'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<orderby>",$myrow['orderby'],$htmlstr_temp);
					   $htmlstr_temp=str_ireplace("<count>",$myrow['countlist'],$htmlstr_temp);	
					   
					   $this_level=($myrow['depth']+$layer-$depth);//获取当前层，从1开始算起
					   $htmlstr_top=strip_str_content($htmlstr_temp, "<level_".$this_level."_top>", "</level_".$this_level."_top>");//获取模板TOP
					   $htmlstr_bottom=strip_str_content($htmlstr_temp, "<level_".$this_level."_bottom>", "</level_".$this_level."_bottom>");//获取模板Bottom
					   $this->category_html_str.=$htmlstr_top;
					   self::get_category_level($myrow['classid'],$layer,$visible,$htmlstr,$none_callback,$num,$depth);
					   $this->category_html_str.=$htmlstr_bottom;
					   
					}
		return $this->category_html_str;
	}
	
	public function get_product_list($classid="",$tuijian=0,$shenhe=1,$is_proimg=false,$htmlstr="",$none_callback="",$num=20,$orderby="",$is_childclass=true,$page_style=4,$page_str="",$sql_like="",$keyword=""){//获取产品列表，$classid分类，多个分类ID用,分隔，$tuijian是否推荐，$shenhe是否审核，$is_proimg是否带缩略图，$htmlstr显示模板，$none_callback当为空时返回的字符串，$num每页数量，$orderby排序方式，$is_childclass是否包含子分类产品，$page_style分页样式，$page_str分页HTML格式为空则不输出分页，$sql_like模糊查询（设置则查询包含字符的产品），$keyword关键词
	if($htmlstr==""){return false;}
	$field_arr=self::mysql()->fetch_field("select * from ".DB_PRE."product LIMIT 0,1");//获取产品表里的字段数组
	
	$sql="select * from ".DB_PRE."product where proid>0";
	
	$sql_like=safe_html(strip_tags($sql_like));
	$keyword=safe_html(strip_tags($keyword));
	if ($sql_like!="" && $keyword!=""){	
	    if (!is_utf8($keyword)){
			$keyword=iconv("gbk","utf-8",$keyword);//转换为UTF-8
			}		
		$sql_like_arr=explode(",",$sql_like);
		foreach($sql_like_arr as $key=>$value){
			if ($key==0){
				  $sql.=" and ($value like '%".$keyword."%' ";
				}else{
	              $sql.=" or $value like '%".$keyword."%' ";
				}
			if ($key==(count($sql_like_arr)-1)){$sql.=") ";}
		}
	}
	
	$classid=safe_html($classid);//过滤非法字符
	if ($classid!=""){
		if($is_childclass=true){
			$childid_arr=$classid;
			$sql_childid=self::mysql()->query("select childid from ".DB_PRE."class where classid in(".$classid.") ");//查询数据库
				while($myrow=mysql_fetch_array($sql_childid)){
					if($myrow["childid"]!="" && $myrow["childid"]!=NULL){
					  $childid_arr.=",".$myrow["childid"];
						}
					}	
		    $sql.=" and classid in(".$childid_arr.") ";
		}else{
			$sql.=" and classid in(".$classid.") ";
			}
	}
	
	if (is_num($shenhe)){
		$sql.=" and shenhe = ".$shenhe." ";
	}
	if (is_num($tuijian)){
		$sql.=" and tuijian = ".$tuijian." ";
	}
	if ($is_proimg==true && $is_proimg!=""){
		$sql.=" and proimg1<>'' ";
	}
	if(strip_tags($orderby)!=""){//前台可选值：orderid desc,updatetime desc,proid desc
		$sql.=" order by ".safe_html($orderby)." ";
	}else{
		$sql.=" order by orderid desc,updatetime desc,proid desc ";
	}
	if (!is_numeric($num)){
		$num=20;//默认显示20个
	}
	if (!is_numeric($page_style)){
		$page_style=4;//默认显示第四种样式
	}
$pl_SQL_result=self::mysql()->query(str_ireplace("*"," count(*) as total ",$sql));//查询数据库
$all_mysql_num_rows=mysql_result($pl_SQL_result,0,'total'); //变量表示查询出结果的数量

require_once(LIBS_PATH."page.inc.php");//加载分页类库
$options = array(
	'total_rows' => $all_mysql_num_rows,//总行数
	'list_rows'  => $num,  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=self::mysql()->query($sql." limit $page->first_row , $page->list_rows");//执行查询

$get_my_num_rows=mysql_num_rows($sql_query);//获取总数
if($get_my_num_rows<1){//当没有数据时，返回信息
	return $none_callback;
	}

while($info=mysql_fetch_array($sql_query)){
    /* if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}*/
	
	$htmlstr_temp=str_ireplace("<i>",$i,$htmlstr);
	$htmlstr_temp=str_ireplace("<count>",$get_my_num_rows,$htmlstr_temp);
	$htmlstr_temp=str_ireplace("<classname>",self::getClassName($info['classid']),$htmlstr_temp);
	foreach($field_arr as $key=>$value){//循环替换字段和值
		$htmlstr_temp=str_ireplace("<".$value.">",$info[$value],$htmlstr_temp);
		}
		
	//构造truncate函数
	$truncate_count=count(explode("<truncate(",$htmlstr_temp))-1;//获取truncate标签出现次数
	for ($i=1;$i<=$truncate_count;$i++){
		$truncate_str=strip_str_content($htmlstr_temp, "<truncate(", ")>");//截取字符串
		$truncate_arr=explode(",",$truncate_str);
		if(count($truncate_arr)==3){
			$truncate_length=$truncate_arr[1];//截取字符串长度
			if(mb_strlen($truncate_arr[0])>$truncate_length){
				$truncate_str_tmp=mb_substr($truncate_arr[0],0,$truncate_length).$truncate_arr[2];//截取字符串
				}else{
					$truncate_str_tmp=$truncate_arr[0];
					}
				$htmlstr_temp=str_ireplace("<truncate(".$truncate_str.")>",$truncate_str_tmp,$htmlstr_temp);//替换标签函数
		    }			
		}
		
	//构造dateformat时间格式化函数
	$dateformat_count=count(explode("<dateformat(",$htmlstr_temp))-1;//获取dateformat标签出现次数
	for ($i=1;$i<=$dateformat_count;$i++){
		$dateformat_str=strip_str_content($htmlstr_temp, "<dateformat(", ")>");//截取字符串
		$dateformat_arr=explode(",",$dateformat_str);
		if(count($dateformat_arr)==2){
			if(is__date($dateformat_arr[0])){
				$dateformat_str_tmp=date($dateformat_arr[1],strtotime($dateformat_arr[0]));//转换时间格式
				}else{
					$dateformat_str_tmp=$dateformat_arr[0];
					}
				$htmlstr_temp=str_ireplace("<dateformat(".$dateformat_str.")>",$dateformat_str_tmp,$htmlstr_temp);//替换标签函数
			}
		}
		
	$this->product_list_html_str.=$htmlstr_temp;
				
}
   if($page_str!=""){//输出分页代码
      $product_list_pagestr = $page->show($page_style); //打印样式,1,2,3,4
	  $this->product_list_html_str.=str_ireplace("<page>",$product_list_pagestr,$page_str);
   }
	unset($page);//销毁类实例
	return $this->product_list_html_str;
 }
 
 
 public function get_article_list($classid="",$tuijian=0,$shenhe=1,$is_artimg=false,$htmlstr="",$none_callback="",$num=20,$orderby="",$is_childclass=true,$page_style=4,$page_str="",$sql_like="",$keyword=""){//获取文章列表，$classid分类，多个分类ID用,分隔，$tuijian是否推荐，$shenhe是否审核，$is_artimg是否带缩略图，$htmlstr显示模板，$none_callback当为空时返回的字符串，$num每页数量，$orderby排序方式，$is_childclass是否包含子分类的信息，$page_style分页样式，$page_str分页HTML格式为空则不输出分页，$sql_like模糊查询（设置则查询包含字符的信息），$keyword关键词
	if($htmlstr==""){return false;}
	
	$field_arr=self::mysql()->fetch_field("select * from ".DB_PRE."article LIMIT 0,1");//获取文章表里的字段数组
	
	$sql="select * from ".DB_PRE."article where artid>0";
	
	$sql_like=safe_html(strip_tags($sql_like));
	$keyword=safe_html(strip_tags($keyword));
	if ($sql_like!="" && $keyword!=""){	
	    if (!is_utf8($keyword)){
			$keyword=iconv("gbk","utf-8",$keyword);//转换为UTF-8
			}		
		$sql_like_arr=explode(",",$sql_like);
		foreach($sql_like_arr as $key=>$value){
			if ($key==0){
				  $sql.=" and ($value like '%".$keyword."%' ";
				}else{
	              $sql.=" or $value like '%".$keyword."%' ";
				}
			if ($key==(count($sql_like_arr)-1)){$sql.=") ";}
		}
	}
	
	$classid=safe_html($classid);//过滤非法字符
	if ($classid!=""){
		if($is_childclass=true){
			$childid_arr=$classid;
			$sql_childid=self::mysql()->query("select childid from ".DB_PRE."class where classid in(".$classid.") ");//查询数据库
				while($myrow=mysql_fetch_array($sql_childid)){
					if($myrow["childid"]!="" && $myrow["childid"]!=NULL){
					  $childid_arr.=",".$myrow["childid"];
						}
					}	
		    $sql.=" and classid in(".$childid_arr.") ";
		}else{
			$sql.=" and classid in(".$classid.") ";
			}
	}
	
	if (is_num($shenhe)){
		$sql.=" and shenhe = ".$shenhe." ";
	}
	if (is_num($tuijian)){
		$sql.=" and tuijian = ".$tuijian." ";
	}
	if ($is_artimg==true && $is_artimg!=""){
		$sql.=" and artimg<>'' ";
	}
	if(strip_tags($orderby)!=""){//前台可选值：orderid desc,updatetime desc,proid desc
		$sql.=" order by ".safe_html($orderby)." ";
	}else{
		$sql.=" order by orderid desc,updatetime desc,artid desc ";
	}
	if (!is_numeric($num)){
		$num=20;//默认显示20个
	}
	if (!is_numeric($page_style)){
		$page_style=4;//默认显示第四种样式
	}
$pl_SQL_result=self::mysql()->query(str_ireplace("*"," count(*) as total ",$sql));//查询数据库
$all_mysql_num_rows=mysql_result($pl_SQL_result,0,'total'); //变量表示查询出结果的数量

require_once(LIBS_PATH."page.inc.php");//加载分页类库
$options = array(
	'total_rows' => $all_mysql_num_rows,//总行数
	'list_rows'  => $num,  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=self::mysql()->query($sql." limit $page->first_row , $page->list_rows");//执行查询

$get_my_num_rows=mysql_num_rows($sql_query);//获取总数
if($get_my_num_rows<1){//当没有数据时，返回信息
	return $none_callback;
	}

while($info=mysql_fetch_array($sql_query)){
    /* if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}*/
	
	$htmlstr_temp=str_ireplace("<i>",$i,$htmlstr);
	$htmlstr_temp=str_ireplace("<count>",$get_my_num_rows,$htmlstr_temp);
	$htmlstr_temp=str_ireplace("<classname>",self::getClassName($info['classid']),$htmlstr_temp);	
	foreach($field_arr as $key=>$value){//循环替换字段和值
		$htmlstr_temp=str_ireplace("<".$value.">",$info[$value],$htmlstr_temp);
		}
		
	//构造truncate函数
	$truncate_count=count(explode("<truncate(",$htmlstr_temp))-1;//获取truncate标签出现次数
	for ($i=1;$i<=$truncate_count;$i++){
		$truncate_str=strip_str_content($htmlstr_temp, "<truncate(", ")>");//截取字符串
		$truncate_arr=explode(",",$truncate_str);
		if(count($truncate_arr)==3){
			$truncate_length=$truncate_arr[1];//截取字符串长度
			if(mb_strlen($truncate_arr[0])>$truncate_length){
				$truncate_str_tmp=mb_substr($truncate_arr[0],0,$truncate_length).$truncate_arr[2];//截取字符串
				}else{
					$truncate_str_tmp=$truncate_arr[0];
					}
				$htmlstr_temp=str_ireplace("<truncate(".$truncate_str.")>",$truncate_str_tmp,$htmlstr_temp);//替换标签函数
		    }			
		}
		
	//构造dateformat时间格式化函数
	$dateformat_count=count(explode("<dateformat(",$htmlstr_temp))-1;//获取dateformat标签出现次数
	for ($i=1;$i<=$dateformat_count;$i++){
		$dateformat_str=strip_str_content($htmlstr_temp, "<dateformat(", ")>");//截取字符串
		$dateformat_arr=explode(",",$dateformat_str);
		if(count($dateformat_arr)==2){
			if(is__date($dateformat_arr[0])){
				$dateformat_str_tmp=date($dateformat_arr[1],strtotime($dateformat_arr[0]));//转换时间格式
				}else{
					$dateformat_str_tmp=$dateformat_arr[0];
					}
				$htmlstr_temp=str_ireplace("<dateformat(".$dateformat_str.")>",$dateformat_str_tmp,$htmlstr_temp);//替换标签函数
			}
		}
		
		
	$this->article_list_html_str.=$htmlstr_temp;
				
}
   if($page_str!=""){//输出分页代码
      $article_list_pagestr = $page->show($page_style); //打印样式,1,2,3,4
	  $this->article_list_html_str.=str_ireplace("<page>",$article_list_pagestr,$page_str);
   }
	unset($page);//销毁类实例
	return $this->article_list_html_str;
 }
 
   
   public function get_feedback_list($classid="",$tuijian=0,$shenhe=1,$is_reply="",$htmlstr="",$none_callback="",$num=20,$orderby="",$is_childclass=true,$page_style=4,$page_str="",$sql_like="",$keyword=""){//获取留言反馈列表，$classid分类，多个分类ID用,分隔，$tuijian是否推荐，$shenhe是否审核，$is_reply是否已经回复,true or false，$htmlstr显示模板，$none_callback当为空时返回的字符串，$num每页数量，$orderby排序方式，$is_childclass是否包含子分类的信息，$page_style分页样式，$page_str分页HTML格式为空则不输出分页，$sql_like模糊查询（设置则查询包含字符的信息），$keyword关键词
	if($htmlstr==""){return false;}
	
	$field_arr=self::mysql()->fetch_field("select * from ".DB_PRE."feedback LIMIT 0,1");//获取文章表里的字段数组
	
	$sql="select * from ".DB_PRE."feedback where fbid>0";
	
	$sql_like=safe_html(strip_tags($sql_like));
	$keyword=safe_html(strip_tags($keyword));
	if ($sql_like!="" && $keyword!=""){	
	    if (!is_utf8($keyword)){
			$keyword=iconv("gbk","utf-8",$keyword);//转换为UTF-8
			}		
		$sql_like_arr=explode(",",$sql_like);
		foreach($sql_like_arr as $key=>$value){
			if ($key==0){
				  $sql.=" and ($value like '%".$keyword."%' ";
				}else{
	              $sql.=" or $value like '%".$keyword."%' ";
				}
			if ($key==(count($sql_like_arr)-1)){$sql.=") ";}
		}
	}
	
	$classid=safe_html($classid);//过滤非法字符
	if ($classid!=""){
		if($is_childclass=true){
			$childid_arr=$classid;
			$sql_childid=self::mysql()->query("select childid from ".DB_PRE."class where classid in(".$classid.") ");//查询数据库
				while($myrow=mysql_fetch_array($sql_childid)){
					if($myrow["childid"]!="" && $myrow["childid"]!=NULL){
					  $childid_arr.=",".$myrow["childid"];
						}
					}	
		    $sql.=" and classid in(".$childid_arr.") ";
		}else{
			$sql.=" and classid in(".$classid.") ";
			}
	}
	
	if (is_num($shenhe)){
		$sql.=" and shenhe = ".$shenhe." ";
	}
	if (is_num($tuijian)){
		$sql.=" and tuijian = ".$tuijian." ";
	}
	if ($is_reply==true && $is_reply!=""){
		$sql.=" and replycontent<>'' ";
	}
	if(strip_tags($orderby)!=""){//前台可选值：orderid desc,updatetime desc,proid desc
		$sql.=" order by ".safe_html($orderby)." ";
	}else{
		$sql.=" order by orderid desc,updatetime desc,fbid desc ";
	}
	if (!is_numeric($num)){
		$num=20;//默认显示20个
	}
	if (!is_numeric($page_style)){
		$page_style=4;//默认显示第四种样式
	}
$pl_SQL_result=self::mysql()->query(str_ireplace("*"," count(*) as total ",$sql));//查询数据库
$all_mysql_num_rows=mysql_result($pl_SQL_result,0,'total'); //变量表示查询出结果的数量

require_once(LIBS_PATH."page.inc.php");//加载分页类库
$options = array(
	'total_rows' => $all_mysql_num_rows,//总行数
	'list_rows'  => $num,  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=self::mysql()->query($sql." limit $page->first_row , $page->list_rows");//执行查询

$get_my_num_rows=mysql_num_rows($sql_query);//获取总数
if($get_my_num_rows<1){//当没有数据时，返回信息
	return $none_callback;
	}

while($info=mysql_fetch_array($sql_query)){
    /* if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}*/
	$iii+=1;
	$htmlstr_temp=str_ireplace("<i>",$iii,$htmlstr);
	$htmlstr_temp=str_ireplace("<count>",$get_my_num_rows,$htmlstr_temp);
	$htmlstr_temp=str_ireplace("<classname>",self::getClassName($info['classid']),$htmlstr_temp);	
	foreach($field_arr as $key=>$value){//循环替换字段和值
		$htmlstr_temp=str_ireplace("<".$value.">",$info[$value],$htmlstr_temp);
		}
		
	//构造truncate函数
	$truncate_count=count(explode("<truncate(",$htmlstr_temp))-1;//获取truncate标签出现次数
	for ($i=1;$i<=$truncate_count;$i++){
		$truncate_str=strip_str_content($htmlstr_temp, "<truncate(", ")>");//截取字符串
		$truncate_arr=explode(",",$truncate_str);
		if(count($truncate_arr)==3){
			$truncate_length=$truncate_arr[1];//截取字符串长度
			if(mb_strlen($truncate_arr[0])>$truncate_length){
				$truncate_str_tmp=mb_substr($truncate_arr[0],0,$truncate_length).$truncate_arr[2];//截取字符串
				}else{
					$truncate_str_tmp=$truncate_arr[0];
					}
				$htmlstr_temp=str_ireplace("<truncate(".$truncate_str.")>",$truncate_str_tmp,$htmlstr_temp);//替换标签函数
		    }			
		}
		
	//构造dateformat时间格式化函数
	$dateformat_count=count(explode("<dateformat(",$htmlstr_temp))-1;//获取dateformat标签出现次数
	for ($i=1;$i<=$dateformat_count;$i++){
		$dateformat_str=strip_str_content($htmlstr_temp, "<dateformat(", ")>");//截取字符串
		$dateformat_arr=explode(",",$dateformat_str);
		if(count($dateformat_arr)==2){
			if(is__date($dateformat_arr[0])){
				$dateformat_str_tmp=date($dateformat_arr[1],strtotime($dateformat_arr[0]));//转换时间格式
				}else{
					$dateformat_str_tmp=$dateformat_arr[0];
					}
				$htmlstr_temp=str_ireplace("<dateformat(".$dateformat_str.")>",$dateformat_str_tmp,$htmlstr_temp);//替换标签函数
			}
		}
		
		
	$this->feedback_list_html_str.=$htmlstr_temp;
				
}
   if($page_str!=""){//输出分页代码
      $feedback_list_pagestr = $page->show($page_style); //打印样式,1,2,3,4
	  $this->feedback_list_html_str.=str_ireplace("<page>",$feedback_list_pagestr,$page_str);
   }
	unset($page);//销毁类实例
	return $this->feedback_list_html_str;
 }
 
 
 
    public function get_hr_list($classid="",$tuijian=0,$shenhe=1,$is_useful_life="",$htmlstr="",$none_callback="",$num=20,$orderby="",$is_childclass=true,$page_style=4,$page_str="",$sql_like="",$keyword=""){//获取人才招聘列表，$classid分类，多个分类ID用,分隔，$tuijian是否推荐，$shenhe是否审核，$is_useful_life是否有效期内,true or false，$htmlstr显示模板，$none_callback当为空时返回的字符串，$num每页数量，$orderby排序方式，$is_childclass是否包含子分类信息，$page_style分页样式，$page_str分页HTML格式为空则不输出分页，$sql_like模糊查询（设置则查询包含字符的产品），$keyword关键词
	if($htmlstr==""){return false;}
	
	$field_arr=self::mysql()->fetch_field("select * from ".DB_PRE."hr LIMIT 0,1");//获取文章表里的字段数组
	
	$sql="select * from ".DB_PRE."hr where hrid>0";
	
	$sql_like=safe_html(strip_tags($sql_like));
	$keyword=safe_html(strip_tags($keyword));
	if ($sql_like!="" && $keyword!=""){	
	    if (!is_utf8($keyword)){
			$keyword=iconv("gbk","utf-8",$keyword);//转换为UTF-8
			}		
		$sql_like_arr=explode(",",$sql_like);
		foreach($sql_like_arr as $key=>$value){
			if ($key==0){
				  $sql.=" and ($value like '%".$keyword."%' ";
				}else{
	              $sql.=" or $value like '%".$keyword."%' ";
				}
			if ($key==(count($sql_like_arr)-1)){$sql.=") ";}
		}
	}
	
	$classid=safe_html($classid);//过滤非法字符
	if ($classid!=""){
		if($is_childclass=true){
			$childid_arr=$classid;
			$sql_childid=self::mysql()->query("select childid from ".DB_PRE."class where classid in(".$classid.") ");//查询数据库
				while($myrow=mysql_fetch_array($sql_childid)){
					if($myrow["childid"]!="" && $myrow["childid"]!=NULL){
					  $childid_arr.=",".$myrow["childid"];
						}
					}	
		    $sql.=" and classid in(".$childid_arr.") ";
		}else{
			$sql.=" and classid in(".$classid.") ";
			}
	}
	
	if (is_num($shenhe)){
		$sql.=" and shenhe = ".$shenhe." ";
	}
	if (is_num($tuijian)){
		$sql.=" and tuijian = ".$tuijian." ";
	}
	if ($is_useful_life==true && $is_useful_life!=""){
		$sql.=" and hr_useful_life>='".date("Y-m-d",time())."' ";
	}
	if(strip_tags($orderby)!=""){//前台可选值：orderid desc,updatetime desc,proid desc
		$sql.=" order by ".safe_html($orderby)." ";
	}else{
		$sql.=" order by orderid desc,updatetime desc,hrid desc ";
	}
	if (!is_numeric($num)){
		$num=20;//默认显示20个
	}
	if (!is_numeric($page_style)){
		$page_style=4;//默认显示第四种样式
	}
$pl_SQL_result=self::mysql()->query(str_ireplace("*"," count(*) as total ",$sql));//查询数据库
$all_mysql_num_rows=mysql_result($pl_SQL_result,0,'total'); //变量表示查询出结果的数量

require_once(LIBS_PATH."page.inc.php");//加载分页类库
$options = array(
	'total_rows' => $all_mysql_num_rows,//总行数
	'list_rows'  => $num,  //每页显示量
);
/* 实例化 */
$page = new page($options);

$sql_query=self::mysql()->query($sql." limit $page->first_row , $page->list_rows");//执行查询

$get_my_num_rows=mysql_num_rows($sql_query);//获取总数
if($get_my_num_rows<1){//当没有数据时，返回信息
	return $none_callback;
	}

while($info=mysql_fetch_array($sql_query)){
    /* if ($i%2 == 0){
		$bgcolor ="#F1F9F5";
	}else{
		$bgcolor ="#FFFFFF";
	}*/
	$iii+=1;
	$htmlstr_temp=str_ireplace("<i>",$iii,$htmlstr);
	$htmlstr_temp=str_ireplace("<count>",$get_my_num_rows,$htmlstr_temp);
	$htmlstr_temp=str_ireplace("<classname>",self::getClassName($info['classid']),$htmlstr_temp);	
	foreach($field_arr as $key=>$value){//循环替换字段和值
		$htmlstr_temp=str_ireplace("<".$value.">",$info[$value],$htmlstr_temp);
		}
		
	//构造truncate函数
	$truncate_count=count(explode("<truncate(",$htmlstr_temp))-1;//获取truncate标签出现次数
	for ($i=1;$i<=$truncate_count;$i++){
		$truncate_str=strip_str_content($htmlstr_temp, "<truncate(", ")>");//截取字符串
		$truncate_arr=explode(",",$truncate_str);
		if(count($truncate_arr)==3){
			$truncate_length=$truncate_arr[1];//截取字符串长度
			if(mb_strlen($truncate_arr[0])>$truncate_length){
				$truncate_str_tmp=mb_substr($truncate_arr[0],0,$truncate_length).$truncate_arr[2];//截取字符串
				}else{
					$truncate_str_tmp=$truncate_arr[0];
					}
				$htmlstr_temp=str_ireplace("<truncate(".$truncate_str.")>",$truncate_str_tmp,$htmlstr_temp);//替换标签函数
		    }			
		}
		
	//构造dateformat时间格式化函数
	$dateformat_count=count(explode("<dateformat(",$htmlstr_temp))-1;//获取dateformat标签出现次数
	for ($i=1;$i<=$dateformat_count;$i++){
		$dateformat_str=strip_str_content($htmlstr_temp, "<dateformat(", ")>");//截取字符串
		$dateformat_arr=explode(",",$dateformat_str);
		if(count($dateformat_arr)==2){
			if(is__date($dateformat_arr[0])){
				$dateformat_str_tmp=date($dateformat_arr[1],strtotime($dateformat_arr[0]));//转换时间格式
				}else{
					$dateformat_str_tmp=$dateformat_arr[0];
					}
				$htmlstr_temp=str_ireplace("<dateformat(".$dateformat_str.")>",$dateformat_str_tmp,$htmlstr_temp);//替换标签函数
			}
		}
		
		
	$this->hr_list_html_str.=$htmlstr_temp;
				
}
   if($page_str!=""){//输出分页代码
      $hr_list_pagestr = $page->show($page_style); //打印样式,1,2,3,4
	  $this->hr_list_html_str.=str_ireplace("<page>",$hr_list_pagestr,$page_str);
   }
	unset($page);//销毁类实例
	return $this->hr_list_html_str;
 }
 

 
   
   
   
}