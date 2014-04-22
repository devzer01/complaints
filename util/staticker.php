<?php 
include_once('../db.inc.php');
$basedir = realpath(dirname(__FILE__) . '/../');
define('WEBDIR', $basedir);
define('PAGE', 'view.php');
define('LOCK', '/var/tmp/staticker.lock'); 

if (is_dir(LOCK)) exit;

include_once('keyworder.php');

mkdir(LOCK, 0700, true);

$q = "SELECT c.id, c.title, UNIX_TIMESTAMP(c.created_date) AS created_date, ct.comment "
   . "FROM complaint AS c "
   . "LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id AND ct.comment_type = 1 "
   . "WHERE c.posted IS NULL and c.active = 1 ";
$rs = mysql_query($q, $con) or die("Error on Batch Select " . mysql_error());

while ($r = mysql_fetch_assoc($rs)) { 

	$keywords = get_keywords($r['comment']);
	
	foreach ($keywords as $keyword) {
		$q = "SELECT id FROM keyword WHERE description = '" . mysql_real_escape_string($keyword) . "' ";
		$rs_test = mysql_query($q, $con) or die("Error on keyword Lookup " . mysql_error());
		$keyword_id = mysql_fetch_assoc($rs_test);
		if ($keyword_id == FALSE) {
			$q = "INSERT INTO keyword (description) VALUES ('" . mysql_real_escape_string($keyword) . "') ";
			mysql_query($q, $con) or die("Error on keyword insert " . mysql_error());
			$keyword_id['id'] = mysql_insert_id($con);
		}
		
		$q = "UPDATE keyword SET count = count + 1 WHERE id = " . $keyword_id['id'];
		mysql_query($q, $con) or die("Error on count update " . mysql_error());
		
		$q = "INSERT INTO complaint_keyword (complaint_id, keyword_id) VALUES (" . $r['id'] . "," . $keyword_id['id'] . ")";
		mysql_query($q, $con) or die("Error on keyword assoc " . mysql_error());
	}
	

	$static_file_name = strtolower($r['title'] . "-" . $r['id'] . ".html");
	$static_file_name = preg_replace("/[^A-Za-z0-9\s\.\-]/", "", $static_file_name);
	$static_file_name = preg_replace("/\s/", "-", $static_file_name);
	@$directory_year = date("Y", $r['created_date']);
	@$directory_month = date("m", $r['created_date']);
	@$directory_day   = date("d", $r['created_date']);

	print "DEBUG	- Creating Static File Name " . $static_file_name . "\n"; 
	$directory = "/" . $directory_year . "/" . $directory_month . "/" . $directory_day;
	//cherck if directory exisits and if not create it

	@mkdir(WEBDIR . $directory, 0777, TRUE);
	$file_path = $directory . "/" . $static_file_name;
	$q = "UPDATE complaint SET posted = NOW(), url = '" . $directory . "/" . $static_file_name . "' WHERE id = ". $r['id'];
	mysql_query($q, $con) or die("Error Updating" . mysql_error());
	
	$fp = fopen(WEBDIR . $file_path, "w+");
	$htmlout = create_page($r['id']);
	fprintf($fp, "%s", $htmlout);
	fclose($fp);

	print "Debug r " . print_r($r, true) . "\n";
	//notify_user($r['id']);

}

$q = "SELECT url, UNIX_TIMESTAMP(created_date) AS created_date, UNIX_TIMESTAMP(modified_date) AS modified_date FROM complaint WHERE posted IS NOT NULL AND active = 1 ";
$rs = mysql_query($q, $con) or die("Error Selecting Posted " . mysql_error());
echo $q;
$xml_header = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . '<url><loc>http://complaintsbbb.com/</loc><lastmod>' . @date("Y-m-d") . '</lastmod><changefreq>monthly</changefreq><priority>1.0</priority></url>';
$count = 2;
while ($r = mysql_fetch_assoc($rs)) {
	if ($r['modified_date'] == 0) {
		$lastmod = date("Y-m-d", $r['created_date']);
	} else {
		$lastmod = date("Y-m-d", $r['modified_date']);
	}
	$xml .= "<url><loc>http://complaintsbbb.com" . $r['url']. "</loc>" 
	      . "<lastmod>" . $lastmod . "</lastmod>"
		   . "<changefreq>monthly</changefreq>" 
		   . "<priority>0.8</priority></url>";	
	
}

$xml = $xml_header . $xml . "</urlset>";
file_put_contents(WEBDIR . "/sitemap.xml", $xml);

rmdir(LOCK);

function create_page($id) {
	global $complaint_id;
	ob_flush();
	ob_start();
	$complaint_id = $id;
	include('../view.php');
	$htmlout = ob_get_contents();
	ob_end_clean();
	//check the function name for capturing output buffer to variable
		
	return $htmlout;
}

function notify_user($id) {
	if ($id == FALSE || $id == NULL) return false;
	
	global $con;
	
	$q = "SELECT c.id AS complaint_id, u.id AS user_id, u.name, u.email, c.url "
	    . "FROM complaint AS c "
	. "LEFT OUTER JOIN user AS u ON c.author_user_id = u.id "
		. "WHERE c.id = " . $id;
		
	$rs = mysql_query($q, $con) or die("Error selecting email" . mysql_error());
	
	$r = mysql_fetch_assoc($rs);
	
	$verifykey = md5($r['user_id'] . $_SERVER['REMOTE_ADDR'] . @date('Ymdhsi'));
	$q = "UPDATE user SET verifykey = '" . $verifykey . "' WHERE id = " . $r['user_id'];
					
	mysql_query($q, $con) or die("Error updating key " . $q . mysql_error());
	
	$message = "Dear " . $r['name'] . ",
	Your complaint has been posted on http://complaintsbbb.com" . $r['url'] . ", Please take this oppertunity to verify your email address and create a password so you can manage your complaint in the future. http://complaintsbbb.com/register.php?password=1&key= " . $verifykey . " 
	Thank you. Complaints Business Bulletin Board Team ";
	mail($r['email'], "Your Complaint #" . $r['complaint_id'] . " has been posted ", $message);
	
}



