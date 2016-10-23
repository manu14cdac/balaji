<?php


error_reporting(E_ALL ^ E_NOTICE);


session_cache_limiter('none');


ini_set('session.save_handler', 'files');


@session_start();





$db_url  = "localhost";  

$db_name = "balaji";

$database_catalog = $db_name;

$db_username = "root";

$db_password = 'health';



$catalog = mysql_connect( $db_url, $db_username, $db_password ) or die ("Could not connect to MySQL Server!"); 


mysql_select_db( $database_catalog ) or die ("Can not select database."); 

$baseurl = "http://localhost/balaji/admin";

$appname = "balaji";


$uploadDir = 'uploads/';


$Uploadimage= "admin/uploads/images/";
$Uploadcategoryimage= "admin/uploads/categories/";
$Uploadevents= "admin/uploads/events/";
$Uploadmarriage= "admin/uploads/marriage/";
$Uploadresumes= "admin/uploads/resumes/";
$Uploadgallerys= "admin/uploads/gallery/";
$Uploadprayers= "admin/uploads/prayer/";
$Uploadpyaersimage="uploads/prayer/aartiimage/";
$Uploaddesignation= "admin/uploads/designation/";
$Uploadtemple= "admin/uploads/temple/";
$Uploadadd= "admin/uploads/add/";
$Uploadwishes= "admin/uploads/wishes/";

$Uploadjobpost= "admin/uploads/jobpost/";


$Uploadmember= "admin/uploads/member/";



$NoImagePath= "admin/uploads/images/noimage.png";

$Uploadfile= "admin/uploads/files/";



?>