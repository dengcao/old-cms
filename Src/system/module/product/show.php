<?php
class product extends base{
	
	public function get_class_content($classid){//根据ID获取某分类的数据，成功则返回数组
	    $class_arr=array();
		if(is_num($classid)){
		$sql="select * from ".DB_PRE."class where parentid>0 and classid=".intval($classid);
		    }else{
				$sql="select * from ".DB_PRE."class where classid=1 order by orderby desc,classid LIMIT 0,1";
			}
		$sql_class=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		//while($myrow=mysql_fetch_array($sql_class)){
		//	$class_arr=array("id"=>$myrow['classid']);
		//	}
		if(@$class_arr=mysql_fetch_array($sql_class)){
			return $class_arr;
			}
		}
		
	public function get_product_content($proid){//根据ID获取产品的数据，成功则返回数组
	    $product_arr=array();
		if(is_num($proid)){
		  $sql="select * from ".DB_PRE."product where proid=".intval($proid);
		   }else{
			   return "";
			   }		
		$sql_product=parent::mysql()->query($sql);//从父类中调用query方法，查询数据库
		if(@$product_arr=mysql_fetch_array($sql_product)){			
			$update_hits=parent::mysql()->query("update ".DB_PRE."product set hits=".($product_arr['hits']+1)." where proid=$proid");//更新点击数
			return $product_arr;
			}
		}
	
	}



!defined('IN_CMS') && exit('Access Denied');

//接收参数
$proid=safe_replace(safe_html($_GET["id"]));
$product=new product();
$product_arr=$product->get_product_content($proid);
if(!is_num($product_arr["proid"])){Echo_ErrMsg("抱歉，该产品不存在。","javascript:window.close();");exit;}//判断是否审核
if($product_arr["shenhe"]!=1){Echo_ErrMsg("抱歉，该产品未通过审核，暂时不能查看。","javascript:window.close();");exit;}//判断是否审核
if($product_arr["seo_title"]==""){
	$product_arr["seo_title"]=$product_arr["proname"];
	}
assign("product",$product_arr);

$class_arr=$product->get_class_content($product_arr["classid"]);
if($class_arr["seo_title"]==""){
	$class_arr["seo_title"]=$class_arr["classname"];
	}
assign("class",$class_arr);

template("show","product","pro_show_".$proid."_".md5(array_to_string($_GET,$separator="_")));