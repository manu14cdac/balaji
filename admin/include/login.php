<?php
session_start();
include_once('dbconfig.php');

$data = $_POST;

$username = $_POST['username'];
$pass = $_POST['pass'];

if($username=='' && $pass=='')
{
  echo 'missing';
  exit();
}


$query = "SELECT id,name,password from admin where status='1' and username='".$username."'";
$result = mysql_query($query);
$count = mysql_num_rows($result);

if($count==0)
{
	echo 'false';
	exit();
}

$row = mysql_fetch_assoc($result);

$get_pass = $row['password'];

if($get_pass==md5($pass))
{
	active_session($row);
    $time = date("Y-m-d h:i:s");
	$update_query = "UPDATE admin set last_login='".$time."' where id ='".$row['id']."'";
	$update_res = mysql_query($update_query);

	echo 'true';


} 


function active_session($data)
{
	$_SESSION['user_id']= $data['id'];
	$_SESSION['name'] = $data['name'];
	# code...
}
exit();

?>