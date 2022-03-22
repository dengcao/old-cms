//var a_motion=new Array(),motion_list="",tm_thread,tm_id=0
var tm_msg
/*
function motion(o,proc){
	var a,a0,obj
	if(proc!=null){
		a_motion[o]=new Array()
		a_motion[o].step=1
		a_motion[o].proc=proc
	}
	if(a_motion[o].proc==""){
		a_motion[o]=null
		return
	}
	a=a_motion[o].proc.split(";")
	a0=a[0].split(":")
	if(a0[0]=="obj")
		a_motion[o].obj=eval(a0[1])
	if(a0[0]=="step")
		a_motion[o].step=a0[1]*1
	if(a0[0]=="run")
		eval(a0[1])
	a_motion[o].proc=a.slice(1).join(";")
	if(a0[0]=="obj"||a0[0]=="step"||a0[0]=="run"){
		motion(o)
		return
	}
	a_motion[o].play=a0[0]+":"+a0[1]
	motion_list+=","+o
	if(motion_list.slice(0,1)==",")
		motion_list=motion_list.slice(1)
}
function tm_motion(){
	var a=motion_list.split(","),ad,i,m,n,isDone=false
	for(i=0;i<a.length;i++){
		m=a_motion[a[i]]
		ad=m.play.split(":")
		if(ad[0]=="opacity"){
			if(m.obj.style.filter.indexOf("alpha")==-1)
				m.obj.style.filter="alpha(opacity=100)"
			ad[1]*=1
			n=m.obj.style.filter.replace("alpha(opacity=","").slice(0,-1)*1
			if(n!=ad[1])
				m.obj.style.filter="alpha(opacity="+(ad[1]>n ? n+m.step : n-m.step)+")"
			else{
				if(n==0)
					m.obj.style.display="none"
				if(n==100)
					m.obj.style.filter=""
				isDone=true
			}
		}
		if(ad[0]=="wait"){
			ad[1]--
			m.play=ad[0]+":"+ad[1]
			if(ad[1]==0)
				isDone=true
		}
		if(isDone){
			motion_list=(","+motion_list+",").replace(","+a[i]+",",",").slice(1,-1)
			motion(a[i])
		}
	}
}
*/
function setPos(o,css){
	var a=css.split(";")
	for(var i in a){
		a[i]=a[i].split(":")
		a[i][1]=a[i][1].replace("body.w",document.body.offsetWidth).replace("body.h",document.body.offsetHeight)
		a[i][1]=a[i][1].replace(".x",".style.posLeft").replace(".y",".style.posTop").replace(".w",".offsetWidth").replace(".h",".offsetHeight")
		try{
			if(a[i][0]=="x")
				o.style.left=eval(a[i][1])
			if(a[i][0]=="y")
				o.style.top=eval(a[i][1])
			if(a[i][0]=="w")
				o.style.width=eval(a[i][1])
			if(a[i][0]=="h")
				o.style.height=eval(a[i][1])
		}catch(e){}
	}
}
/*
function showObj(ol){
	var a=ol.replace(";",",;,").split(","),tp="block"
	for(i=0;i<a.length;i++){
		if(a[i]==";")
			tp="none"
		if(a[i]!=""&&a[i]!=";")
			eval(a[i]).style.display=tp
	}
}
function refImg(){
	var ol=document.images
	for(var i=0;i<ol.length;i++){
		if(ol[i].readyState!="complete")
			ol[i].src=ol[i].src
	}
}
*/
function msg(key){
	if(typeof(tm_msg)!="undefined")
		clearTimeout(tm_msg)
	if(key!=1&&key!=2){
		setPos(lb_msg,"x:(lb_msg.parentElement.w-600)/2;y:lb_msg.parentElement.h/2")
		lb_msg.innerText=key
		lb_msg.style.letterSpacing="24px"
		msg(1)
		return
	}
	if(key==1){
		lb_msg.style.letterSpacing=lb_msg.style.letterSpacing.replace("px","")-1
		if(lb_msg.style.letterSpacing.replace("px","")>0)
			tm_msg=setTimeout("msg(1)",30)
		else
			msg(2)
		return
	}
	lb_msg.style.posTop-=2
	if(lb_msg.style.posTop>0)
		tm_msg=setTimeout("msg(2)",10)
	else
		lb_msg.style.posTop=-1000
}
/*
function addBt(key,loc){
	var a=key.split(";"),a_loc=loc.split(",")
	var x,y,l=""
	if(a_loc[4]=="")
		a_loc[4]=0
	if(a_loc[5]==null)
		a_loc[5]=0
	for(var i in a){
		a[i]=a[i].split(",")
		x=a_loc[0]*1+a_loc[4]*i
		y=a_loc[1]*1+a_loc[5]*i
		l+="<span onclick=\"menu_click('"+a[i][1]+"')\" onmouseover='this.scrollTop="+a_loc[3]+"' onmouseout='this.scrollTop=0' onmouseup='if(document.elementFromPoint(event.x,event.y)!=this.children(0))this.scrollTop=0' style='position:absolute;left:"+x+";top:"+y+";width:"+a_loc[2]+";height:"+a_loc[3]+";overflow:hidden;cursor:hand'>\
			<img src=file:///D|/wwwroot/images/bt/%22+a%5Bi%5D%5B0%5D+%22.gif></span>"
	}
	document.write(l)
}
*/