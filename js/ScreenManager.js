onepica.ScreenManager=Class.create({initialize:function(){this.initMessage();this.initCart();},initMessage:function(){this.message=new onepica.Message("message-container");},getMessage:function(){return this.message;},initCart:function(){this.cart=new onepica.Cart();},getCart:function(){return this.cart;},trackEvent:function(category,action,label,value){if(typeof(pageTracker)!="undefined"){try{var success=pageTracker._trackEvent(category,action,label,value);}catch(e){}}},trackPageview:function(pageUrl){if(typeof pageTracker!="undefined"){var host=window.location.protocol+"//"+window.location.host;if(pageUrl&&pageUrl.length>host.length&&pageUrl.substr(0,host.length)==host){pageUrl=pageUrl.substr(host.length+1);}try{pageTracker._trackPageview(pageUrl);}catch(e){}}}});