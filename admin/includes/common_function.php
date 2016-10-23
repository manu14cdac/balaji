<?php
/*********Constant***************/
define("HOME_DIR", $_SERVER['DOCUMENT_ROOT'].'/ci_test/admin/');	//ravi
define("DATETIME", date("Y-m-d H:i:s"));	//ravi
define("INSERTMSG", "Record added successfully");
define("UPDATEMSG", "Record updated successfully");
define("DELETEMSG", "Record deleted successfully");
/*********Constant Function*************/

function image_upload($image_name,$temp_name,$url){
	$image_name=explode(".",$image_name);
	$tot=count($image_name);
	$img_name=$image_name[$tot-2]."-".time().".".$image_name[$tot-1];
	$target = $url."/".basename($img_name) ; 
		
	if(move_uploaded_file($temp_name,$target)){
		return $img_name;
	}
}
function single_row($table, $col, $val){
	$data = mysql_query("select * from $table where $col='".$val."' ");
	$row = mysql_fetch_assoc($data);
	return $row;
}
function checkduplicate($table, $col, $val, $edit_id_key, $edit_val){
	
	if($edit_val!='' && $edit_val > 0){
		$query = " and $edit_id_key!='".$edit_val."' ";
		
	} else {
		$query="";
	}
	
	$data = mysql_query("select count(*) as total from $table where $col='".$val."' $query ");
	$row = mysql_fetch_assoc($data);
	return $row['total'];
}
function deleterecord($table, $col, $val){
	$delete = mysql_query("delete from $table where $col='".$val."'");
	if($delete){
		return true;
	} else {
		return false;
	}
}
?>
