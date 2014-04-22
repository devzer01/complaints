<?php
session_start();

$fields = array('title', 'business_name', 'business_location', 'user_name', 'user_email', 'complaint');
$empty = array();
foreach ($fields as $field) {
	if (trim($_POST[$field]) == "") {
		$empty[$field] = 1;
	}
}

$_SESSION['formfields'] = $_POST;

if (count($empty) > 0) {
	$_SESSION['errfields'] = $empty;
	header("Location: /");
	exit;	
}

include_once('lib/secureimage.php');
$image = new Securimage();
$_SESSION['captcha'] = $image->check($_POST['code']);
include_once('header.inc');
?>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead' style="width: 480px;">Review Complaint</h3>
<div id='complaintsearch' style="margin-top: 5px; width:540px; float:left; border: 1px red solid; padding: 5px 10px 5px 10px;">
<h4 style="text-align:right">
	<?php print $_POST['user_name']; ?><br/> 
	<?php print @date("Y-m-d"); ?>
</h4>
<h4 style="text-align:left">Relations Manager<br/><?php print $_POST['business_name']; ?><br/><?php print $_POST['business_location']; ?></h4>
<h3 style="text-align:center; text-decoration:underline;"><?php print $_POST['title']; ?></h3>
<p style="text-align:justify"><em>&nbsp;&nbsp;&nbsp;&nbsp;<?php print nl2br(stripslashes($_POST['complaint'])); ?></em></p>
<h4 style="text-align:right">Your Customer<br/><?php print $_POST['user_name']; ?></h4>
<div style="text-align:center;"><form method="post" action="complaint-submit-confirm.php">
   <input onclick='history.go(-1);' type='button' style='font-size: 24px; padding: 5px; width: 75px;' class='textbox' value='Edit' /> &nbsp;&nbsp;
	<input onclick='this.form.submit();' type='button' style='font-size: 24px; padding: 5px; width: 75px;' class="textbox" value="Submit" />
</form></div>
 <div style='text-align: center;margin-top: 5px; margin-bottom: 5px;'>
 	<span style="font-size:12px;">By pressing the submit button your agreeing to the <a href="/tos.php">terms and services</a> of complaintsbbb.</span>
 </div>
</div>
</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
<h3 class='subhead'>Unsatisfied with a business dealing?</h3>
<p></p>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4431395448791719";
/* sidebar */
google_ad_slot = "7350178513";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<p></p>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4431395448791719";
/* sidebar */
google_ad_slot = "7350178513";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<p></p>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4431395448791719";
/* sidebar */
google_ad_slot = "7350178513";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

<?php

include_once('footer.inc');

?>
