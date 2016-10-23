<?php
include_once('include/front_function.php');
$sidemenu = get_side_menu();

?>	
					<ul>				
						<?php
						foreach ($sidemenu as $key) {

							?>
							<li><a href="<?php echo $key['url'] ?>"><?php echo $key['name'] ?></a></li>
							<?php

                         }
                       ?>

					</ul>	
			
	