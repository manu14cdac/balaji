	

function user_login() {

	//var  base_url =  window.location.protocol +'//' + window.location.host;

	var base_url = window.location.origin;

    var pathArray = window.location.pathname.split( '/' );

    var base = base_url+'/'+pathArray[1]+'/'+pathArray[2];

    //var base = $('#base_url').val();
	
    
	  var username = $('#username').val().trim();
      var pass = $('#pass').val().trim();

      if(username=='' || pass=='')
      {
      	alert("Please Enter Username and Password");
      	return false;
      } 

     var data =  $('#login_form').serialize();

     $.ajax({
                   url:  "include/login.php",
                   type: 'POST',
                   data: data,
                   success: function(res){
                       console.log(res);
                       if(res=='true')
                       {
                        window.location = base+"/dashboard.php";
                       }
                       else
                       {
                       	alert("Invalid Username And Password");
                       }
                   },
                   error: function(){
                   alert("Error");
                    }
                });

		return false;
	}	
