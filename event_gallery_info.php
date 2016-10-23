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
				<?php $eventid = base64_decode($_GET['eventid']);
				
				$sql = mysql_query("SELECT * from event where status = 1 and id= '".$eventid."' ");
				$result = mysql_fetch_assoc($sql);
				?>
				<h1>Event Gallery: <?php echo $result['event_title']?></h1>
				
				<p><a href="<?php echo HOME_URL?>">Home </a> » <a href="<?php echo HOME_URL.'gallery.php'?>">Gallery</a> » <a href="<?php echo HOME_URL.'event_gallery.php?year='.base64_encode(substr($result['start_date'],0,4)); ?>">Event Gallery <?php echo substr($result['start_date'],0,4)?></a> » <?php echo $result['event_title']?></p>
				<div class="row">
				
				<?php 
				$sql2 = mysql_query("SELECT * from event_gallery where status = 1 and event_id= '".$eventid."' and gallery_type='photo' ");
				if(mysql_num_rows($sql2) > 0) {
				while($result2 = mysql_fetch_assoc($sql2)){ ?>
					<div class="col-sm-4">
					<div class="photo-galry">
						<img src="<?php echo HOME_URL.'admin/gallery_images/'.$result2['image']?>"><?php //echo $result['event_title']?>
					</div>
					</div>
				<?php } 
				} else { ?>
				<div class="col-sm-4">
					<div class="photo-galry">
						<p>No gallery Image available</p>
					</div>
					</div>
				
				<?php } ?>
					
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
