<?php
session_start();
$con = mysql_connect("localhost", "complaintsbbb", "V8UAEuP09X");
mysql_select_db("complaintsbbb", $con);

$_POST = $_SESSION['formfields'];
unset($_SESSION['formfields']);
$_POST['complaint_id'] = $_SESSION['complaint_id'];
unset($_SESSION['complaint_id']);

$q = "INSERT INTO user (name, email) VALUES ('" . mysql_real_escape_string($_POST['user_name']) . "', '". mysql_real_escape_string($_POST['user_email']) . "')";
mysql_query($q, $con) or die("Error inserting user" . mysql_error());
$user_id = mysql_insert_id();

$q = "INSERT INTO complaint_text (complaint_id, comment_type, comment) VALUES (" . $_POST['complaint_id'] . ", 2, '" . mysql_real_escape_string($_POST['complaint'])  . "')";
mysql_query($q, $con) or die("Error inserting comment record" . mysql_error());
$complaint_text_id = mysql_insert_id();

$q = "INSERT INTO complaint_user (complaint_text_id, user_id, type) VALUES (" . $complaint_text_id . "," . $user_id . " , 2) ";
mysql_query($q, $con) or die("Error associating user" . mysql_error());

$q = "UPDATE complaint SET posted = NULL where id = " . $_POST['complaint_id'];
mysql_query($q, $con) or die("Error resetting posting" . mysql_error());

//insert logic for static html creation logic que 
//post html creation send email notification

include_once('header.inc');

?>

<div class="body" id='submitcomplaint' style="width:99%;"><h2>Business Response Received</h2>
Your browser will be forwarded to the original complaint page including your response in 5 seconds. <a href="/view.php?id=<?php echo $_POST['complaint_id']; ?>">Click Here</a> if it doesn't. 
</div>
<script type="text/javascript">
var t1 = new Timer();
t1.setTimeout(this.window.location.href='view.php?id=<?php echo $complaint_id; ?>', 5000);
</script>
<?php

include_once('footer.inc');

?>
