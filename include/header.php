<?php
include_once('front_function.php');
$menu = get_menu();
?>
<header class="top-head" style="display:none;">
<div class="container">
<div class="row">
<div class="col-sm-6">
<form id="quick-search" action="index.php" method="get" >
					
					<input class="tbox" id="qsearch" type="text" name="qsearch" value="Comapany Name  Search" title="Start typing and hit ENTER" />
					<input class="btn btn-srch" alt="Search" type="image" name="Comapany Name Search" title="Comapany Name Search" src="images/search.gif" />
					
				</form>
</div>
<div class="col-sm-6">
<ul class="sign-up-top">
<?php
						if($_SESSION["LoggedIn"] == True)
{ ?>
<li><a href="logout4.php" class="logout">logout</a></li>
<?php
} 

else
{ 

 ?>

<li><a href="login.php"  class="login">Sign In</a></li> <li><a href="memberregistration1.php"  class="login">Sign Up</a></li>

<?php
} 

?>
<li>
<form name="name" class="lanuge">
<select name="nameindex" onchange="fun()" >
<option value="0">English</option>
<option value="1">Hindi</option>
</select>
</form>
</li>
</ul>
</div>
</div>
</div>
</header>
<!-- wrap starts here -->
	<!--header -->
<div id="header" class="main-nav">			
				
					
		<nav class="navbar navbar-default" role="navigation">
<div class="container">
 
<div class="navbar-header col-sm-4">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
<span class="sr-only">Toggle navigation</span>
<i class="icon-menu"></i> Menu
</button>

<a class="navbar-brand" href="index.php"><span>Anjani Nandan</span></a>
</div>
 
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

<ul class="nav navbar-nav main-menu navbar-right">

<?php
foreach ($menu as $key ) {
 	?>
 	<li>
<a href="<?php echo $key['url']; ?>"><?php echo $key['name']; ?></a>
</li>
 	<?php
 } 
?>
<!-- <li>
<a href="index.php">Home</a>
</li>
<li>
<a href="cstory.php">Lord's</a>
</li>
<li>
<a href="sabhamani.php">Sabhamani</a>
</li> -->
<!-- <li>
<a href="cstory.php">Shri Mahant ji</a>
</li> -->
<!-- <li>
<a href="cstory.php">Contact Us</a>
</li> -->
<li>
<a href="javascript:void(0)" class="ico-srch"><i class="fa fa-search"></i></a>
<form id="quick-search" action="index.php" method="get" class="srch-ap" style="display: none;">
					
					<input class="tbox" id="qsearch" type="text" name="qsearch" placeholder="Comapany Name  Search" title="Start typing and hit ENTER" />
					<input class="btn btn-srch" alt="Search" type="image" name="Comapany Name Search" title="Comapany Name Search" src="images/search.gif" />
					
				</form>
</li>

<li>
<form name="name" class="lanuge">
<select name="nameindex" onchange="fun()" >
<option value="0">English</option>
<option value="1">Hindi</option>
</select>
</form>
</li>

</ul>
</div>
 
</div>
 
</nav>	
		
						
	<!--header ends-->					
	</div>