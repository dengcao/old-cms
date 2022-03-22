<?php 
//=========系统初始化配置，以下信息请勿修改===================
error_reporting(E_ALL & (E_NOITICE) & ~(E_WARNING));//忽略错误警告
define('SYS_BASE_PATH_ROOT',realpath(dirname(__FILE__).'/../').'/'); //定义服务器的绝对路径
define('IN_CMS',true);
//=========系统初始化配置，以上信息请勿修改===================


//服务器基本配置
define('WEB_DATE_DEFAULT_TIMEZONE','8');  //系统时区设置
@date_default_timezone_set('Etc/GMT'.(WEB_DATE_DEFAULT_TIMEZONE > 0 ? '-' : '+').(abs(WEB_DATE_DEFAULT_TIMEZONE)));

//网站基本信息配置
define('WEB_NAME','广西贵港市XX家具公司');  //网站名称
define('WEB_URL','http://www.caozha.com/');  //网站URL地址，由http://开头
define('WEB_DIR','/');  //网站安装目录
define('WEB_LOGO','/templates/default/images/logo.jpg');  //网站LOGO
define('WEB_BANNER','/templates/default/images/b1_s1.jpg');  //网站Banner

//页面缓存设置
define('WEB_ISCACHE',false);  //是否开启缓存
define('WEB_CACHE_TIME','3600');  //页面缓存时间，单位：秒

//网站SEO配置
define('WEB_SEOTITLE','广西贵港市XX家具有限公司');  //全站SEO标题
define('WEB_SEOTITLE_INDEX','贵港市XX家具有限公司');  //首页SEO标题
define('WEB_SEOKEYWORDS_INDEX','家具,办公家具,贵港家具');  //首页SEO关键字
define('WEB_SEODESCRIPTION_INDEX','广西贵港市XX家具有限公司是一家集研发、设计、生产、销售于一体的专业性办公家具公司。公司自成立以来，始终坚持以人为本的原则，注重产品的优良品质，全力打造办公家具的优秀品牌。');  //首页SEO描述

//图片加水印配置
define('WEB_ISWATERMARK','2');  //是否启用水印，0为不启用，1为文字水印，2为图片水印
define('WEB_WATERMARK_TEXT','www.5300.cn');  //水印文字，比如填网址：www.5300.cn
define('WEB_WATERMARK_TEXT_COLOR','#ff0000');  //水印文字颜色
define('WEB_WATERMARK_TEXT_FAMILY','/include/fonts/arial.ttf');  //水印文字字体
define('WEB_WATERMARK_TEXT_SIZE','16');  //水印字体大小
define('WEB_WATERMARK_IMG','/images/watermark.gif');  //水印图片
define('WEB_WATERMARK_MINWIDTH','300');  //设置加水印条件：宽，小于此尺寸的图片将不加水印
define('WEB_WATERMARK_MINHEIGHT','300');  //设置加水印条件：高，小于此尺寸的图片将不加水印
define('WEB_WATERMARK_PCT','90');  //水印图片透明度，范围为 1~100 的整数，数值越小水印图片越透明
define('WEB_WATERMARK_QUALITY','80');  //JPEG 水印质量，范围为 0~100 的整数，数值越大结果图片效果越好，但尺寸也越大
define('WEB_WATERMARK_POS','9');  //水印添加位置，共1-9个位置

//图片缩略图功能配置
define('WEB_ISTHUMB','0');  //是否启用缩略图功能，0为不启用，1为启用
define('WEB_THUMB_WIDTH','300');  //设置缩略图大小：宽
define('WEB_THUMB_HEIGHT','300');  //设置缩略图大小：高

//网站上传附件设置
define('WEB_UPLOAD_FRONT','0');  //是否允许前台上传
define('WEB_UPLOAD_MAXSIZE','1024');  //允许上传大小

//在线客服设置
define('WEB_ISSERVICE','1');  //是否启用在线客服，0为不启用，1为启用

//网站关闭维护设置
define('WEB_ISWEBCLOSE','0');  //是否关闭网站，0为不关闭，1为关闭；此设置仅对动态页面生效
define('WEB_WEBCLOSE_CAUSE','服务器维护，请您明天再来。非常感谢您的支持！');  //网站关闭原因
