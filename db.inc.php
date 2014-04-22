<?php
$con = mysql_connect("localhost:/tmp/mysql.sock", "complaintsbbb", "V8UAEuP09X", true) or die(mysql_error());
mysql_select_db("complaintsbbb", $con) or die(mysql_error()); 


function mq($sql)
{
	global $con;
	$rs = mysql_query($sql, $con) or die(__FILE__ . ":" . __LINE__ . ":" . mysql_error());
	if ($rs == FALSE) {
		throw new Exception(mysql_error(), mysql_errno());
	}
	return $rs;
}

?>
