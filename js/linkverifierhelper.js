//daplvflag=1;
var dlvpageDir;
var alreadyrunflag = 0; //flag to indicate whether target function has already been run
var dlvposRelative;
var dlvOverflowHidden;
var dlvOverflowPos = "0";
var dlvRelativePos = "0";

//width and height of viewport
var dlvw=window,dlvd=document,dlve=dlvd.documentElement,dlvg=dlvd.getElementsByTagName('body')[0],dlvx=dlvw.innerWidth||dlve.clientWidth||dlvg.clientWidth,dlvy=dlvw.innerHeight||dlve.offsetHeight||dlvg.offsetHeight;
			
var dlvscriptsObj = document.getElementsByTagName('script'); 
for (var dlvi = dlvscriptsObj.length - 1; dlvi >= 0; --dlvi) { 
	var dlvscriptsObj_src = dlvscriptsObj[dlvi].src;
	if(dlvscriptsObj_src.indexOf("linkverifierhelper") != -1) {
		dlvDomain =  dlvscriptsObj_src.split('/public')[0]; 
        break; 
	}
}

var dlvth = document.getElementsByTagName('body')[0];
var dlvs = document.createElement('script');
dlvs.setAttribute('type','text/javascript');
dlvs.setAttribute('src',dlvDomain+'/public/linkverifierhelper2.js');
dlvth.appendChild(dlvs);

//Find IE version
var dlvver = -1; // value assumes failure.
if (navigator.appName == 'Microsoft Internet Explorer') {
	var dlvua = navigator.userAgent;
	var dlvre  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
	if (dlvre.exec(dlvua) != null)
	dlvver = parseFloat( RegExp.$1 );
}
			
function showdaplvsettings(num) 
{
	if(dlvobjS.style.display == "" || dlvobjS.style.display == "none") {
		dlvobjS.style.display = 'block';
		dlvobjM.innerHTML = 'Less &#9650;';
	} else {
		dlvobjS.style.display = 'none';
		dlvobjM.innerHTML = 'More &#9660;';
	}
}
function httpGet(theUrl,refresh,num)
{
	var i = document.createElement("img");
	var d = new Date();
	i.src = theUrl + "/dlv_unique/" + d.getTime();
	if(refresh == 1)
	{
		location.reload(true);
	} else
	{
	dlvDwlQ(num)
	}
}
function dlvDwlQ(num) {
	dlvobjIcon = document.getElementById("dlvicon"+num);
	dlvobjIcon.style.background = "url("+dlvDomain+"/public/dap_validlink_queued.png)";
}
function refresh()
{
	location.reload(true);
}      
function showDAPLV(num,bshowsettings,isWelcome)
{ 
	if (isWelcome != true) isWelcome = false;
	if (_dlvdivContext.style.display != "block") {
		dlvobjM = document.getElementById("daplvmore"+num);
		dlvobjPop = document.getElementById("daplvinfopopup"+num);
		dlvobjIcon = document.getElementById("dlvicon"+num);
		dlvobjIcon2 = document.getElementById("dlvicon"+num);
		dlvobjS = document.getElementById("dapversettings"+num);

		//if icon status is not pending
		if(dlvobjIcon.className.indexOf("Pending") == -1 && bshowsettings == true) 
		{			
			dlvisLeft="left";
			
			// if invalid, hide download button
			if(dlvobjIcon.className.indexOf("Invalid") != -1) 
				document.getElementById("daplvDWL"+num).style.visibility = "hidden";

			// width of icon
			dlviw = dlvobjIcon.offsetWidth;
				
			// position of icon from top and left of document
			for (var dlvix=0, dlviy=0; dlvobjIcon != null; dlvix += dlvobjIcon.offsetLeft, dlviy += dlvobjIcon.offsetTop, dlvobjIcon = dlvobjIcon.offsetParent); 
		
			//width and height of popup div
			var dlvgh=0;
			var dlvgw=0;
			dlvobjPop.style.display = "inline";
			dlvobjPop.style.visibility = "hidden";
			dlvgh = dlvobjPop.offsetHeight;
			dlvgw = dlvobjPop.offsetWidth;
			var tempIcon = dlvobjIcon2, tempIcon2 = dlvobjIcon2;
							
			if((dlvOverflowPos>"0" && dlvRelativePos>"0") && (dlvOverflowPos>=dlvRelativePos) && (tempIcon.parentNode.clientWidth<dlvgw || tempIcon.parentNode.clientHeight<dlvgh)) { // if parent has overflow hidden style + width and height of popup div is bigger than width of parent div
				dlvposRelative = "1";
			}
			
			// calculates X and Y scrolls
			if (self.pageYOffset) {dlvyScroll = self.pageYOffset;} else if (document.documentElement && document.documentElement.clientTop) {dlvyScroll = document.documentElement.clientTop;} else if (document.body) {/* all other Explorers*/ dlvyScroll = document.body.clientTop;}
			if (self.pageXOffset) {dlvxScroll = self.pageXOffset;} else if (document.documentElement && document.documentElement.clientLeft) {dlvxScroll = document.documentElement.clientLeft;} else if (document.body) {/* all other Explorers*/ dlvxScroll = document.body.clientLeft;}
			
			try{
				if((dlvobjIcon2.parentNode.parentNode.currentStyle.overflow == "scroll" || dlvobjIcon2.parentNode.parentNode.currentStyle.overflow ==  "auto") &&  dlvobjIcon2.parentNode.parentNode.nodeName != "BODY")
					dlvscrollAdd=dlvobjIcon2.parentNode.parentNode.scrollTop;
				else
					dlvscrollAdd=0;
			}         
			 catch (e) {
				dlvscrollAdd=0;
			}
			if ( dlvver > -1 ) { // if IE
				if ( dlvver > 8.0 ) { // if IE>8
					for(var i=0; i<=15; i++) { // check 10 levels of parents
						if(tempIcon.nodeName.toLowerCase() != "body") { // only check if parent is not body
							if(tempIcon.parentNode.currentStyle.position == "relative") dlvRelativePos = i;
							if(tempIcon.parentNode.currentStyle.overflow == "hidden") {
								dlvOverflowPos = i;
								if(dlvRelativePos != "0") break;
							} else {
								tempIcon = tempIcon.parentNode;
							}
						}
					}
				}	
			}	

			for (var dlvi = 0; dlvi <= 15; dlvi++) { // check 10 levels of parents
				if (tempIcon2.nodeName.toLowerCase() != "body") { // only check if parent is not body
					if(window.getComputedStyle) 
						dlvPopDir = window.getComputedStyle(tempIcon2.parentNode, null);
					 else 
						dlvPopDir = tempIcon2.parentNode.currentStyle;

				
					if (dlvPopDir.direction == "rtl") {
						dlvpageDir = "rtl";
						break;
					} else {
						tempIcon2 = tempIcon2.parentNode;
					}
				}
			}	

			try
			{
				if ( dlvver == -1 )  // if not IE
					document.getElementById("daplv_disable"+num).style.visibility = "hidden";
			}catch(e){}


			// x axes - decide to which side the popup should open
			if((dlvix+dlvgw)>(dlvxScroll+dlvx)) {
				dlvpopupLeftPos = -dlvgw-dlviw;
				if(dlvpageDir == "rtl") dlvpopupLeftPos = -dlvgw
				dlvisLeft="right";
				if (dlvobjPop.className.indexOf("ex") == -1)
				    dlvobjPop.className = 'daplvinfo-rtl';
				else 
				    dlvobjPop.className = 'exdaplvinfo-rtl';
			} else {
				dlvpopupLeftPos = 0;
				if(dlvpageDir == "rtl") dlvpopupLeftPos += dlviw;
				dlvisLeft="left";
				if (dlvobjPop.className.indexOf("ex") == -1)
				    dlvobjPop.className = "daplvinfo";
				else
				    dlvobjPop.className = "exdaplvinfo";
			}
		
			 if ((dlviy + dlvgh + 80) > (dlvyScroll + dlvy)) {
                if (isWelcome == true) {
                    dlvpopupTopPos = -(dlvgh / 2) + 25;
                    dlvobjPop.style.backgroundPosition = dlvisLeft + ' ' + (dlvgh/2-20) + 'px';
                } else {
                    dlvpopupTopPos = -dlvgh + 25;
                    //dlvobjPop.style.backgroundPosition = dlvisLeft + ' 115px';
					dlvobjPop.style.backgroundPosition = dlvisLeft + ' ' + (dlvgh - 30) + 'px';
                }
            } else {
                //if (isWelcome == true) {
                //    dlvpopupTopPos = dlvgh / 2;
                //} else {
                    dlvpopupTopPos = 0;
                //}
                
                dlvobjPop.style.backgroundPosition = dlvisLeft + ' 0px';
			}
			if(dlvposRelative != "1") {
				dlvobjPop.style.left = dlvpopupLeftPos+"px";
				dlvobjPop.style.top = (dlvpopupTopPos-dlvscrollAdd)+"px";
				dlvobjPop.style.zIndex = dlvzIndex+1;
				dlvobjPop.style.visibility = "visible";
				dlvobjPop.style.display = "block";
			}
			dlvobjIcon2.removeAttribute("title");
		}
	 else {
			dlvobjIcon2.setAttribute("title","DAP Link Checker is analyzing the link...");
		}
	}
}
function hideDAPLV(evt)
{
	dlvobjPop.style.display = "none";
}
function dlvdoprocess(e) { 
    e.stopPropagation && e.stopPropagation() || (e.cancelBubble = true); 
    return false;
}

function shortenString(url){
  var shortUrl, tmp;
  shortUrl = url;
  if (url.length > 50) {
    tmp = url.substr(0, 30 - 0);
    shortUrl = tmp;
    shortUrl += '....';
    tmp = url.substr(url.length - 16);
    shortUrl += tmp;
  }
  return shortUrl;
}

var dlvcurFile = 0;
var dlvMultiI;
function multiFiles(dir,num,numFiles, numFields, filesStr) {
	var j;
	if (dlvcurFile == 0) dlvMultiI = 0;
	var file = filesStr.split(",");

	if (dir == "next") {
			   if (dlvMultiI < numFiles - 1) { dlvMultiI = dlvMultiI + 1; }
			   else { dlvMultiI = 0; }
		 } else if (dir == "prev") {
			   if (dlvMultiI > 0) { dlvMultiI = dlvMultiI - 1; }
			   else { dlvMultiI = numFiles - 1; }
		 }

		 document.getElementById('dlv-currentfile' + num).innerHTML = dlvMultiI + 1;
		 for (j = 0; j < numFields-1; j++) {
			   document.getElementById('dlv-file' + j + num).innerHTML = shortenString(file[numFields * dlvMultiI + j]);
		 }
		 dlvcurFile = dlvMultiI;

		 var dlvDWLURL = dlvDomain + "/sign/" + file[numFields * dlvMultiI + 4] + "/add%2Flinkonly%2F" + encodeURIComponent(file[numFields * dlvMultiI + 2]) + "/caller/DLV/";
		 document.getElementById("daplvDWL" + num).innerHTML = '<a href="javascript: void(0);" onclick="httpGet(\'' + dlvDWLURL + '\',0,' + num + ');"><img src="' + dlvDomain + '/public/btn-download.png" alt="Download" /></a>';
  }


