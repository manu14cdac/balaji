<?php
include_once("include/dbconfig.php");
// echo md5('12345678')
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
<?php include_once('include/header.php'); ?>
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
				
				<?php $year = base64_decode($_GET['year']);?>
				<h1>Event Gallery <?php echo $year?></h1>
				<p><a href="<?php echo HOME_URL?>">Home </a>» <a href="<?php echo HOME_URL.'gallery.php'?>">Gallery</a> » Event Gallery <?php echo $year?></p>
				<div class="row">
				<?php
					
					$sql = mysql_query("SELECT id, event_title from event where status = 1 and start_date like '".$year."%' ");
					while($result = mysql_fetch_assoc($sql)) {
				?>
				
					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="<?php echo HOME_URL.'event_gallery_info.php?eventid='.base64_encode($result['id']); ?>"><img src="img/demo-pic.jpg"><?php echo $result['event_title']?></a>
					</div>
					</div>
					<?php }  ?>
					
					
					<!--
					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="#"><img src="img/demo-pic.jpg"></a>
					</div>
					</div>

					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="#"><img src="img/demo-pic.jpg"></a>
					</div>
					</div>

					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="#"><img src="img/demo-pic.jpg"></a>
					</div>
					</div>

					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="#"><img src="img/demo-pic.jpg"></a>
					</div>
					</div>

					<div class="col-sm-4">
					<div class="photo-galry">
						<a href="#"><img src="img/demo-pic.jpg"></a>
					</div>
					</div>-->

				</div>
				
				

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
