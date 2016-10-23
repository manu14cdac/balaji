// setup the namespace
if (typeof onepica == 'undefined' || !onepica) {
    var onepica = {};
}

function findPos(obj) {
    //find coordinates of a DIV
    var curleft = curtop = 0;
    if ((typeof(obj) != "undefined") && (obj.offsetParent)) {
        curleft = obj.offsetLeft
        curtop = obj.offsetTop
        while (obj = obj.offsetParent) {
            curleft += obj.offsetLeft
            curtop += obj.offsetTop
        }
    }
    return [curleft, curtop];
}

var screenManager;
function initScreenManager() {
	/*
	 * Unregisters a Varien listener, which monitors when Ajax requests are sent out.
	 * See Crumbs ticket #129.
	 */
	Ajax.Responders.unregister(Varien.GlobalHandlers);

	screenManager = new onepica.ScreenManager();
	/**
	 * Our custom event alerting that the screenManager is available.
	 * You can monitor for this event with: document.observe('onepica:load', callback);
	 */
	document.fire('onepica:load');
}




Event.observe(window, 'load', initScreenManager);

