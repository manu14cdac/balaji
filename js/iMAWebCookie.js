
/*
 * CONFIDENTIAL AND PROPRIETARY
 * Copyright 2010 Silverpop Systems, Inc.  All rights reserved.
 * The contents of this material are confidential and proprietary to
 * Silverpop Systems, Inc. Unauthorized use, disclosure, or reproduction
 * is strictly prohibited.
 */

(function() {
    var version = 1.17,
            page = {},
            cookiespace = 'com.silverpop.iMA',
            vtrendzCookieSpace = 'com.vtrenz.iMA',
            metaspace = 'com.silverpop.',
            webTrackingOptInPrefix = 'webtrackingoptin',
            pageVisitCookie = '.page_visit',
            websyncTTL = 1000  * 24 * 60 * 60 * 1000, /*1000 days*/
            sessionTTL = 20 * 60 * 1000, /*20 minutes*/
            clickStreamKeys = ["spMailingID", "spUserID", "spJobID", "spReportId"],
            clickStreamCookieNames = ["MID", "UID", "JID","RID"],
            api = {path:'/WTS/'},
            cachedSession,
            checkForAcceptsCookieCookie = false,
            d = document,
            l = location,
            n = navigator,
            w = window,
            onloadcallstack = [];

    w.ewt = w.ewt || {
        track : function() {
            var args = arguments[0];
            return ewt.trackEvent(args);
        },

        trackLink : function() {
            var args = arguments[0];
            if (args.link) {
                var link = args.link;
                 if (isTargetNonBlank(link)) {
                    args.onCompleteFunction = function() {
                        document.location = args.link.href;
                    };
                }
                else {
                    ewt.trackEvent(args);
                    return true;
                }
            }
            return ewt.trackEvent(args);
        },

        trackFormSubmit : function() {
            var args = arguments[0];
            if (args.form) {
                args.onCompleteFunction = function() {
                    args.form.submit();
                };
            }
            return ewt.trackEvent(args);
        },

        trackEvent : function() {
            var args = arguments[0];

            if (!trackingEnabled()) {
                return true;
            }

            var trackedSession = session(false);
            if (trackedSession.isNew) {
                pageview(trackedSession);
                trackedSession.isNew = false;
                trackedSession.newSiteVisit = false;
            }

            http(endpoint() + $tx({
                session : trackedSession,
                eventName:args.name || 'n/a'
            }, args.type));

            if (args.onCompleteFunction instanceof Function) {
                setTimeout(args.onCompleteFunction, 700);
            }
            return false;
        },

        cot : function() {
            if (!page.args) {
                page.args = pageargs();
                setClickStreamParamsCookies();
            }

            var mailingId = getClickStreamValue(0);
            var userId = getClickStreamValue(1);
            var jobId = getClickStreamValue(2);
            if (mailingId != '' && userId != '' && jobId != '') {
                if (!page.metas) {
                    page.metas = metatags();
                }

                var cothost = null;
                if ((cothost = page.metas['com.silverpop.cothost'])) {
                    var args = '';
                    if (arguments[0].action && arguments[0].action.length > 0)
                        args = '&a=' + encodeURIComponent(arguments[0].action);
                    if (arguments[0].detail && arguments[0].detail.length > 0)
                        args += '&d=' + encodeURIComponent(arguments[0].detail);
                    if (arguments[0].amount && arguments[0].amount.length > 0)
                        args += '&amt=' + encodeURIComponent(arguments[0].amount);
                    http(endpointCot(cothost, mailingId, userId, jobId, args));
                }
            }
        },

        cotLink : function() {
            if (!page.args) {
                page.args = pageargs();
                setClickStreamParamsCookies();
            }

            var mailingId = getClickStreamValue(0);
            var userId = getClickStreamValue(1);
            var jobId = getClickStreamValue(2);
            if (mailingId != '' && userId != '' && jobId != '') {
                if (!page.metas) {
                    page.metas = metatags();
                }

                var cothost = null;
                if ((cothost = page.metas['com.silverpop.cothost'])) {
                    var args = '';
                    if (arguments[0].action && arguments[0].action.length > 0)
                        args = '&a=' + encodeURIComponent(arguments[0].action);
                    if (arguments[0].detail && arguments[0].detail.length > 0)
                        args += '&d=' + encodeURIComponent(arguments[0].detail);
                    if (arguments[0].amount && arguments[0].amount.length > 0)
                        args += '&amt=' + encodeURIComponent(arguments[0].amount);

                    var link = arguments[0].link;
                    if (isTargetNonBlank(link)) {
                        // keep track if we've followed the link
                        // workaround to prevent certain browsers (safari, opera) from following link again on "Back"
                        var followUrlFunc = function() {
                            document.location = link.href;
                        };

                        // Track link click event. On completion, follow link url.
                        http(endpointCot(cothost, mailingId, userId, jobId, args));

                        // If the onCompleteFunction above doesn't fire within X milliseconds, follow link url
                        setTimeout(followUrlFunc, 700);

                        return false;
                    } else {
                        http(endpointCot(cothost, mailingId, userId, jobId, args));
                        return true;
                    }
                }
            }
        },

        setIFrameSrc: function(control, url) {
            var metas = null;
            if (!page || !page.metas) {
                metas = metatags();
            }

            if (!trackingEnabled() && control.src.indexOf(url) == -1) {
                var params = checkForAcceptsCookieCookie ? "spWebTrackingOptIn=0" : "";
                control.src =  getUrlWithParams(url, params);
            } else if (control.src.indexOf(url) == -1) {
                if (!page.args) {
                    page.args = pageargs();
                    setClickStreamParamsCookies();
                }

                if (!page.metas) {
                    page.metas = metas;
                }

                if (!page.websync) {
                    websyncBridge();
                    page.websync = websync();
                    cachedSession = session(true);
                }

                var params = getCookieParams(page);
                if (checkForAcceptsCookieCookie) {
                    params += "&spWebTrackingOptIn=1";
                }
                control.src = getUrlWithParams(url, params);
            }
        },

        getVisitorKey: function() {
            return page.websync.uid;
        },

        unitTest: function() {
            var functions = {};
            functions.getFormActionHostName = getFormActionHostName;
            functions.getFormActionResourceUri = getFormActionResourceUri;
            functions.getFormActionResourceName = getFormActionResourceName;
            functions.isTargetNonBlank = isTargetNonBlank;
            functions.isUrlStartsWith =  isUrlStartsWith;
            functions.isUrlStartsWithBrandDomainScheme = isUrlStartsWithBrandDomainScheme;
            functions.isBrandedDomain = isBrandedDomain;
            functions.isFirstPageVisit = isFirstPageVisit;
            functions.recordPageVisit = recordPageVisit;
            functions.containsPage = containsPage;
            functions.addPage = addPage;
            functions.hashString = hashString;
            return functions;
        }
    };

    function pageview(existingSession) {
        var metas = metatags();
        if (!trackingEnabled()) {
            createReferrerCookieIfDoesNotExist();
            return false;
        }

        websyncBridge();
        page.args = pageargs();
        page.metas = metas;
        page.websync = websync();
        page.pageName = pagename();
        var trackedSession = (existingSession) ? existingSession : ((cachedSession) ? cachedSession : session(true));
        var newPageVisit = isFirstPageVisit();
        recordPageVisit();

        http(endpoint() + $tx({
            session : trackedSession,
            webSync : page.websync,
            newPageVisit : newPageVisit
        },'pageview'));

        //make sure that the action tag uses a domain that is part of the branded domains listed in the meta tag
        var tags = document.getElementsByTagName("FORM");
        for (var i = 0; i < tags.length; i++) {
            var url = tags[i].action;
            var pageId = tags[i].getAttribute('pageId');
            var siteId = tags[i].getAttribute('siteId');
            var parentPageId = tags[i].getAttribute('parentPageId');

            if (isBrandedDomain(url, getBrandedDomains()) && pageId && siteId) {
                var hostName = getFormActionHostName(url);
                var resourceUri = getFormActionResourceUri(url);
                var resourceName = getFormActionResourceName(url);
                trackedSession.isNew = false;
                http(endpoint() + $tx({
                    session : trackedSession,
                    webSync : page.websync,
                    pageId : pageId,
                    siteId : siteId,
                    parentPageId : parentPageId,
                    hostname : hostName,
                    pathname : resourceUri,
                    pagename : resourceName,
                    trackedExternalFormPost : '1',
                    newPageVisit : newPageVisit
                },'pageview'));
            }
        }

        return trackedSession;
    }

    function trackingEnabled() {
        return (cookiesEnabled() && permissionToTrack());
    }

    function permissionToTrack() {
        if (!checkForAcceptsCookieCookie)
            return true;

        var cookie = readCookie(".accept_cookies");
        if (cookie == "true")
            return true;

        return false;
    }

    function createReferrerCookieIfDoesNotExist() {
        if (!checkForAcceptsCookieCookie)
            return;

        var referrer = readCookie(".referrer");
        if (d.referrer != null && referrer == '') {
            var cookie = {
                uid:encodeURIComponent(d.referrer),
                ttl:sessionTTL,
                name:cookiespace + '.referrer'
            };

            createCookie(cookie);
        }
    }

    function getReferrer(isNewSession) {
        if (!checkForAcceptsCookieCookie || !isNewSession)
            return d.referrer;

        var referrer = readCookie(".referrer");
        if (referrer != null) {
            deleteCookie(cookiespace + ".referrer");
            return decodeURIComponent(referrer);
        }

        return d.referrer;
    }

    function endpoint() {
        return port() + host() + api.path + 'event.jpeg?accesskey=' + pagekey() + '&v=' + version;
    }

    function endpointCot(host, m, r, j, args) {
        return port() + host + '/cot?m=' + m + '&r=' + r + '&j=' + j + args;
    }

    function port() {
        return (l.protocol && l.protocol.toString().toLowerCase() == 'https:') ? 'https://' : 'http://';
    }

     function isTargetNonBlank(link) {
        return link.target === ''
            || link.target.toLowerCase() === '_self'
            || link.target.toLowerCase() === '_top'
            || link.target.toLowerCase() === '_parent';
    }

    function host() {
        if (!w.ewt_host) {
            var js = d.getElementsByTagName('script');
            for (var i = 0; i < js.length; i++) {
                if ((js[i].src) && js[i].src.match(/iMAWebCookie\.js(\?.*)$/i) && js[i].src.toLowerCase().indexOf("lp/static/js") != -1) {
                    w.ewt_host = js[i].src.split('&')[1].substr(2);
                    break;
                }
            }
        }

        return w.ewt_host;
    }

    function addLoadEvent(initWebTracking) {
        if (w.addEventListener)
            w.addEventListener("load", initWebTracking, false);
        else if (w.attachEvent)
            w.attachEvent("onload", initWebTracking);
        else { // fallback
            var old = w.onload;
            w.onload = function() {
                if (old) old();
                initWebTracking();
            };
        }
    }

    function $tx(tx, type) {
        var _tx = {},
                query = (tx.session.isNew ? '&isNewSession=1' : '&isNewSession=0')+'&type='+type,
                isNewVisitor = (tx.webSync) ? (tx.webSync.isNew ? '1' : '0') : '';

        _tx.isNewVisitor = isNewVisitor;
        _tx.eventName = tx.eventName || '';
        _tx.sessionGUID = tx.session.uid;
        _tx.webSyncID = page.websync.uid;
        _tx.associatedWebSyncID = page.websync.associatedUID;
        _tx.url = d.URL;
        _tx.newSiteVisit = tx.session.newSiteVisit ? '1' : '0';
        _tx.referringURL = getReferrer(tx.session.newSiteVisit); //(d.referrer!='') ? d.referrer : 'n/a';
        _tx.gclid = page.args['gclid'] || '';
        _tx.hostname = (tx.hostname) ? tx.hostname : l.hostname;
        _tx.pathname = (tx.pathname) ? tx.pathname : l.pathname;
        _tx.pagename = (tx.pagename) ? tx.pagename : page.pageName;
        _tx.pageId = tx.pageId;
        _tx.siteId = tx.siteId;
        _tx.parentPageId = tx.parentPageId || '';
        _tx.gwkey = page.args['gwkey'] || '';
        _tx.spMailingID=getClickStreamValue(0) || '';
        _tx.spUserID=getClickStreamValue(1) || '';
        _tx.spJobID=getClickStreamValue(2) || '';
        _tx.spReportId=getClickStreamValue(3) || '';
        _tx.trackedExternalFormPost = tx.trackedExternalFormPost || '';

        _tx.defaultSource = page.args[page.metas['com.silverpop.defaultsourceparam']];
        if (!_tx.defaultSource) {
            _tx.defaultSource = page.metas['com.silverpop.defaultsource'];
        }
        _tx.defaultTerm = page.args[page.metas['com.silverpop.defaulttermparam']];
        if (!_tx.defaultTerm) {
            _tx.defaultTerm = page.metas['com.silverpop.defaultterm'];
        }

        if (type=='pageview') {
            _tx.newPageVisit = (tx.newPageVisit) ? tx.newPageVisit : isFirstPageVisit();
        }

        _tx.eventKey = _guid(); //appending a guid to each request to prevent caching event.jpeg

        query += querystring(_tx);
        return query;
    }

    function querystring(obj, prefix) {
        var q = '', _prefix = prefix ? prefix.toString() + '.' : '';
        for (var key in obj) {
            if (typeof obj[key] == 'string' && obj[key] != '') q += '&' + _prefix + key + '=' + encodeURIComponent(obj[key]);
        }
        return q;
    }

    function createCookie(c) {
        if (cookiesEnabled()) {
            var batter = c.name + "=" + c.uid + _ttl(c.ttl) +"; path=/";
            d.cookie = batter;
        }
    }

    function updateCookie(_name, _value, _expiry) {
        if (cookiesEnabled()) {
            var batter = cookiespace + _name + '=' + _value + _ttl(_expiry) +'; path=/';
            d.cookie = batter;
        }
    }

    function readCookie(_name, nonDefaultCookieSpace) {
        var cookies = d.cookie ? d.cookie.split('; ') : [];
        var cookiename = (nonDefaultCookieSpace ? nonDefaultCookieSpace : cookiespace) + _name;
        for (var i = 0; i < cookies.length; i++) {
            if (cookies[i].indexOf(cookiename) == 0) return cookies[i].split('=')[1];
        }
        return '';
    }

    function deleteCookie(_name) {
        var batter = {name:_name,uid:'',ttl:-1};
        createCookie(batter);
    }

    function _guid() {
        var g = '';//this.isNew=1;
        for (var i = 0; i < 32; i++) {
            g += Math.floor(Math.random() * 0xF).toString(0xF) + (i == 7 || i == 11 || i == 15 || i == 19 ? "-" : "")
        }
        return g;
    }

    function _ttl(ttl) {
        if (ttl) {
            var date = new Date();
            date.setTime(date.getTime() + (ttl));
            return "; expires=" + date.toGMTString();
        }
        else {
            return '';
        }
    }

    function http(uri) {
        var b = d.createElement('img');
        b.style.display = 'none';
        d.body.appendChild(b);
        b.src = uri;
    }

    function pagekey() {
        if (!w.ewt_page_key) {
            var js = d.getElementsByTagName('script');
            for (var i = 0; i < js.length; i++) {
                if ((js[i].src) && js[i].src.match(/iMAWebCookie\.js(\?.*)$/i) && js[i].src.toLowerCase().indexOf("lp/static/js") != -1) {
                    var pagekey = js[i].src.split('?')[1];
                    w.ewt_page_key = pagekey.substr(0, pagekey.indexOf('&'));
                    break;
                }
            }
        }

        return (w.ewt_page_key) ? w.ewt_page_key : 'no-key';
    }

    function pageargs() {
        var h, args = {}, q = location.search.substring(1).split('&');
        for (var i = 0; i < q.length; i++) {
            h = q[i].split("=");
            args[h[0].toLowerCase()] = unescape(h[1]);
        }

        return args;
    }

    function pagename() {
        return page.args['vpagename'] || w.ewt_pagename || page.metas[metaspace + 'pagename'] || l.pathname;
    }

    function metatags() {
        var tags = {}, m = d.getElementsByTagName('meta');
        for (var i = 0; i < m.length; i++) {
            tags[m[i].name.toLowerCase()] = m[i].content;
            if (m[i].name.toLowerCase() == (metaspace + webTrackingOptInPrefix)) {
                checkForAcceptsCookieCookie = true;
            }
        }
        return tags;
    }


    function websync() {
        var w = {
            uid:readCookie('WebCookie'),
            ttl:websyncTTL,
            name:cookiespace + 'WebCookie',
            isNew:false,
            associatedUID:''
        };

        // no engage visitor cookie so see if B2B has one
        if (w.uid == '') {
            w.uid = readCookie('WebCookie', vtrendzCookieSpace);
        }

        var webSyncId = page.args['websyncid'];
        if (webSyncId != null) {
            if (w.uid != '')
                w.associatedUID = w.uid;
            w.uid = webSyncId;
        }

        if (w.uid == '') {
            //create websync guid & cookie:
            w.uid = _guid();
            createCookie(w);
            w.isNew = true;
        }
        else {
            //[just] extend cookie expiry:
            updateCookie('WebCookie', w.uid, w.ttl);
        }
        return w;
    }

    function websyncBridge() {
        var oVal = readCookie('WebCookie'), nVal = readCookie('.webSyncID');

        if (oVal != '' && nVal != '')//both exist, delete new
            deleteCookie(cookiespace + '.webSyncID');

        if (oVal == '' && nVal != '') {//only new exists, so rename (via create/delete)
            createCookie({uid:nVal,ttl:websyncTTL,name:cookiespace + 'WebCookie'});
            deleteCookie(cookiespace + '.webSyncID');
        }
    }

    function session(checkReferrer) {
        var s = {
            uid:readCookie('.session'),
            ttl:sessionTTL,
            name:cookiespace + '.session',
            isNew:false,
            newSiteVisit:false
        };

        var sessionId = page.args['sessionguid'];
        if (checkReferrer && (!s.uid || (sessionId && s.uid.toLowerCase() != sessionId.toLowerCase()))) {
            s.newSiteVisit = true;
        }

        if (checkReferrer) {
            createNewSessionIfIdentityChanged(s);
        }

        if (sessionId) {
            s.uid = sessionId;
        }

        if (checkReferrer && s.uid != '' && d.referrer && d.referrer.length > 0) {
            // This is where we need to check flag
            var domains = getBrandedDomains();

            var startIndex = -1;
            var keepExistingSession = false;
            if (domains.length > 0 && (startIndex = d.referrer.indexOf("://")) > -1) {
                var href = d.referrer.toLowerCase();
                for (var i = 0; i < domains.length; i++) {
                    if (href.indexOf(domains[i].toLowerCase()) > 0) {
                        keepExistingSession = true;
                        break;
                    }
                }
            }

            if (!keepExistingSession && !isReferrerAndHostNameSameDomain()) {
                s.uid = '';
            }
        }


        if (s.uid == '') {
            //new session!
            deleteCookie(cookiespace + pageVisitCookie);

            //create session guid & cookie:
            s.uid = _guid();
            createCookie(s);
            s.isNew = true;
            s.newSiteVisit = true;
        }
        else {
            //[just] extend cookie expiry:
            updateCookie('.session', s.uid, s.ttl);
        }

        // We only want to do this on page opens
        if (checkReferrer) {
            setClickStreamParamsCookies();
        }
        return s;
    }

    function isReferrerAndHostNameSameDomain() {
        var start = d.referrer.indexOf("://");
        if (start != -1) {
            var end = d.referrer.indexOf("/", start + 3);
            var refDomain = d.referrer.substring(start + 3, end == -1 ? d.referrer.length : end).toLowerCase();
            refDomain = refDomain.replace("www.", "");
            return l.hostname.toLowerCase().indexOf(refDomain) != -1;
        }

        return false;
    }

    function cookiesEnabled() {
        return n && n.cookieEnabled;
    }

    function isFirstPageVisit() {
        var visitedPages = readCookie(pageVisitCookie, cookiespace);
        if (containsPage(visitedPages, l.pathname)) {
            return "0";
        } else {
            return "1";
        }
    }

    function containsPage(visitedPages, page) {
        var pageId = hashString(page);
        var visitedPageIds = visitedPages.split(',');
        return indexOf(visitedPageIds, pageId) >= 0;
    }

    function hashString(str) {
        var hash = 0;
        if (str.length > 0) {
            for (var i = 0; i < str.length; i++) {
                hash = ((hash << 5) - hash) + str.charCodeAt(i);
                hash = hash & hash; // Convert to 32bit integer
            }
        }
        return hash + "";
    }

    function indexOf(array, item) {
        if (Array.prototype.indexOf) {
            return array.indexOf(item);
        } else {
            for (var i = 0; i < array.length; i++) {
                if (array[i] === item) {
                    return i;
                }
            }
            return -1;
        }
    }

    function recordPageVisit() {
        var visitedPages = readCookie(pageVisitCookie, cookiespace);
        visitedPages = addPage(visitedPages, l.pathname);
        if (visitedPages) {
            var batter = {
                name:cookiespace + pageVisitCookie,
                ttl:sessionTTL,
                uid:visitedPages};
            createCookie(batter);
        }
    }

    function addPage(visitedPages, page) {
        var pageId = hashString(page);
        var visitedPageIds = visitedPages.split(',');
        if (indexOf(visitedPageIds, pageId) == -1) {
            visitedPageIds.unshift(pageId);
            var cookieSizeLimit = 1024;
            return visitedPageIds.toString().substr(0, cookieSizeLimit);
        } else {
            return null;
        }
    }

    function getBrandedDomains() {
        var domainarray = [];
        var brandeddomains = null;
        if ((brandeddomains = page.metas['com.silverpop.brandeddomains'])) {
            domainarray = brandeddomains.split(',')
        }

        return domainarray;
    }

    function appendCookieToLinks() {
        if (!trackingEnabled()) {
            if (checkForAcceptsCookieCookie) {
                if (!page || !page.metas) {
                    page.metas = metatags();
                }
                var brandedDomains = getBrandedDomains();
                appendParamsToFormTags(brandedDomains, "spWebTrackingOptIn=0");
            }
            return false;
        }

        var brandedDomains = getBrandedDomains();
        var params = getCookieParams(page);

        appendParamsToAnchorTags(brandedDomains, params);

        if (checkForAcceptsCookieCookie) {
            params += "&spWebTrackingOptIn=1";
        }
        appendParamsToFormTags(brandedDomains, params);
    }

    function appendParamsToAnchorTags(brandedDomains, params) {
        var tags = document.getElementsByTagName("A");
        for (var i = 0; i < tags.length; i++) {
            var url = tags[i].href;
            if (url.toLowerCase().indexOf("mailto:") != -1 ||
                url.indexOf("#") == 0) {
                continue;
            }

            if (isBrandedDomain(url, brandedDomains)) {
                var innerHTML= tags[i].innerHTML;
                tags[i].href = getUrlWithParams(url, params);
                tags[i].innerHTML=innerHTML;
            }
        }
    }

    function appendParamsToFormTags(brandedDomains, params) {
        var tags = document.getElementsByTagName("FORM");
        for (var i = 0; i < tags.length; i++) {
            var url = tags[i].action;

            if (isBrandedDomain(url, brandedDomains)) {
                tags[i].action = getUrlWithParams(url, params + "&trackedExternalFormPost=1");
            }
        }
    }

    function isUrlStartsWithBrandDomainScheme(url, metaDomain) {
        url = url.toLowerCase();
        metaDomain = metaDomain.toLowerCase();
        var stripMetaDomain = stripMetaDomainWebProtocol(metaDomain);
        var stripUrl = stripUrlPrefixScheme(url);
        return isUrlStartsWith(stripUrl, stripMetaDomain);
    }

     function stripMetaDomainWebProtocol(metaDomain) {
        metaDomain = metaDomain.replace(/^\s+|\s+$/g, "");
        if (metaDomain.indexOf("www.") === 0) {
            metaDomain = metaDomain.substring(metaDomain.indexOf("www.") + 4, metaDomain.length);
        }
        return metaDomain;
    }

    function stripUrlPrefixScheme(url) {
        if (url.indexOf("https://") === 0) {
            url = url.substring(url.indexOf("https://") + 8, url.length);
        }
        if (url.indexOf("http://") === 0) {
            url = url.substring(url.indexOf("http://") + 7, url.length);
        }
        if (url.indexOf("www.") === 0) {
            url = url.substring(url.indexOf("www.") + 4, url.length);
        }
        return url;
    }

    function isUrlStartsWith(url, prefix) {
        return url.indexOf(prefix) === 0;
    }

    function getCurrentHost(protocol) {
        return protocol + l.hostname;
    }

    function getEwtHostFor(protocol) {
        return  protocol + w.ewt_host;
    }

    function isBrandedDomain(url, domainArray) {
        if (!isUrlStartsWith(url, "http://") && !isUrlStartsWith(url, "https://"))
            return false;
        if (isUrlStartsWith(url, getCurrentHost('http://')) || isUrlStartsWith(url, getCurrentHost('https://')))
            return false;
        else if (isUrlStartsWith(url, getEwtHostFor('http://')) || isUrlStartsWith(url, getEwtHostFor('https://')))
            return true;
        else {
            for (var x = 0; x < domainArray.length; x++) {
                if (isUrlStartsWithBrandDomainScheme(url, domainArray[x])) {
                    return true;
                }
            }
            return false;
        }
    }

    function getFormActionHostName(url) {
        var pos = url.indexOf("://");
        if (pos < 0)
            return '';
        else {
            var tempUrl = url.substring(pos + 3);
            var splitArray = tempUrl.split('/');
            return splitArray[0];
        }
    }

    function getFormActionResourceUri(url) {
        var pos = url.indexOf("://");
        if (pos < 0)
            return '';
        else {
            var tempUrl = url.substring(pos + 3);
            pos = tempUrl.indexOf('/');
            tempUrl = tempUrl.substring(pos);//remove host
            return tempUrl;
        }
    }

    function getFormActionResourceName(url) {
        var pos = url.indexOf("://");
        if (pos < 0)
            return '';
        else {
            var splitArray = url.split('/');
            return splitArray[splitArray.length - 1];
        }
    }

    function getUrlWithParams(url, params) {  //

        // start - need to adjust click urls when b2b script is used in conjunction with engage script
        var index = -1;
        var index2 = -1;
        if ((index = url.indexOf('&webSyncID=')) != -1 || (index2 = url.indexOf('?webSyncID=')) != -1) {
            index = (index == -1) ? index2 : index;
            var endIndex = index;
            for (var i = index + 11; i < url.length; i++) {
                if (url.charAt(i) == '&') {
                    endIndex = i;
                    break;
                }
            }
            if (endIndex == index)
                endIndex = url.length;

            url = url.replace(url.substr(index, endIndex - index),"");
            if (index2 != -1) {
                url = url.replace("&", "?");
            }
        }
        // end - need to adjust click urls when b2b script is used in conjunction with engage script

        var poundIndex = url.indexOf("#");
        var preUrl = (poundIndex == -1) ? url : url.substring(0, poundIndex);
        var postUrl = (poundIndex == -1) ? "" : url.substring(poundIndex);
        if (url.indexOf("?") > 0)
            return preUrl + '&' + params + postUrl;
        else
            return preUrl + '?' + params + postUrl;
    }

    function getCookieParams(page) {
        var param = 'webSyncID=' + page.websync.uid + "&sessionGUID=" + session(false).uid;
        var value = null;
        for (var i = 0; i < clickStreamKeys.length; i++) {
            value = readCookie("." + clickStreamCookieNames[i].toLowerCase());
            if (value != '') {
                param += "&" + clickStreamKeys[i] + "=" + value;
            }
        }
        return param;
    }

    function setClickStreamParamsCookies() {
        var value = null;
        for (var i = 0; i < clickStreamKeys.length; i++) {
            if ((value = page.args[clickStreamKeys[i].toLowerCase()]) != null) {
                var clickStreamCookie = {
                    uid: value,
                    name: cookiespace + "." + clickStreamCookieNames[i].toLowerCase()
                };
                createCookie(clickStreamCookie);
            }
        }
    }

    function getClickStreamValue(index) {
        var value = readCookie("." + clickStreamCookieNames[index].toLowerCase());
        if (value) {
            return value;
        }

        value = page.args[clickStreamKeys[index].toLowerCase()]
        if (typeof value  == 'undefined')
            value = '';
        return value;
    }

    function createNewSessionIfIdentityChanged(s) {
        var args = new Array();
        var cookies = new Array();
        for (var i = 0; i < 4; i++) {
            args[i] = page.args[clickStreamKeys[i].toLowerCase()];
            if (typeof args[i] == 'undefined')
                args[i] = '';

            cookies[i] = readCookie("." + clickStreamCookieNames[i].toLowerCase());
        }

        for (i = 0; i < 4; i++) {
            if (args[i].length > 0 && cookies[i].length > 0 && args[i] != cookies[i]) {
                s.uid = '';
                break;
            }
        }
    }

    onloadcallstack.push(pageview);
    onloadcallstack.push(appendCookieToLinks);
    var initWebTracking = function() {
        for (var i = 0; i < onloadcallstack.length; i++) {
            onloadcallstack[i]();
        }
    };

    addLoadEvent(initWebTracking);
})();
