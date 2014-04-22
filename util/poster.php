<?php
include_once('../db.inc.php');
$hdb = 'localhost';
$husr = 'root';
$pwd  = '';
$rcon = mysql_connect($hdb, $husr, $pwd, true) or die(mysql_error());
mysql_select_db('harvestor', $rcon) or die(mysql_error());
$sql = "SELECT * FROM harvestor_data_rewrite WHERE phase IS NULL AND parsed IS NULL LIMIT 100";
$rs = mysql_query($sql, $rcon) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error());

require_once 'names2.txt';
$ns = explode("\n", file_get_contents('names.txt'));
$allnames = array_merge($ns, $names);
$namecount = count($allnames);
$count = 0;
while ($r = mysql_fetch_assoc($rs)) {

	$data = unserialize($r['data_record']);
	if (trim($data['business_name']) == '') {
		printf("incomplte data skipping\n");
		continue;
	}
	$count++;
	if ($count == 11) {
		break;
	}
	$data['body'] = trim($data['body']);
	$data['heading'] = trim($data['heading']);
	$data['keywords'] = trim($data['keywords']);
	$data['business_name'] = trim($data['business_name']);
	$data['business_location'] = trim($data['business_location']);
	$ifrandname = rand(1, $namecount);
	$ilrandname = rand(1, $namecount);
	$imonth    = rand(1, 12);
	$idate     = rand(1, 28);
	if ($imonth <= 10) {
		$iyear     = rand(2009, 2011);	
	} else {
		$iyear     = rand(2009, 2010);
	}
	$username = $allnames[$ifrandname] . " " . $allnames[$ilrandname];
	$date = $iyear . '-' . $imonth . '-' . $idate . ' 00:00:00';
	$category_id = rand(1,20);
	
	printf("Adding record with %s name %s and %s \n", $username, $date, $category_id);
	
	$q = "INSERT INTO user (name, email) VALUES ('" . mysql_real_escape_string($username) . "', '". mysql_real_escape_string($allnames[$ifrandname] . "." . $allnames[$ilrandname] . '@corp-gems.com') . "')";
	mysql_query($q, $con) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error());
	$user_id = mysql_insert_id($con);
//
	$q = "INSERT INTO business (name, location) VALUES ('" . mysql_real_escape_string($data['business_name']) . "', '" 
		. mysql_real_escape_string($data['business_location']) . "')";
	mysql_query($q, $con) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error());
	$business_id = mysql_insert_id($con);
//
	$q = "INSERT INTO complaint (business_id, author_user_id, created_date, title, category_id) VALUES ({$business_id}, {$user_id}, '{$date}', '" . mysql_real_escape_string($data['heading']) . "', '" . $category_id . "')";
	mysql_query($q, $con) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error());
	$complaint_id = mysql_insert_id($con);
//
	$q = "INSERT INTO complaint_text (complaint_id, comment_type, comment) VALUES ({$complaint_id}, 1, '" . mysql_real_escape_string($data['body']) . "')";
	mysql_query($q, $con) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error($con));

	$q = "INSERT INTO complaint_text (complaint_id, comment_type, comment) VALUES (" . $complaint_id . ", 5, '" . mysql_real_escape_string($data['keywords']) . "')";
	mysql_query($q, $con) or die("Error inserting to complaint text " . mysql_error()); 

	$q = "UPDATE harvestor_data_rewrite SET parsed = NOW() where id = " . $r['id'];
	mysql_query($q, $rcon) or die(__FILE__ . ':' . __LINE__ . ':' . mysql_error());
}
?>
