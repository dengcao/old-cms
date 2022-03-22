//                ╭═══════════════╮
//                ║                              ║
//    ══════┤         【通用函数】         ├══════
//                ║                              ║            
//                ╰═══════════════╯            

//////////////////////////////////////////////////////////////////////////////////////////
//判断输入的内容是否为空
//	var obj_form = document.FormMailto;
//	if ( IsBlank( obj_form.user_name,"用户帐号" ) ) 
//		return false;
//////////////////////////////////////////////////////////////////////////////////////////
function IsBlank( ObjInput, AlertTxt )
{
  if(ObjInput.value == "")
  {
	  alert('系统提示：\n\n'+AlertTxt+'不能为空，请您输入 ！\n');
      ObjInput.focus();
	  return true;
   }
}

  function checkall2(form)  
 {  
 var a = document.getElementsByTagName("input");  
//  var a = form.elements;
 if(a[2].checked==true){  
 for (var i=0; i<a.length; i++)  
 if (a[i].name != 'Orderid') {a[i].checked = false; } 
 }  
 else  
 {  
 for (var i=0; i<a.length; i++)  
 if (a[i].name != 'Orderid') {a[i].checked = true;  }
 }  
 } 
 
 
 function pinluo_checkall(form,input_name)  
 {  
 var a = document.getElementsByTagName("input");  
//  var a = form.elements;
 if(a[2].checked==true){  
 for (var i=0; i<a.length; i++)  
 if (a[i].name != input_name) {a[i].checked = false; } 
 }  
 else  
 {  
 for (var i=0; i<a.length; i++)  
 if (a[i].name != input_name) {a[i].checked = true;  }
 }  
 } 

//////////////////////////////////////////////////////////////////////////////////////////
//判断输入的内容是否为数字
//////////////////////////////////////////////////////////////////////////////////////////
function CheckNumber( ObjInput, AlertTxt )
{
	var checkOK = "1234567890";
	var checkStr = ObjInput.value;
	var allValid = false;
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
			break;
			if (j == checkOK.length)
			{
	  			alert('系统提示：\n\n'+AlertTxt+'含非数字字符，请您重新输入 ！\n');
    			ObjInput.focus();
				ObjInput.value = ''
				return true;
				break;
			}
	}
}

//////////////////////////////////////////////////////////////////////////////////////////
//判断限制输入内容的字数
//<textarea name="GuestContent" cols="54" rows="10"  class="textarea1" onFocus="this.select()" onMouseOver="this.style.background='#FFFFFF';this.focus()" onMouseOut="this.style.background='#F7F7F7';" onkeydown=gbcount(this.form.GuestContent,this.form.total,this.form.used,this.form.remain); onkeyup=gbcount(this.form.GuestContent,this.form.total,this.form.used,this.form.remain);></textarea>
//<br>最多字数：<input name=total disabled class="input" value=500 size=3 maxLength=4>已用字数：<input name=used disabled class="input" value=0 size=3 maxLength=4>剩余字数：<input name=remain disabled class="input" value=500 size=3 maxLength=4>
//////////////////////////////////////////////////////////////////////////////////////////

function gbcount(message,total,used,remain)
{
	var max;
	max = total.value;
	if (message.value.length > max) {
	message.value = message.value.substring(0,max);
	used.value = max;
	remain.value = 0;
	msg(" 系统提示：\n\n内容字数不能超过 500 个字 ！\n");
	}
	else {
	used.value = message.value.length;
	remain.value = max - used.value;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////
//判断输入的电子邮件
//	var ObjFormMailto = document.FormMailto;
//	if ( CheckEmail( ObjFormMailto.UserEmail,false ) ) 
//		return false;
//////////////////////////////////////////////////////////////////////////////////////////
function CheckEmail(ObjInput, AllowedNull)
{
	var datastr = ObjInput.value;
	var lefttrim = datastr.search(/\S/gi);
	
	if (lefttrim == -1) 
	{
		if (AllowedNull) 
		{
			return 1;
		} 
		else 
		{
			msg(" 系统提示：\n\n请您输入一个正确的E-mail地址！\n");
			ObjInput.focus();
			return -1;
		}
	}
	
	var myRegExp = /[a-z0-9](([a-z0-9]|[_\-\.][a-z0-9])*)@([a-z0-9]([a-z0-9]|[_\-][a-z0-9])*)((\.[a-z0-9]([a-z0-9]|[_\-][a-z0-9])*)*)/gi;
	var answerind = datastr.search(myRegExp);
	var answerarr = datastr.match(myRegExp);
	
	if (answerind == 0 && answerarr[0].length == datastr.length)
	{
		return 0;
	}

	msg(" 系统提示：\n\n请您输入一个正确的E-mail地址！\n");
	ObjInput.focus();
	return -1;
}
//////////////////////////////////////////////////////////////////////////////////////////
//定位光标的位置
//SetFocus(document.FormMailto.UserName); 
//////////////////////////////////////////////////////////////////////////////////////////
function SetFocus(ObjInput)
{
	if ( ObjInput.value == "" )
		ObjInput.focus();
	else
		ObjInput.select();
}
//////////////////////////////////////////////////////////////////////////////////////////
//取得屏幕的大小
//ScreenSize(document.FormMailto.ScreenSize); 
//////////////////////////////////////////////////////////////////////////////////////////
function ScreenSize(ObjInput) 
{
	if ((screen.width == 640) && (screen.height == 480)) 
		size = "640 x 480";
	else if ((screen.width == 800) && (screen.height == 600))
		size = "800 x 600";
	else if ((screen.width == 1024) && (screen.height == 768))
		size = "1024 x 768";
	else if ((screen.width == 1152) && (screen.height == 864))
		size = "1152 x 864";
	else if ((screen.width == 1280) && (screen.height == 1024))
		size = "1280 x 1024";
	else if ((screen.width == 1600) && (screen.height == 1200))
		size = "1600 x 1200";
	else size = "The default";
	ObjInput.value = ("访客的屏幕分辨率为 " + size + " 。");
}
//////////////////////////////////////////////////////////////////////////////////////////
//取得提交内容
//SubmitContent(document.FormMailto.ScreenSize); 
//////////////////////////////////////////////////////////////////////////////////////////
function SubmitContent(ObjInput,ObjInputName) 
{
	ObjInputName.value = ObjInput.innerHTML; 
}
//////////////////////////////////////////////////////////////////////////////////////////
// 修改编辑栏高度
//////////////////////////////////////////////////////////////////////////////////////////
function admin_Size(num,objname)
{
	var obj=document.getElementById(objname)
	if (parseInt(obj.rows)+num>=3) {
		obj.rows = parseInt(obj.rows) + num;	
	}
	if (num>0)
	{
		obj.width="90%";
	}
}
//////////////////////////////////////////////////////////////////////////////////////////
// 单击选择
//////////////////////////////////////////////////////////////////////////////////////////
function CheckAll(form)
{
	for ( var i = 0; i < form.elements.length; i = i + 1 )
	{
		var e = form.elements[i];
		if (e.name != 'chkall' )
		e.checked = form.chkall.checked;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////
// 单击选择
//////////////////////////////////////////////////////////////////////////////////////////
function CheckAllListA(form)
{
	for ( var i = 0; i < form.elements.length; i = i + 3 )
	{
		var e = form.elements[i];
		if (e.name != 'chkallA' )
		if (e.name != 'chkallB' )
		e.checked = form.chkallA.checked;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////
// 单击选择
//////////////////////////////////////////////////////////////////////////////////////////
function CheckAllListB(form)
{
	for ( var i = 2; i < form.elements.length; i = i + 3 )
	{
		var e = form.elements[i];
		if (e.name != 'chkallA' )
		if (e.name != 'chkallB' )
		e.checked = form.chkallB.checked;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////
// 当上传图片等文件时，往下拉框中填入图片路径，可根据实际需要更改此函数
//////////////////////////////////////////////////////////////////////////////////////////
function doChange(objText, objDrop)
{
	if (!objDrop) return;
	var str = objText.value;
	var arr = str.split("|");
	var nIndex = objDrop.selectedIndex;
	objDrop.length=1;
	for (var i=0; i<arr.length; i++)
	{
		objDrop.options[objDrop.length] = new Option(arr[i], arr[i]);
	}
	objDrop.selectedIndex = nIndex;
}
function Picture(o)
{
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;  
}


function WinOpenSmall(url,width,height)
{
	var left = (screen.width/2) - width/2;
	var top = (screen.height/2) - height/2;
	var styleStr = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no resizable=no,z-lock=no,fullscreen=no,width='+width+',height='+height+',left='+left+',top='+top+',screenX='+left+',screenY='+top;
	window.open(url,"", styleStr);
}
function showsubmenu(sid)
{
	whichEl = eval("submenu" + sid);
	if (whichEl.style.display == "none")
	{
		eval("submenu" + sid + ".style.display=\"\";");
	}
	else
	{
		eval("submenu" + sid + ".style.display=\"none\";");
	}
}



































//                ╭═══════════════╮
//                ║                              ║
//    ══════┤         【文章管理】         ├══════
//                ║                              ║            
//                ╰═══════════════╯            


//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加修改文章大类
//////////////////////////////////////////////////////////////////////////////////////////
function CheckArticleMax(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxName,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.MaxRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.MaxRank,"显示顺序" ) ) 
		return false;
		
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加文章
//////////////////////////////////////////////////////////////////////////////////////////
function CheckArticle00(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.ArtTitle,"文章标题" ) )
		return false;
	//征求LUYE意见，屏蔽该数据检查
	/*
	// getHTML()为eWebEditor自带的接口函数，功能为取编辑区的内容
	if (eWebEditor1.getHTML()=="")
	{
		msg(" 系统提示：\n\n文章内容不能为空，请您输入 ！\n");
		return false;
	}
	*/

	if ( IsBlank( FormName.ArtHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ArtHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ArtRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ArtRank,"显示顺序" ) ) 
		return false;
	if ( IsBlank( FormName.ArtUpdateTime,"发布日期" ) )
		return false; 

	FormName.submit();
}


//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加文章
//////////////////////////////////////////////////////////////////////////////////////////
function CheckArticle10(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxID,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.ArtTitle,"文章标题" ) )
		return false;
	//征求LUYE意见，屏蔽该数据检查
	/*
	if ( IsBlank( FormName.ArtKeyword,"关键字" ) )
		return false;
	if ( IsBlank( FormName.ArtDescription,"文章描述" ) )
		return false;
	// getHTML()为eWebEditor自带的接口函数，功能为取编辑区的内容
	if (eWebEditor1.getHTML()=="")
	{
		msg(" 系统提示：\n\n文章内容不能为空，请您输入 ！\n");
		return false;
	}
	*/

	if ( IsBlank( FormName.ArtHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ArtHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ArtRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ArtRank,"显示顺序" ) ) 
		return false;
	if ( IsBlank( FormName.ArtUpdateTime,"发布日期" ) )
		return false; 

	FormName.submit();
}

function CheckArticle20(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxID,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.MinID,"小类名称" ) )
		return false;
	if ( IsBlank( FormName.ArtTitle,"文章标题" ) )
		return false;

	if ( IsBlank( FormName.ArtHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ArtHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ArtRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ArtRank,"显示顺序" ) ) 
		return false;
	if ( IsBlank( FormName.ArtUpdateTime,"发布日期" ) )
		return false; 

	FormName.submit();
}



//////////////////////////////////////////////////////////////////////////////////////////
function CheckArticleSearch(FormName)
{
	FormName.submit();
}

function UploadImageShow(InputName,ImgName)
{
	ImgName.src=InputName.value;
}






















//                ╭═══════════════╮
//                ║                              ║
//    ══════┤         【产品管理】         ├══════
//                ║                              ║            
//                ╰═══════════════╯            


//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加修改产品大类
//////////////////////////////////////////////////////////////////////////////////////////
function CheckMax(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxName,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.MaxRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.MaxRank,"显示顺序" ) ) 
		return false;
		
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加修改产品小类
//////////////////////////////////////////////////////////////////////////////////////////
function CheckMin(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxID,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.MinName,"小类名称" ) )
		return false;
	if ( IsBlank( FormName.MinRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.MinRank,"显示顺序" ) ) 
		return false;
		
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加产品
//////////////////////////////////////////////////////////////////////////////////////////
function CheckProduct(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxID,"大类名称" ) )
		return false;
	if ( IsBlank( FormName.MinID,"小类名称" ) )
		return false;
	if ( IsBlank( FormName.ProModel,"产品型号" ) )
		return false;
	if ( IsBlank( FormName.ProName,"产品名称" ) )
		return false;
	//征求客户意见，屏蔽该数据检查,小邓，2008
	/*
	if ( IsBlank( FormName.ProKeyword,"关键字" ) )
		return false;
	if ( IsBlank( FormName.ProDescription,"文章描述" ) )
		return false;
	*/
	// getHTML()为eWebEditor自带的接口函数，功能为取编辑区的内容
/*	if (eWebEditor1.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品简介不能为空，请您输入 ！\n");
		return false;
	}
	if (eWebEditor2.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品说明不能为空，请您输入 ！\n");
		return false;
	}
*/	
	if ( IsBlank( FormName.ProHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ProHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ProRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ProRank,"显示顺序" ) ) 
		return false;
	if ( IsBlank( FormName.ProUpdateTime,"发布日期" ) )
		return false; 
	FormName.submit();
}
function CheckSearch(FormName)
{
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加产品
//////////////////////////////////////////////////////////////////////////////////////////
function CheckProduct10(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.MaxID,"分类名称" ) )
		return false;
	
	//if ( IsBlank( FormName.ProName,"产品名称" ) )
	//	return false;
	
	if ( IsBlank( FormName.ProModel,"产品型号" ) )
		return false;
	/*	
	// getHTML()为eWebEditor自带的接口函数，功能为取编辑区的内容
	if (eWebEditor1.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品简介不能为空，请您输入 ！\n");
		return false;
	}
	if (eWebEditor2.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品说明不能为空，请您输入 ！\n");
		return false;
	}
	
	if ( IsBlank( FormName.ProHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ProHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ProRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ProRank,"显示顺序" ) ) 
		return false;
	//if ( IsBlank( FormName.ProUpdateTime,"发布日期" ) )
		//return false; */
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加产品
//////////////////////////////////////////////////////////////////////////////////////////
function CheckProduct00(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.ProModel,"产品型号" ) )
		return false;
	if ( IsBlank( FormName.ProName,"产品名称" ) )
		return false;
	/*
	// getHTML()为eWebEditor自带的接口函数，功能为取编辑区的内容
	if (eWebEditor1.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品简介不能为空，请您输入 ！\n");
		return false;
	}
	if (eWebEditor2.getHTML()=="")
	{
		msg(" 系统提示：\n\n产品说明不能为空，请您输入 ！\n");
		return false;
	}
	*/
	if ( IsBlank( FormName.ProHits,"浏览次数" ) )
		return false; 
	if ( CheckNumber( FormName.ProHits,"浏览次数" ) ) 
		return false;
	if ( IsBlank( FormName.ProRank,"显示顺序" ) )
		return false; 
	if ( CheckNumber( FormName.ProRank,"显示顺序" ) ) 
		return false;
	if ( IsBlank( FormName.ProUpdateTime,"发布日期" ) )
		return false; 
	FormName.submit();
}















//                ╭═══════════════╮
//                ║                              ║
//    ══════┤         【网站频道】         ├══════
//                ║                              ║            
//                ╰═══════════════╯            



//////////////////////////////////////////////////////////////////////////////////////////
//	检查添加栏目菜单
//////////////////////////////////////////////////////////////////////////////////////////
function CheckWebConfig(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.Web_Menu,"栏目名称" ) )
		return false;
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////







function CheckFeedback(FormName)
{
	FormName.submit();
}











//                ╭═══════════════╮
//                ║                              ║
//    ══════┤         【用户管理】         ├══════
//                ║                              ║            
//                ╰═══════════════╯            


//////////////////////////////////////////////////////////////////////////////////////////
//	检查用户资料
//////////////////////////////////////////////////////////////////////////////////////////
function CheckUserShow(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.UserPassword1,"用户旧密码" ) )
		return false;
	
	if ( IsBlank( FormName.UserPassword2,"用户新密码" ) )
		return false; 
	if ( IsBlank( FormName.UserPassword3,"验证新密码" ) ) 
		return false;
	if ( FormName.UserPassword2.value != FormName.UserPassword3.value )
	{
		msg(" 系统提示：\n\n用户新密码与验证新密码不符，请您重新输入！\n");
		FormName.UserPassword2.value = "";
		FormName.UserPassword3.value = "";
		FormName.UserPassword2.focus();
		return false;
	}
	if ( IsBlank( FormName.RealName,"真实姓名" ) ) 
		return false;
	FormName.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////
//	检查用户资料
//////////////////////////////////////////////////////////////////////////////////////////
function CheckUser(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.AdminName,"管理员帐号" ) )
		return false;
	if ( IsBlank( FormName.AdminPassword1,"用户密码" ) )
		return false; 
	if ( IsBlank( FormName.AdminPassword2,"验证密码" ) ) 
		return false;
	if ( FormName.AdminPassword1.value != FormName.AdminPassword2.value )
	{
		msg(" 系统提示：\n\n用户密码与验证密码不符，请您重新输入！\n");
		FormName.AdminPassword1.value = "";
		FormName.AdminPassword2.value = "";
		FormName.AdminPassword1.focus();
		return false;
	}
	if ( IsBlank( FormName.RealName,"真实姓名" ) ) 
		return false;
	FormName.submit();
}
function CheckEditUser(FormName)
{
	//判断输入的内容
	if ( IsBlank( FormName.UserName,"用户帐号" ) )
		return false;
	
	if ( FormName.UserPassword1.value != FormName.UserPassword2.value )
	{
		msg(" 系统提示：\n\n用户密码与验证密码不符，请您重新输入！\n");
		FormName.UserPassword1.value = "";
		FormName.UserPassword2.value = "";
		FormName.UserPassword1.focus();
		return false;
	}
	if ( IsBlank( FormName.RealName,"真实姓名" ) ) 
		return false;
	FormName.submit();
}

function confrim()
{
    if(confirm('系统提示：\n\n确定删除选定的信息吗？\n\n删除操作不可恢复，请慎重选择！'))
    {
	    return true;
	 }
    return false;
}
