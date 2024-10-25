# old-cms PHP企业网站管理系统

old-cms是一个使用原生PHP开发的实用的PHP企业网站管理系统，包括企业网站常用的功能板块，如：产品管理、新闻管理、栏目管理、模板标签管理、分类管理、诚聘英才、在线留言反馈、关于我们（公司简介）等等，也有较完善的后台管理功能。

这个系统是本人于2012年初学PHP时，想去面试一家公司苦于自己又没有实战的项目，于是花了几天时间快速搭建、为了应付面试的，因为年代久远（2012.8.13，距离现在已有10年了），且当时自己刚学完PHP，所以这个项目系统肯定有很多不成熟的地方。如今重读了一下代码，发现代码确实写得不规范、构思也比较乱，可能还有一些BUG，没详细测试。当时智能手机还远没现在普及流行，所以也没做手机版适配，仅PC端。

因此，建议大家不要拿这个源码用于实际的生产环境了，否则出了问题自己负责，哈哈哈。（仅用于本地测试、学习等）

现在，翻箱底将项目代码开源出来，不为别的，仅仅是为了纪念一下当年自己学完PHP做的第一个网站，也纪念一下逝去的青春。



### 安装使用



**开发环境**

PHP5.2-5.6，MySQL5.7，Apache（或Nginx），phpMyAdmin。

源码仅支持PHP5，不支持PHP7、PHP8。



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

Gitee：https://gitee.com/dengzhenhua/old-cms

GitHub：https://github.com/dengcao/old-cms



### 关于

开发：[邓草博客 blog.5300.cn](http://blog.5300.cn)

赞助：[品络 www.pinluo.com](http://blog.5300.cn)  &ensp;  [AI工具箱 5300.cn](https://5300.cn)  &ensp;  [汉语言文学网 hyywx.com](https://hyywx.com)  &ensp;  [雄马 xiongma.cn](https://xiongma.cn) &ensp;  [优惠券 tm.gs](http://tm.gs)



### 界面预览


![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195428_d3ca1ea4_7397417.png "1.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195438_bb1e8834_7397417.png "2.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195448_fb32e917_7397417.png "3.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195459_4b47988c_7397417.png "4.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195509_0af343bf_7397417.png "5.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195538_9a6be35e_7397417.png "6.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195548_cd95fb36_7397417.png "7.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195558_2a5967e8_7397417.png "后台1.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195609_00a03af6_7397417.png "后台2.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195622_a4300504_7397417.png "后台3.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195636_3f83d238_7397417.png "后台4.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195649_3f6101a5_7397417.png "后台5.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195702_2ebc1d97_7397417.png "后台6.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195714_0c0b2a91_7397417.png "后台7.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195725_aebbd0d9_7397417.png "后台8.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195735_7a51c4b3_7397417.png "后台9.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195746_d703fb0b_7397417.png "后台10.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195757_557fe86f_7397417.png "后台11.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195809_db3933d2_7397417.png "后台12.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195821_35e6cff1_7397417.png "后台13.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195832_2f462ac7_7397417.png "后台14.png")

![输入图片说明](https://images.gitee.com/uploads/images/2022/0322/195842_dad1d19d_7397417.png "后台15.png")


