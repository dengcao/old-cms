//////////////////////////////////////////////////////////////////////////////////////////
//显示提示信息
//可修改风格及样式，注意保留表格ID（id=MsShow）即可！
//////////////////////////////////////////////////////////////////////////////////////////
document.write(
'<table style="position:absolute;background-color:#F7F7F7;width:360px;height:77px;z-index:88;left:360px;top:-144px;filter:Alpha(Opacity=100,style=2)" id=MsShow>'
+'<tr><td align=center style="font-size:12px; font-family:Arial, Tahoma;color: #FF0000;" bgcolor="#EEEEEE"></td></tr>'
+'</table>'
)

var ms,mst
function msg(n)
{
	MsShow.cells[0].innerText=n
	ms=180
	sport()
}

function sport(){
try
	{
	if(MsShow.cells[0].outerText=="")ms=-100
	if(ms>-100)
		{
		mst=setTimeout('sport()',25)
		MsShow.style.top=document.body.scrollTop+ms
		}
	else MsShow.style.top=ms
	ms--
	}
catch(e)
	{
	ms=-100
	clearTimeout(mst)
	}
}
