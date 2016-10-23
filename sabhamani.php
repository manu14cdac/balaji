<?php

include_once('include/front_function.php');

$sabhamani = get_sabhamani();
//$miracle = get_miracle();
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
    include_once("ml.php"); ?>
    </div>  
        </div>
        <div class="col-sm-9">
          


            <?php
            $i=1;
                  foreach ($sabhamani as $key)  {

                    ?>
                  <div class="col-accord">
            <h3 class="jai-arti" onclick="set_toggle(<?php echo $i; ?>)"><?php echo $key['sr_number'].' '.$key['name']; ?></h3>
            <div class="contnt-arti contnt-arti<?php echo $i; ?> mCustomScrollbar light" style="display: none;">
            
 
            <div class="arti-txt">
            <p><c> <?php echo $key['sr_number'] ?> </c></p>
            <p>Name : <?php echo $key['name'] ?> </p>
            <p>Father Name : <?php echo $key['father_name'] ?> </p>
            <p>Date : <?php echo $key['date'] ?> </p>
            <p>Address : <?php echo $key['address'] ?> </p>
            <p>City : <?php echo $key['city'] ?> </p>
             <p>Contact : <?php echo $key['contact'] ?> </p>
            </div>
            </div>
          </div>
                    <?php
                    $i++;
                  }
            ?>
          


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
//    $(".contnt-arti").hide();
// $(".jai-arti").click(function(){
// $(".contnt-arti").slideDown();

// })

//  })

var active_arti = 0;
  
  function set_toggle(val)
  {
    if(active_arti!=0 && active_arti!=val)
    {
      $('.contnt-arti'+active_arti).slideToggle();
    }
  //$('.testt-show').click(function(){
    
    $('.contnt-arti'+val).slideToggle();
    active_arti= val;
     //}
    
    
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
