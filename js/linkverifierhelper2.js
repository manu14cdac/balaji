/*function deepCss(a,b){var c,d,e=document.defaultView||window;if(a.nodeType==1){c=b.replace(/\-([a-z])/g,function(a,b){return b.toUpperCase()});d=a.style[c];if(!d){if(a.currentStyle)d=a.currentStyle[c];else if(e.getComputedStyle){d=e.getComputedStyle(a,"").getPropertyValue(b)}}}return d||""}function highZ(a,b){b=b||Infinity;a=a||document.body;var c,d,e=1,f=[],g=0;var h=a.childNodes,i=h.length;while(g<i){c=h[g++];if(c.nodeType!=1)continue;if(deepCss(c,"position")!=="static"){d=deepCss(c,"z-index");if(d=="auto"){d=highZ(c)}else{d=parseInt(d,10)||0}}else{d=highZ(c)}if(d>e&&d<=b)e=d}return e}function dlvContextShow(a){dwdObj=document.getElementById("aDownloadWithDAP");settingsObj=document.getElementById("aSettings");if(_noContext||_mouseOverContext)return;if(a==null)a=window.event;var b=a.target!=null?a.target:a.srcElement;if(_replaceContext){var c=b.id.match(/[\d\.]+/g);var d="daplvDWL"+c;var e=document.getElementById(d).childNodes[0].getAttribute("onclick").toString();var f=e.slice(e.indexOf("'")+1,e.lastIndexOf("'"));if(document.getElementById(b.id).className.toLowerCase()=="daplv-valid"){dwdObj.onclick=function(){httpGet(f,0,c);_divContext.style.display="none"};dwdObj.style.color="#000000"}else{dwdObj.style.color="#a0a0a0"}settingsObj.href=document.getElementById("dlvsettingslink"+c).href;settingsObj.target="_blank";settingsObj.onclick=function(){_divContext.style.display="none"};var g=document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop;var h=document.body.scrollLeft?document.body.scrollLeft:document.documentElement.scrollLeft;hideDAPLV();_divContext.style.display="none";_divContext.style.left=a.clientX+h+"px";_divContext.style.top=a.clientY+g+"px";_divContext.style.display="block";_divContext.style.zIndex=dlvzIndex+2;_replaceContext=false;return false}}function dlvCloseContext(){_mouseOverContext;_divContext.style.display="none"}function dlvMouseDownContext(a){if(_noContext||_mouseOverContext)return;if(a==null)a=window.event;var b=a.target!=null?a.target:a.srcElement;if(a.button==2&&b.id.toLowerCase().indexOf("dlvicon")!=-1){documenvar _replaceContext = false;*/ 	// replace the system context menu?
var _dlvmouseOverContext = false; 	// is the mouse over the context menu?
var _dlvnoContext = false; 			// disable the context menu?

daplvsettingsMR = document.createElement("div");
daplvsettingsMR.setAttribute("id", "dlvdivContext");
daplvsettingsMR.style.border = "1px solid #a0a0a0";
daplvsettingsMR.style.display = "none";
daplvsettingsMR.style.position = "absolute";
daplvsettingsMR.style.backgroundColor = "#f0f0f0";
daplvsettingsMR.style.padding = "4px";
daplvsettingsMR.innerHTML = "<ul class='cmenu'><li><a id='aDownloadWithDAP' href='javascript: void(0)'><img src=\"" + dlvDomain + "/public/dap-logo.png\" alt=\"DAP Link Checker\" class=\"daplvlogo\" /> Download With DAP</a></li><li><a id='aSettings' href='#'>DAP Link Checker Settings</a></li></ul>";
document.body.insertBefore(daplvsettingsMR, document.body.firstChild)
function pageDirFun(el, styleProp) {
    var pageDirx = document.getElementById(el) || document.getElementsByTagName('body')[0] || document.getElementsByTagName('html')[0];
    if (pageDirx.currentStyle)
        dlvpageDir = pageDirx.currentStyle[styleProp];
    else if (window.getComputedStyle)
        dlvpageDir = document.defaultView.getComputedStyle(pageDirx, null).getPropertyValue(styleProp);
}
function dlvMouseRInit() {
    _dlvdivContext = document.getElementById('dlvdivContext');
    _dlvdivContext.onmouseover = function () { _dlvmouseOverContext = true; };
    _dlvdivContext.onmouseout = function () { _dlvmouseOverContext = false; };
    document.body.onmousedown = dlvMouseDownContext;
}
// call from the onMouseDown event, passing the event if standards compliant
function dlvMouseDownContext(event) {
    if (_dlvnoContext || _dlvmouseOverContext) return;
    // IE doesn't pass the event object
    if (event == null) event = window.event;
    // if  IE
    var target = event.target != null ? event.target : event.srcElement;
    // only show the context menu if the right mouse button is pressed and a hyperlink has been clicked
    if (event.button == 2 && target.id.toLowerCase().indexOf('dlvicon') != -1) {
        document.body.oncontextmenu = dlvContextShow;
        _dlvreplaceContext = true;
    }
    else if (!_dlvmouseOverContext)
        _dlvdivContext.style.display = 'none';
}
function dlvCloseContext() {
    _dlvmouseOverContext;
    _dlvdivContext.style.display = 'none';
}
// call from the onContextMenu event, passing the event
// if this function returns false, the browser's context menu will not show up
function dlvContextShow(event) {
    dlvdwdObj = document.getElementById("aDownloadWithDAP");
    dlvsettingsObj = document.getElementById("aSettings");
    if (_dlvnoContext || _dlvmouseOverContext) return;
    // IE doesn't pass the event object
    if (event == null) event = window.event;
    //if IE
    var target = event.target != null ? event.target : event.srcElement;
    //	if (_dlvreplaceContext || posRelative != "undefined")
    if (_dlvreplaceContext) {
        var num = (target.id).match(/[\d\.]+/g);
        var dlvDwlId = "daplvDWL" + num;
        var dlvs = document.getElementById(dlvDwlId).childNodes[0].getAttribute("onclick").toString();
        var dlvDWL = dlvs.slice(dlvs.indexOf("'") + 1, dlvs.lastIndexOf("'"));
        if (document.getElementById(target.id).className.toLowerCase() == 'daplv-valid') {
            dlvdwdObj.onclick = function () { httpGet(dlvDWL, 0, num); _dlvdivContext.style.display = 'none'; }
            dlvdwdObj.style.color = "#000000";
        }
        else {
            dlvdwdObj.style.color = "#a0a0a0";
        }
        dlvsettingsObj.href = document.getElementById("dlvsettingslink" + num).href;
        dlvsettingsObj.target = "_blank";
        dlvsettingsObj.onclick = function () { _dlvdivContext.style.display = 'none'; }
        // document.body.scrollTop does not work in IE
        var scrollTop = document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;
        var scrollLeft = document.body.scrollLeft ? document.body.scrollLeft : document.documentElement.scrollLeft;
        hideDAPLV();
        // hide the menu first to avoid an "up-then-over" visual effect
        _dlvdivContext.style.display = 'none';
        _dlvdivContext.style.left = event.clientX + scrollLeft + 'px';
        _dlvdivContext.style.top = event.clientY + scrollTop + 'px';
        _dlvdivContext.style.display = 'block';
        _dlvdivContext.style.zIndex = dlvzIndex + 2;
        _dlvreplaceContext = false;
        return false;
    }
}
function highZ(parent, limit) {
    limit = limit || Infinity;
    parent = parent || document.body;
    var who, temp, max = 1, A = [], i = 0;
    var children = parent.childNodes, length = children.length;
    while (i < length) {
        who = children[i++];
        if (who.nodeType != 1) continue; // element nodes only 
        if (deepCss(who, "position") !== "static") {
            temp = deepCss(who, "z-index");
            if (temp == "auto") { // z-index is auto, so not a new stacking context 
                temp = highZ(who);
            } else {
                temp = parseInt(temp, 10) || 0;
            }
        } else { // non-positioned element, so not a new stacking context 
            temp = highZ(who);
        }
        if (temp > max && temp <= limit) max = temp;
    }
    return max;
}
function deepCss(who, css) {
    var sty, val, dv = document.defaultView || window;
    if (who.nodeType == 1) {
        sty = css.replace(/\-([a-z])/g, function (a, b) {
            return b.toUpperCase();
        });
        val = who.style[sty];
        if (!val) {
            if (who.currentStyle) val = who.currentStyle[sty];
            else if (dv.getComputedStyle) {
                val = dv.getComputedStyle(who, "").getPropertyValue(css);
            }
        }
    }
    return val || "";
}
function find_dlv_id()
{
    var exdlvId = document.getElementsByTagName("div");
    for (var i = 0; i < exdlvId.length; i++) {
	    if (exdlvId[i].className.indexOf("exdaplvinfo") != -1) {
            var shouldrun = true;
            break;
        }
	}
	 if (shouldrun == true) {
	  DlcIdNum = exdlvId[i].id.split("popup");
        showDAPLV(DlcIdNum[1], true, true)
    }
	
	//var dlvId = document.getElementsByTagName("span");
	//for (var i = 0; i < dlvId.length; i++) {
    //    if (dlvId[i].id.indexOf("dlvicon") != -1 && shouldrun ==  true) {
    //       var targetId = dlvId[i].id;
    //        break;
    //    }
    //}
    //if (targetId != undefined) {
    //    DlcIdNum = targetId.split("dlvicon");
    //    showDAPLV(DlcIdNum[1], true)
   // }
   
   
}

pageDirFun(null, 'direction');
dlvzIndex = highZ();
dlvMouseRInit();
setTimeout("find_dlv_id();",3000);

