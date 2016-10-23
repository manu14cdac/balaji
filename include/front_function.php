<?php
include_once("dbconfig.php");

function get_cstory()
{

	$sql = "SELECT * from story where status = 1 order by id desc";
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;
}


function get_miracle()
{

	$sql = "SELECT * from miracle where status = 1 order by id desc";
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;
}


function get_sabhamani()
{

	$sql = "SELECT * from sabamani where status = 1 order by id desc";
	
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;
}

function get_menu()
{

	$sql = "SELECT * from menu where status = 1 order by id asc";
	
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;
}

function get_side_menu()
{

	$sql = "SELECT * from sidemenu where status = 1 order by id asc";
	
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;
}

function get_home_menu()
{

$sql = "SELECT * from home_setting where status = 1 order by id asc";
	
	$result = mysql_query($sql);
	$data='';
	while ($row = mysql_fetch_array($result)) {
		$data[] = $row;
	}
	return $data;

}

function contactusmail($name, $mobile, $txtmessage){

	$sql = "INSERT into contact set name = '".$name."',mobile='".$mobile."',message='".$txtmessage."'";
	
	$result = mysql_query($sql);
	return true;

	/*$message = "<table border='0' cellpadding='0' cellspacing='0' style='font-family:arial; margin:0 auto; width:700px'>
		 <tbody>
		  <tr>
		   <td style='background-color:#ddd;'>
		   <div style='padding:10px 20px;'>".'<a href=""><img src="images/logo.png" alt="" /></a>'."</div>
		   </td>
		  </tr>
		  <tr>
		   <td style='background-color:rgb(68,68,68)'>
		   <div style='padding:5px 10px;color:white;font-size: 18px;'>Contact us</div>
		   </td>
		  </tr>
		  <tr>
		   <td>
		   <div style='border:1px solid #444;'>
		   <table style='color:#555; padding:20px'>
			<tbody>
			 <tr>
			  <td>Dear Admin</td>
			 </tr>
			 <tr>
			  <td>&nbsp;</td>
			 </tr>
			 <tr style='vertical-align:top;'>
			  <td>One user wants to contact with you. Details mentin below:</td>
			 </tr>
			 <tr style='vertical-align:top;'>
			  <td>Name: ".$name."</td>
			 </tr>
			 <tr style='vertical-align:top;'>
			  <td>Mobile: ".$mobile."</td>
			 </tr>
			 <tr style='vertical-align:top;'>
			  <td>Message: ".$txtmessage."</td>
			 </tr>
			 <tr>
			  <td>&nbsp;</td>
			 </tr>
			 <tr>
			  <td>&nbsp;</td>
			 </tr>
			 <tr>
			  <td>Best Regards</td>
			 </tr>
			 <tr>
			  <td>Admin</td>
			 </tr>
			</tbody>
		   </table>
		   </div>
		   </td>
		  </tr>
		  <tr>
		   <td style='background-color:#444; text-align:right'>
		   <div style='padding:10px 20px;'>".'<a href=""><img src="images/logo.png" alt="" /></a>'."</div>
		   </td>
		  </tr>
		 </tbody>
	</table>";

	$subject = "Contact us: Training Dino";
	$to = 'ravinder.software.engineer@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: Do Not Reply <donotreply@balaji.com>' ."\r\n";
	$mail=mail($to, $subject, $message, $headers);
	return $mail;*/
}
define("HOME_URL", "http://localhost/balaji/");
?>