<?php
session_start();
include("admin.db.inc.php");

$q = "SELECT id, title FROM complaint ";
$rs = mysql_query($q, $adbcon) or die("Selecting ids " . mysql_error());
$ids = array(); $delids = array();
while ($r = mysql_fetch_assoc($rs)) {
	
	if (isset($_POST['repost_' . $r['id']])) {
		$ids[] = $r['id'];	
	}
	if (isset($_POST['del_' . $r['id']])) {
		$delids[] = $r['id'];	
	}
	
	if (isset($_POST['title_' . $r['id']]) && $r['title'] != $_POST['title_' . $r['id']]) {
		$q = "UPDATE complaint SET title = '" . mysql_real_escape_string($_POST['title_' . $r['id']]) . "' WHERE id = " . $r['id'];
		mysql_query($q, $adbcon) or die("Error updating title " . mysql_error());
	}
	
}
if (count($ids) > 0) {
	$q = "UPDATE complaint SET posted = NULL, modified_date = NOW() WHERE id IN (" . implode(",", $ids) . ")";
	mysql_query($q, $adbcon) or die("Error updating post flag " . mysql_error());
}

if (count($delids)) {
	$q = "DELETE FROM complaint WHERE id IN (" . implode(",", $delids) . ")";
	mysql_query($q, $adbcon) or die("error deleting " . mysql_error());
}

header("Location: /adminbms/indexmin.php");
exit; 