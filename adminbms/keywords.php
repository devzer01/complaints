<?php

//type 5 keywords
//type 6 description
include_once('admin.db.inc.php');

if (isset($_POST['complaint_id'])) {
	
	$q = "SELECT id FROM complaint_text WHERE complaint_id = " . $_POST['complaint_id'] . " AND comment_type = 5 ";
	$rs_custom = mysql_query($q, $adbcon) or die("Error selecting custom keywords " . mysql_error());
	
	if (mysql_num_rows($rs_custom) == 1) {
		$r_keywords = mysql_fetch_assoc($rs_custom);
		$q = "UPDATE complaint_text SET comment = '" . mysql_real_escape_string($_POST['complaint_keywords']) . "' WHERE id = " . $r_keywords['id'];
		mysql_query($q, $adbcon) or die("Error updating keywords " . mysql_error());
	} else {
		$q = "INSERT INTO complaint_text (complaint_id, comment_type, comment) VALUES (" . $_POST['complaint_id'] . ", 5, '" . mysql_real_escape_string($_POST['complaint_keywords']) . "')";
		mysql_query($q, $adbcon) or die("Error inserting to complaint text " . mysql_error()); 
	}
		?>
   	
   <script>
   	window.close();
   </script>
	
<?php 
	} else {
	$q = "SELECT comment FROM complaint_text WHERE complaint_id = " . $_GET['id'] . " AND comment_type = 5 ";
	$rs_custom = mysql_query($q, $adbcon) or die("Error selecting custom keywords " . mysql_error());
	
	if ($rs_custom === FALSE || mysql_num_rows($rs_custom) == 0) {

		$q = "SELECT k.description FROM keyword AS k "
			. "LEFT OUTER JOIN complaint_keyword AS ck ON ck.keyword_id = k.id "
			. "WHERE ck.complaint_id = " . $_GET['id'];
		$rs_keywords = mysql_query($q, $adbcon) or die("Error selecting keywords" . mysql_error());
		
		while ($r_keyword = mysql_fetch_assoc($rs_keywords)) {
			$keywords[] = $r_keyword['description'];	
		}
		
		$keywords = implode(", ", $keywords);
		
	} else {
		$r_keywords = mysql_fetch_assoc($rs_custom);
		$keywords = $r_keywords['comment'];
	}

	$q = "SELECT comment FROM complaint_text WHERE complaint_id = " . $_GET['id'] . " AND comment_type = 1 ";
	$rs_complaint = mysql_query($q, $adbcon) or die("Error selecting main text " . mysql_error());
	$r_complaint = mysql_fetch_assoc($rs_complaint);
?>
<div>
<?php print $r_complaint['comment']; ?>
</div>
<form method="post" action="keywords.php">
<input type='hidden' name="complaint_id" value='<?php print $_GET['id']; ?>' />
<textarea name='complaint_keywords'><?php print $keywords ?></textarea>
<input type='submit' value='Overwrite default keywords' />
</form>
<?php } ?>