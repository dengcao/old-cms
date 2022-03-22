/***************************************************************************
* Automatic Image Popup
* Copyright 2003 by David Schontzler | www.stilleye.com
* Free to use under GNU General Public License as long as this message
*  remains intact.
* Description:  Automate your image popup windows (centered and sized)
* Compatibility: Win/IE5+, Mozilla/Netscape, degrades otherwise
* URI: http://www.stilleye.com/projects/dhtml/iPop/
***************************************************************************
* Version: 2.0.1 + AutoApply
***************************************************************************/

///////////////// USER SETTINGS /////////////////
// Absolute path of *this* file on your server.  This must be set for the
// script to function!!!

//Builder修改
iPop.ScriptPath = "../Js/ipop.js";




// Set the target for browsers that don't support the script.  By default,
// target is "_self" which will open in the same window as the link.  Change
// it to whatever target you like.
iPop.DegradeTarget = "_self";

///////////////// FUNCTIONALITY /////////////////
/////////////////  DO NOT EDIT  /////////////////
function iPop(img, imgTitle) {
	// just follow the link in browsers that do not support images or the DOM
	if(!document.images || !document.getElementById) {
		// or launch in new window if that's what you wanted it to do
		switch(iPop.DegradeTarget) {
			case "_blank" : open(img); break;
			case "_self" : location = img; break;
			case "_top" : top.location = img; break;
			case "_parent" : window.parent.location = img; break;
			default : open(img, iPop.DegradeTarget);
		}
		return true;
	}
	
	// initial (small) window with loading screen
	var width = 150, height = 100;
	var left = (screen.availWidth - width)/2, top = (screen.availHeight - height)/ 2;
	var imgWin = window.open("about:blank", "", "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top);
	// when moz disables all popups, imgWin will be false
	if(!imgWin) return true;
	
	// user can pass an image title if they wish.  by default,
	// window title will display: "Image (img source)"
	imgTitle = imgTitle || "Image (" + img + ")";
	
	// html generated for use in our popup
	// note on the javascript functions:
	// wrapper functions with timeouts because sometimes the image is loaded
	// before the script is loaded, at least in Win/IE when doing local testing;
	// timeout should (presumably) prevent that
	var html = '<html><head><title>Loading</title>';
	html += '\n<script type="text/javascript" src="' + iPop.ScriptPath + '"></script>';
	//html += '\n<script type="text/javascript" src="../Js/ipop.js"><//script>';
	html += '\n<script type="text/javascript">';
	html += '\nvar _e = null;';
	html += '\nvar _title = "' + imgTitle + '"';
	html += '\nfunction iloaded(e) { _e = e; setTimeout("iPop.ImageLoaded(_e)", 10); };';
	html += '\nfunction ierror(e) { _e = e; setTimeout("iPop.ErrorLoading(_e)", 10); };';
	html += '\nfunction iview(e) { iPop.ImageLoadedManualPopup(e); };';
	html += '</script>';
	html += '<style type="text/css">';
	html += 'html, body { font : 12px Arial; margin : 0; }';
	html += '\nh1 { font-size : 1.5em; }';
	html += '\nh2 { font-size : 1.2em; }';
	html += '\na { color : blue; }';
	html += '\n.message {';
	html += '\n	position : absolute;';
	html += '\n	left : 0px;';
	html += '\n	top : 0px;';
	html += '\n	width : 150px;';
	html += '\n	height : 100px;';
	html += '\n	background : white;';
	html += '\n	text-align : center;';
	html += '\n}';
	html += '\n.message .main-message {';
	html += '\n	font-weight : bold;';
	html += '\n	display : block;';
	html += '\n}';
	html += '\n.message .secondary-message {';
	html += '\n	color : #999;';
	html += '\n	font-size : 11px;';
	html += '\n}';
	html += '\n.main-message.loading { margin-top : 35px; }';
	html += '\n.main-message.loaded { margin-top : 33px; }';
	html += '\n.main-message.error { margin-top : 25px; }';
	html += '\n#loading { z-index : 50; }';
	html += '\n#resize { z-index : 30; }';
	html += '\n#error { z-index : 40; }';
	html += '\n#image {';
	html += '\n	position : absolute;';
	html += '\n	left : 0px;';
	html += '\n	top : 0px;';
	html += '\n	width : 100%;';
	html += '\n	height : 100%;';
	html += '\n	z-index : 20;';
	html += '\n	padding : 10px;';
	html += '\n	background : white;';
	html += '\n}';
	html += '</style>';
	html += '\n</head>';
	html == '\n<body>';
	html += '\n<div id="loading" class="message"><span class="main-message loading">Loading image.</span> <span class="secondary-message">Please wait...</span></div>';
	html += '\n<div id="error" class="message"><span class="main-message error">Image not found.</span> <span class="secondary-message">Could not load image.<br><a href="javascript:window.close()">Close window</a></span></div>';
	html += '\n<div id="resize" class="message"><span class="main-message error">Image loaded.</span> <span class="secondary-message">Your browser does not allow for window resizing.<br><a href="javascript:iview(_e)">View Image</a></span></div>';
	html += '\n<div id="image"><img src="' + img + '" border="1" onload="iloaded(this)" onerror="ierror(this)"></div>';
	html += '\n</body></html>';
	
	imgWin.document.open();
	imgWin.document.write(html);
	imgWin.document.close();
	
	return false;
}

iPop.ImageLoaded = function(e) {
	if(!e) return;
	e.onload = null; e.onerror = null;
	
	var width = e.width + 30, height = e.height + 55;
	var tooLarge = false;
	
	if(width > screen.availWidth) {
		width = screen.availWidth - 20;
		tooLarge = true;
	}
	if(height > screen.availHeight) {
		height = screen.availHeight - 20;
		tooLarge = true;
	}
	if(tooLarge) {
		document.getElementById("image").style.overflow = "auto";
	}
	
	var left = (screen.availWidth - width)/2, top = (screen.availHeight - height)/ 2;
	window.resizeTo(width, height);
	window.moveTo(left, top);
	
	var winWidth = document.body.clientWidth, winHeight = document.body.clientHeight;
	if( (tooLarge && (winWidth < 200 || winHeight < 200) )
		|| !tooLarge && (e.width > 150 && winWidth <= 150 || e.height > 100 && winHeight <= 100) ) {
		_e = {
			src : e.src,
			width : e.width,
			height : e.height,
			tooLarge : tooLarge
		}
		document.getElementById("loading").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("image").style.display = "none";
		document.title = "Image Loaded";
	} else { // can resize
		document.getElementById("loading").style.display = "none";
		document.getElementById("error").style.display = "none";
		document.getElementById("resize").style.display = "none";
		document.title = _title;
	}
}

iPop.ErrorLoading = function(e) {
	if(!e) return;
	e.onload = null; e.onerror = null;
	
	document.getElementById("loading").style.display = "none";
	document.getElementById("resize").style.display = "none";
	document.getElementById("image").style.display = "none";
	document.title = "Image not found";
}

iPop.ImageLoadedManualPopup = function(e) {
	if(!e) return;
	var width = e.width + 20, height = e.height + 20;
	if(width > screen.availWidth) width = screen.availWidth - 20;
	if(height > screen.availHeight) height = screen.availHeight - 100;
	var left = (screen.availWidth - width)/2, top = (screen.availHeight - height)/ 2;
	window.open(e.src, "ManualImageViewer", "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top + (e.tooLarge ? ",scrollbars" : ""));
	window.close();
}

///////////////// EXTENSIONS /////////////////

// AutoApply 1.0
iPop.AutoApply = function(container) {
	if(!container) container = document;
	var a = container.getElementsByTagName("A");
	for(var i = 0; i < a.length; i++) {
		if( a[i].href.match(/\.(gif|jpg|png|jpeg)$/i) ) {
			applyPopup(a[i]);
		}
	}
	
	function applyPopup(link) {
		// check to see if link holds *just* a thumbnail and get
		// the thumbnail's alternate text for image popup title
		var n, imgs = 0, whitespace = 0, alt = null;
		for(var i = 0; n = link.childNodes[i]; i++) {
			if(n.tagName == "IMG") {
				imgs++;
				alt = n.alt;
			} else if(n.nodeValue) {
				var val = n.nodeValue;
				if( val.replace(/\s+/g, "") == "" ) whitespace++;
			}
		}
		n = null;
		
		// apply iPop to link
		link.onclick = function(e) { return iPop(this.href, alt); }
	}
}
