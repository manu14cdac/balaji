<?php

include_once('include/front_function.php');

//$story = get_cstory();
$miracle = get_miracle();
?>
<section class="bg2">
<div class="container">
<div class="row">
	<h2 class="exp-foot">EXPERIENCE</h2>
</div>
  <div class="row">
  <?php
  $i=1;
  foreach ($miracle as $key ) {
   
    ?>
    <div class="col-lg-4 col-md-6">
      <div class="media-object-default">
        <div class="media">
          <div class="media-left"> <a href="#"> <img width="60" class="media-object" src="images/foot-img-gal.jpg" alt="placeholder image"> </a> </div>
          <div class="media-body">
            <h4 class="media-heading"><?php echo $key['story_teller'] ?></h4>
            <?php echo substr($key['miracle_story'], 0, 100);  ?></div>
        </div>
        
      </div>
    </div>
    <hr class="hidden-md hidden-lg">

    <?php 
    $i++;
    if($i%3==0)
    {
    	echo '<br>';
    }if($i==6)
    {
      break;
    }

    }
    ?>

  </div>
</div>
</section>
