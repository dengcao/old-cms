<?php
//图片处理类，包含加水印
class image{		//定义类文件
	var $w_pct = 100;
	var $w_quality = 80;
	var $w_minwidth = 300;
	var $w_minheight = 300;
	var $thumb_enable;  //是否缩略图，1为是，0为否
	var $watermark_enable; //是否水印，1为文字水印，2为图片水印，0为否
	var $interlace = 0;
	
	var $w_pos = 9;//水印位置
	var $w_img = "";//水印图片
	var $w_text = "";//水印文字
	var $w_font = 5;//水印文字大小
	var $w_color = "#ff0000";//水印文字颜色
	var $w_family = "";//水印字体
	
	var $thumb_maxwidth =200; //缩略图的大小
	var $thumb_maxheight =150;
	

    function __construct()
    {
		$this->thumb_enable = WEB_ISTHUMB;
		$this->watermark_enable = WEB_ISWATERMARK;
		$this->set(WEB_WATERMARK_MINWIDTH, WEB_WATERMARK_MINHEIGHT, WEB_WATERMARK_QUALITY, WEB_WATERMARK_PCT,WEB_WATERMARK_POS,WEB_WATERMARK_IMG,WEB_WATERMARK_TEXT,WEB_WATERMARK_TEXT_SIZE,WEB_WATERMARK_TEXT_COLOR,WEB_WATERMARK_TEXT_FAMILY,WEB_THUMB_WIDTH,WEB_THUMB_HEIGHT);
    }

	function image()
	{
		$this->__construct();
	}

	function set($w_minwidth = 300, $w_minheight = 300, $w_quality = 80, $w_pct = 100, $w_pos = 9, $w_img = "", $w_text = "", $w_font = 5, $w_color = "#ff0000", $w_family = "", $thumb_maxwidth =200, $thumb_maxheight =150)
	{
		$this->w_minwidth = $w_minwidth;
		$this->w_minheight = $w_minheight;
		$this->w_quality = $w_quality;
		$this->w_pct = $w_pct;
		$this->w_pos = $w_pos;
		$this->w_img = $w_img;
		$this->w_text = $w_text;
		$this->w_font = $w_font;
		$this->w_color = $w_color;
		$this->w_family = $w_family;
		$this->thumb_maxwidth = $thumb_maxwidth;
		$this->thumb_maxheight = $thumb_maxheight;
	}

    function info($img) 
	{
        $imageinfo = getimagesize($img);
        if($imageinfo === false) return false;
		$imagetype = strtolower(substr(image_type_to_extension($imageinfo[2]),1));
		$imagesize = filesize($img);
		$info = array(
				'width'=>$imageinfo[0],
				'height'=>$imageinfo[1],
				'type'=>$imagetype,
				'size'=>$imagesize,
				'mime'=>$imageinfo['mime']
				);
		return $info;
    }

    function thumb($image, $filename = '', $maxwidth = 0, $maxheight = 0, $suffix='_thumb', $autocut = 0) 
    {
		if(!$this->thumb_enable || !$this->check($image)) return false;
        $info  = image::info($image);
        if($info === false) return false;
		if($maxwidth == 0){$maxwidth = $this->thumb_maxwidth;}
		if($maxheight == 0){$maxheight = $this->thumb_maxheight;}
		$srcwidth  = $info['width'];
		$srcheight = $info['height'];
		$pathinfo = pathinfo($image);
		$type =  $pathinfo['extension'];
		if(!$type) $type = $info['type'];
		$type = strtolower($type);
		unset($info);
		
		$scale = min($maxwidth/$srcwidth, $maxheight/$srcheight);
		$createwidth = $width  = (int)($srcwidth*$scale);
		$createheight = $height = (int)($srcheight*$scale);
		if($maxwidth >= $srcwidth) $createwidth = $width = $srcwidth;
		if($maxheight >= $srcheight) $createheight = $height = $srcheight;
		$psrc_x = $psrc_y = 0;
		if($autocut)
		{
			if($maxwidth/$maxheight<$srcwidth/$srcheight && $maxheight>=$height)
			{
				$width = $maxheight/$height*$width;
				$height = $maxheight;
			}
			elseif($maxwidth/$maxheight>$srcwidth/$srcheight && $maxwidth>=$width)
			{
				$height = $maxwidth/$width*$height;
				$width = $maxwidth;
			}
			$createwidth = $maxwidth;
			$createheight = $maxheight;
		}
		$createfun = 'imagecreatefrom'.($type=='jpg' ? 'jpeg' : $type);
		$srcimg = $createfun($image);
		if($type != 'gif' && function_exists('imagecreatetruecolor'))
			$thumbimg = imagecreatetruecolor($createwidth, $createheight); 
		else
			$thumbimg = imagecreate($width, $height); 

		if(function_exists('imagecopyresampled'))
			imagecopyresampled($thumbimg, $srcimg, 0, 0, $psrc_x, $psrc_y, $width, $height, $srcwidth, $srcheight); 
		else
			imagecopyresized($thumbimg, $srcimg, 0, 0, $psrc_x, $psrc_y, $width, $height,  $srcwidth, $srcheight); 
		if($type=='gif' || $type=='png')
		{
			$background_color  =  imagecolorallocate($thumbimg,  0, 255, 0);  //  指派一个绿色  
			imagecolortransparent($thumbimg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图 
		}
		if($type=='jpg' || $type=='jpeg') imageinterlace($thumbimg, $this->interlace);
		$imagefun = 'image'.($type=='jpg' ? 'jpeg' : $type);
		if(empty($filename)) $filename  = substr($image, 0, strrpos($image, '.')).$suffix.'.'.$type;
		$imagefun($thumbimg, $filename);
		imagedestroy($thumbimg);
		imagedestroy($srcimg);
		return $filename;
    }

	function watermark($source, $target = '', $w_pos = -1, $w_img = '', $w_text = '', $w_font = -1, $w_color = '', $w_family = '')
	{
		if($this->watermark_enable==0 || !$this->check($source)) return false;
		if(!$target) $target = $source;
		if($w_pos == -1){$w_pos = $this->w_pos;}
		if($w_img == ""){$w_img = $this->w_img;}
		if($w_family == ""){$w_family = $this->w_family;}
		
		if(!$this->check_dir($w_img)){ //检测是否以”/“开头的绝对路径		    
			$w_img=realpath(dirname(__FILE__)."/../../".$w_img);//转换为全路径，防止出错
			}
		if(!$this->check_dir($w_family)){ //检测是否以”/“开头的绝对路径		    
			$w_family=realpath(dirname(__FILE__)."/../../".$w_family);//转换为全路径，防止出错
			}
			
		if($w_text == ""){$w_text = $this->w_text;}
		if($w_font == -1){$w_font = $this->w_font;}
		if($w_color == ""){$w_color = $this->w_color;}		
		$source_info = getimagesize($source);
		$source_w    = $source_info[0];
		$source_h    = $source_info[1];
		if($source_w < $this->w_minwidth || $source_h < $this->w_minheight) return false;
		switch($source_info[2])
		{
			case 1 :
				$source_img = imagecreatefromgif($source);
				break;
			case 2 :
				$source_img = imagecreatefromjpeg($source);
				break;
			case 3 :
				$source_img = imagecreatefrompng($source);
				break;
			default :
				return false;
		}
		if($this->watermark_enable==2 && file_exists($w_img))
		{
			$ifwaterimage = 1;
			$water_info   = getimagesize($w_img);
			$width        = $water_info[0];
			$height       = $water_info[1];
			switch($water_info[2])
			{
				case 1 :
					$water_img = imagecreatefromgif($w_img);
					break;
				case 2 :
					$water_img = imagecreatefromjpeg($w_img);
					break;
				case 3 :
					$water_img = imagecreatefrompng($w_img);
					break;
				default :
					return;
			}
		}
		else if($this->watermark_enable==1)
		{
			$ifwaterimage = 0;
			$temp = imagettfbbox($w_font, 0, $w_family, $w_text);//取得使用 truetype 字体的文本的范围
			//$width = $temp[2] - $temp[6];
			//$height = $temp[3] - $temp[7];
			$width = $temp[2] - $temp[6];
			$height = -$temp[3] - $temp[7];
			unset($temp);
		}
		else
		{
			return false;
		}
		switch($w_pos)
		{
			case 0:
				$wx = rand(0,($source_w - $width));
				$wy = rand(0,($source_h - $height));
				break;
			case 1:
				$wx = 5;
				$wy = 10;
				break;
			case 2:
				$wx = ($source_w - $width) / 2;
				$wy = 10;
				break;
			case 3:
				$wx = $source_w - $width - 5;
				$wy = 10;
				break;
			case 4:
				$wx = 5;
				$wy = ($source_h - $height) / 2;
				break;
			case 5:
				$wx = ($source_w - $width) / 2;
				$wy = ($source_h - $height) / 2;
				break;
			case 6:
				$wx = $source_w - $width - 5;
				$wy = ($source_h - $height) / 2;
				break;
			case 7:
				$wx = 10;
				$wy = $source_h - $height - 10;
				break;
			case 8:
				$wx = ($source_w - $width) / 2;
				$wy = $source_h - $height - 10;
				break;
			case 9:
				$wx = $source_w - $width - 5;
				$wy = $source_h - $height - 10;
				break;
			default:
				$wx = rand(0,($source_w - $width));
				$wy = rand(0,($source_h - $height));
				break;
		}
		if($ifwaterimage)
		{
			if($water_info[2] == 3) {
				imagecopy($source_img, $water_img, $wx, $wy, 0, 0, $width, $height);
			} else {
				imagecopymerge($source_img, $water_img, $wx, $wy, 0, 0, $width, $height, $this->w_pct);
			}
		}
		else
		{
			if(!empty($w_color) && (strlen($w_color)==7))
			{
				$r = hexdec(substr($w_color,1,2));
				$g = hexdec(substr($w_color,3,2));
				$b = hexdec(substr($w_color,5));
			}
			else
			{
				return;
			}
			//imagestring($source_img,$w_font,$wx,$wy,$w_text,imagecolorallocate($source_img,$r,$g,$b));
			
			$font_angle=0;//文字角度，0度为水平，90度为垂直
			imagettftext($source_img,$w_font,$font_angle,$wx,$wy+$height,imagecolorallocate($source_img,$r,$g,$b),$w_family,$w_text);  //写TTF文字到图中
		}
		switch($source_info[2])
		{
			case 1 :
				imagegif($source_img, $target);
				break;
			case 2 :
				imagejpeg($source_img, $target, $this->w_quality);
				break;
			case 3 :
				imagepng($source_img, $target);
				break;
			default :
				return;
		}
		if(isset($water_info))
		{
			unset($water_info);
		}
		if(isset($water_img))
		{
			imagedestroy($water_img);
		}
		unset($source_info);
		imagedestroy($source_img);
		return true;
	}

	function check($image)
	{
		return extension_loaded('gd') && preg_match("/\.(jpg|jpeg|gif|png)/i", $image, $m) && file_exists($image) && function_exists('imagecreatefrom'.($m[1] == 'jpg' ? 'jpeg' : $m[1]));
	}
	
	function check_dir($dirpath){//检测是否以”/“”http://“等开头的绝对路径
		  /*if (substr($dirpath,0,7)=="http://"){
			  return true;
			  }else if(substr($dirpath,0,6)=="ftp://"){
				  return true;
				  }else if(substr($dirpath,1,1)==":"){
					  return true;
					  }else{
						  return false;
						  }*/
		 if (strpos($dirpath,":")>0){
			 return true;
			 }else{
				 return false;
				 }
		}
}