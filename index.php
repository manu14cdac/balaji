<?php

include_once('include/front_function.php');

$home_menu = get_home_menu();

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
<link rel="stylesheet" type="text/css" media="screen" href="css/reset.css" />


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
  window.location.href = "index.php"; 
   if(val=="1")
  window.location.href = "indexhindi.php"; 

}
</script>

<script type="text/javascript" src="js/jquery.quovolver.js"></script>
	
	<!-- JavaScript Test Zone -->




</head>

<body>
<!-- Header -->
<?php include_once('include/header.php') ?>

<section class="main-section">
<div id="wrap" class="container">

	<!--header -->

	
	<!-- featured starts -->	
			
		<div class="row">
		<?php
		for($k=0;$k<4;$k++)
		{
			?>

			<div class="col-sm-3">
			           <div class="comanBox">
			
		<a href="<?php echo $home_menu[$k]['url'] ?>"><img src="<?php echo HOME_URL.'admin/home_images/'.$home_menu[$k]['image'] ?>" alt="" />
			<span><?php echo $home_menu[$k]['name'] ?></span></a>
		
				
			</div>
			</div>

			<?php

		}
		?>
		
		
					
			</div>
			<div class="row">

					<div class="col-sm-3">

		<!-- 	<div class="comanBox">
				<a href="currentsocial.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Social Workers</span></a>
			</div>
			<div class="comanBox">
				<a href="exsocial.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Past Social Workers</span></a>
			</div>
			<div class="comanBox">
				<a href="events.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Gallery</span></a>
			</div> -->

			<?php
		for($k=4;$k<7;$k++)
		{
			?>

			
			           <div class="comanBox">
			
		<a href="<?php echo $home_menu[$k]['url'] ?>"><img src="<?php echo HOME_URL.'admin/home_images/'.$home_menu[$k]['image'] ?>" alt="" />
			<span><?php echo $home_menu[$k]['name'] ?></span></a>
		
				
			</div>
			<?php

		}
		?>
			 
			
			
			
			
		</div>

					<div class="col-sm-6">
		<div class="midPanel">
			<img src="images/main-hanuman.png" alt="" class="middle-imgg">
			
			
		</div>

		<div class="contentOrder">
					<a href="#" class="toparrow">Program list Click Here</a>
					<a href="index.php" class="close"></a>
					<div class="clear"></div>
					<div class="blockCt">
					<h3><center> Latest Event </center></h3><hr>
					<?php
						$sql=mysql_query("Select ename,eimage,edate,edescription from event where estatus='1' && type='1' && lang='1'");
						
			

while($result=mysql_fetch_array($sql)){
//echo '<pre>';
//print_r($result);
//print_r($result['image']);
//exit;
$image =$result['eimage'];
$name =$result['ename'];
$date=$result['edate'];
$description=$result['edescription'];

//print_r($Uploadmarriage.$image);
//exit;
//$date = $result['dateofevent'];


//$Image = mysql_result($result,$i,'image');

//echo $Image;
//echo $Uploadgallerys.$image;
?>

<br>

					
					<dl class="folio">
					
						
						<dd>
							<ul id="gallery" class="nobullet">
					                                                 <div class="cols marg_right1">
							
							<li><a href="<?=$Uploadevents.$image;?>" rel="lightbox[portfolio]"  width="300"  height="250"><img class="img_border" src="<?=$Uploadevents.$image;?>" alt="Image 1" width="260" height="200"/></a></li>
							<p class="pad_bot2"><span class="color2"><font color=red>Name &nbsp;:-&nbsp;&nbsp;</font><?=$name;?></span> <span class="color1"><?=$post;?></span></p><br>
							<p class="pad_bot2"><span class="color2"><font color=red>Date of Event &nbsp;:-&nbsp;&nbsp;</font><?=$date;?></span> <span class="color1"><?=$post;?></span></p><br>
							<p class="pad_bot2"><span class="color2"><font color=red>Description &nbsp;:-&nbsp;&nbsp;</font><?=$description;?></span> <span class="color1"><?=$post;?></span>
							</p>
							<hr><br>
									
			</div>
								
							</ul>
							
						</dd>
					</dl>
					<?php
					$i++;

  }
  ?>
					</div>
					
				</div>
		</div>
		

					<!-- <div class="col-sm-3">
		<div class="	">
		
		 <div class="comanBox">
		 
		<a href="login.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Information of all Family</span></a>
			
				
			</div>
		
			<div class="comanBox">
				<a href="search.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Metromonial</span></a>
			</div>
			<div class="comanBox">
				<a href="add.php"><img src="img/demo-pic.jpg" alt="" />
				<span>Advertisement</span></a>
			</div>
			
			
			
		</div>
		</div>
		</div> -->
		<div class="col-sm-3">
		<?php
		for($k=7;$k<10;$k++)
		{
			?>

			
			           <div class="comanBox">
			
		<a href="<?php echo $home_menu[$k]['url'] ?>"><img src="<?php echo HOME_URL.'admin/home_images/'.$home_menu[$k]['image'] ?>" alt="" />
			<span><?php echo $home_menu[$k]['name'] ?></span></a>
		
				
			</div>
			<?php

		}
		?>

		</div>

		<div class="clear"></div>		
		
			
			
			
	
	<!-- featured ends -->
	
	
	
	
	
	<!-- footer-bottom starts -->	
    
    
    
    
    
    
    
    
    
    
    
    	
	<!--<div id="footer-bottom">
		<p>
			Please share your knowledge.
			</p>
	</div>-->
	
<!-- wrap ends here -->
</div>
</section>

<span class="border-decoration"></span>
<?php 
include_once('miracle.php');
?>



<?php
include_once('include/footer.php') ?>
<!-- <link href="css/jquery-sakura.css" rel="stylesheet" type="text/css">
<script src="js/flower-effect/jquery-sakura.js"></script> -->
<script>

// $(window).load(function () {
//     $('.midPanel').sakura();
// });


</script>
<script type="text/javascript">

 var viewHeight = $(window).width();
 var footHeight = $(".comanBox").innerWidth();

//alert(footHeight);
$(".comanBox").css('height',footHeight+'px');




</script>
<script type="text/javascript">
	$(document).ready(function(){
		
		//alert('hello');
		$('.ico-srch').click(function(){
	
	$('.srch-ap').toggle();
});
	});
</script>

</body>
</html>
