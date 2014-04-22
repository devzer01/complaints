<?php
session_start();
include_once('db.inc.php');

$_POST = $_SESSION['formfields'];
unset($_SESSION['formfields']);

$q = "INSERT INTO user (name, email) VALUES ('" . mysql_real_escape_string($_POST['user_name']) . "', '". mysql_real_escape_string($_POST['user_email']) . "')";
mysql_query($q, &$con);
$user_id = mysql_insert_id();

$q = "INSERT INTO business (name, location) VALUES ('" . mysql_real_escape_string($_POST['business_name']) . "', '" 
. mysql_real_escape_string($_POST['business_location']) . "')";
mysql_query($q, &$con);
$business_id = mysql_insert_id();

$q = "INSERT INTO complaint (business_id, author_user_id, created_date, title, category_id) VALUES ({$business_id}, {$user_id}, NOW(), '" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['category_id']) . "')";
mysql_query($q, &$con);
$complaint_id = mysql_insert_id();

$q = "INSERT INTO complaint_text (complaint_id, comment_type, comment) VALUES ({$complaint_id}, 1, '" . mysql_real_escape_string($_POST['complaint']) . "')";
mysql_query($q, &$con);

//insert logic for static html creation logic que 
//post html creation send email notification

include_once('header.inc');

?>

<div class="body" id='submitcomplaint' style="width:99%;"><h2>Complaint Received</h2>
Your browser will be forwarded to your complaint page in 5 seconds. <a href="/view.php?id=<?php echo $complaint_id; ?>">Click Here</a> if it doesn't. 
</div>
<script type="text/javascript">
var t1 = new Timer();
t1.setTimeout(this.window.location.href='view.php?id=<?php echo $complaint_id; ?>', 5000);
</script>
<?php

include_once('footer.inc');

?>
