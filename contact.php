<?php
include_once('include/front_function.php');
if($_POST['frmaction']!='' && $_POST['frmaction']=='frmsubmit') {
	$name = trim($_POST['name']);
	$mobile = trim($_POST['mobile']);
	$message = trim($_POST['message']);
	$mailsent = '1'; //contactusmail($name, $mobile, $message);	//front_function
	contactusmail($name,$mobile,$message);
	if($mailsent=='1'){
		$xmessage = 'Message sent successfully.';
		//header("Location: contact.php?msg=sent");
	} 
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title>Shivpuri Balaji Dham</title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

<link href='https://fonts.googleapis.com/css?family=Roboto:400,900italic,900,700italic,700,500italic,500,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" media="screen" href="css/fontawesome.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css" />

<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />

<script src="js/jquery-1.11.3.min.js"></script>
<script>



$(document).ready(function()
			  {
			  $(".toparrow").click(function(){
				$(".contentOrder").animate({ height:"72%"}, "slow");
			  });
			  $(".close").click(function(){
				$(".contentOrder").animate({height:"42px"}, "slow");
			  });
			});


//$( ".contentOrder" ).one( "click", function() {
//$( this ).css( "height", "+=800" );
//});

</script>

<script type="text/javascript">
function fun()
{
  var val="";
  var val=document.name.nameindex.value;
  if(val=="0")
  window.location.href = "cstory.php"; 
   if(val=="1")
  window.location.href = "hcstory.php"; 

}
</script>


</head>

<body>
	<!--header -->
<?php include_once('include/header.php') ?>
<!-- wrap starts here -->
<div class="inner-pages">

	
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					
					<div class="lft-sidebar">
<?php
		include("ml.php");	?>
		</div>	
				</div>
				<div class="col-sm-9">
				<div class="row">
				<div class="col-sm-7">
				<div class="c-form">
				<?php if($xmessage != '') {?>
					<p><?php echo $xmessage?></p>
				<?php } ?>
				
					<form class="form-horizontal" name="contactfrm" id="contactfrm" method="post">					
					  <div class="form-group">
						<label class="col-sm-12">Name:</label>
						<div class="col-sm-12"><input type="text" class="form-control" placeholder="your name" required="required" name="name"></div>
					  </div> 			
						
					  <div class="form-group">
						<label class="col-sm-12">Mobile:</label>
						<div class="col-sm-12"><input type="text" class="form-control" placeholder="Mobile no..." required="required" name="mobile"></div>
					  </div> 
						
		              <div class="form-group">
		                 <label class="col-sm-12">Message:</label>
			                <div class="col-sm-12">
				               <textarea class="form-control" placeholder="Leave your message.." rows="4" required="required" name="message"></textarea>
			                </div>
		              </div>
                      <div class="form-group">
						
						<div class="col-sm-12"><input type="submit" class="btn btn-danger" value="Send"></div>
						<input type="hidden" name="frmaction" value="frmsubmit">
					  </div> 
					</form>
				</div>
               </div>
            <div class="col-sm-5">
            	<div class="addrss">
<h4><strong>Address:</strong></h4>
            		<address>
            		    
  <strong>बालाजी धाम</strong><br>
  1234 Example Street<br>
  Antartica, Example 0987<br>
  
</address>
<h4><strong>Contact Person	:</strong></h4>

<address>
  <strong>Ankit Panwar</strong><br>
  <abbr title="Phone">M:</abbr> (123) 456-7890
  <a href="mailto:#">exam.ple@example.com</a>
</address>

            	</div>
            </div>


		     </div>


<div class="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d448182.50738077075!2d77.0932634!3d28.646965499999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1476560564551" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>

</div>

			</div>
		</div>	
	
	<!-- featured ends -->
	</div>	
	
	
		
	
	
	
<!-- wrap ends here -->
</div>



<span class="border-decoration"></span>
<?php include_once('miracle.php'); ?>


<?php include_once('include/footer.php') ?>

<script type="text/javascript">
	//$(document).ready(function(){
// 		$(".contnt-arti").hide();
// $(".jai-arti").click(function(){
// $(".contnt-arti").slideDown();

// })

// 	})

	
	function set_toggle(val)
	{
	//$('.testt-show').click(function(){
		$('.contnt-arti'+val).slideToggle();
		
	}

	

</script>
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function($){
        $(window).on("load",function(){
            $(".arti-txt").mCustomScrollbar({
theme:"minimal-dark",	

            });
        });
    })(jQuery);
</script>
</body>
</html>
