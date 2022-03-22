# old-cms PHP企业网站管理系统

old-cms是一个实用的PHP企业网站管理系统，使用原生PHP开发，包括企业网站常用的功能板块，如：产品管理、新闻管理、栏目管理、模板标签管理、分类管理、诚聘英才、在线留言反馈、关于我们（公司简介）等等，也有较完善的后台管理功能。

这个系统是本人于2012年初学PHP时，想去面试一家公司苦于自己又没有实战的项目，于是花了几天时间快速搭建、为了应付面试的，因为年代久远（2012.8.13，距离现在已有10年了），且当时自己刚学完PHP，所以这个项目系统肯定有很多不成熟的地方。如今重读了一下代码，发现代码确实写得不规范、构思也比较乱，可能还有一些BUG，没详细测试。当时智能手机还远没现在普及流行，所以也没做手机版适配，仅PC端。

因此，建议大家不要拿这个源码用于实际的生产环境了，否则出了问题自己负责，哈哈哈。（仅用于本地测试、学习等）

现在，翻箱底将项目代码开源出来，不为别的，仅仅是为了纪念一下当年自己学完PHP做的第一个网站，也纪念一下逝去的青春。


### 安装使用


**开发环境**

PHP5.2-5.6，MySQL5.7，Apache（或Nginx），phpMyAdmin。

测试了源码仅支持PHP5，不支持PHP7、PHP8。


**快速安装**

1、PHP版本：PHP5.2至5.6都可以（不支持PHP7、PHP8）。

2、上传目录/Src/内所有源码到服务器，并设置网站的根目录指向目录/Src/。

3、将/Database/目录里的.sql文件导入到MYSQL数据库。

4、修改文件\Src\include\conn.php，配置您的数据库信息。

5、后台访问地址：http://您的域名/admin/admin.php?action=login   (账号：admin   密码：123456)

6、为了安全，可以改名后台目录\admin（可以任意改名），同时，记得更新kindeditor和UEditor编辑器到最新版（版本太旧，可能会有安全漏洞）。


**模板标签使用说明**

参考源码内文件：\Src\模板标签说明-template_code.txt

模板实例参考：\Src\templates\default


### 特别鸣谢

使用了smarty模板引擎、kindeditor、UEditor等，特别致谢！

### 赞助支持：

支持本源码，请到Gitee和GitHub给我们点Star！

Gitee：https://gitee.com/caozha/old-cms

GitHub：https://github.com/cao-zha/old-cms

### 关于开发者

邓草 博客 www.caozha.com

### 界面预览



