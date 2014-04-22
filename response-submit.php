<?php
session_start();

$fields = array('complaint', 'user_name', 'user_email');
$empty = array();
$_SESSION['formfields'] = $_POST;

foreach ($fields as $field) {
	if (trim($_POST[$field]) == "") {
		$empty[$field] = 1;
	}
}

if (count($empty) > 0) {
	$_SESSION['errfields'] = $empty;
	header("Location: /respond.php?id=" . $_POST['id']);
	exit;	
}

include_once('header.inc');
include_once('db.inc.php');

if (isset($_POST['id'])) { 
	 $q = "SELECT c.id, c.title, b.name AS business_name, b.location AS business_location, ct.comment AS complaint_text, UNIX_TIMESTAMP(c.created_date) AS complaint_date, u.name AS user_name  "
   		. "FROM complaint AS c "
   		. "LEFT OUTER JOIN business AS b ON b.id = c.business_id "
		. "LEFT OUTER JOIN user AS u ON u.id = c.author_user_id "
   		. "LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id AND ct.comment_type = 1 "
   		. "WHERE c.id = " . mysql_real_escape_string($_POST['id']);
	$rs = mysql_query($q, $con);

	$complaint = mysql_fetch_assoc($rs);
}
?>
<div class="body" id='complaintsearch' style="width:550px; float:left;">
   <h3 class='subhead' style="width: 480px;">Review your business response.</h3>
   <div id='complaintsearch' style="margin-top: 5px; width:540px; float:left; border: 1px red solid; padding: 5px 10px 5px 10px;">
      <?php include_once('view.response.inc.php'); //should be response view template using post?>
     	<div style="text-align:center;">
     		<form method="post" action="response-submit-confirm.php">
   			<input onclick='history.go(-1);' type='button' style='font-size: 24px; padding: 5px; width: 75px;' class='textbox' value='Edit' /> &nbsp;&nbsp;
				<input onclick='this.form.submit();' type='button' style='font-size: 24px; padding: 5px; width: 75px;' class="textbox" value="Submit" />
			</form>
    	</div>
 		<div style='text-align: center;margin-top: 5px; margin-bottom: 5px;'>
 			<span style="font-size:12px;">By pressing the submit button your agreeing to the <a href="/tos.php">terms and services</a> of complaintsbbb.</span>
 		</div>
  </div>

<!-- original complaint begin -->
 <div id='complaintsearch' style="margin-top: 5px; width:540px; float:left; border: 1px red solid; padding: 5px 10px 5px 10px;">
	<?php include_once('view.complaint.inc.php'); ?>
</div>
     </div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
<h3 class='subhead'>How to Respond as a business?</h3>
<p>&nbsp;&nbsp;<strong>First Sample Paragraph</strong><br/>
I was most concerned to receive your letter dated _____________ regarding__________ </p>
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
<p><strong>Main Body Sample Paragraph</strong><br/>
Respond to each issue raised in this part of your letter...</p>

<p><strong>Apologise when appropriate...</strong><br/>
Show empathy - I appreciate how frustrating…</p>

<p><strong>Emphasise what you have done or can do...</strong><br/>

The company aims to consistently deliver a professional service to our customers and I would like to state that on this occasion the level of service you received was  unacceptable.</p>

<p><strong>Closing Sample Paragraphs</strong><br/>
Create the correct lasting impression – the last thing you say, will be the first thing the customer remembers</p>

<p><strong>Thank you for bringing this matter to my attention</strong><br/> and that you will have no further cause for any complaint in relation to our service.</p>

<p><strong>I apologise for the annoyance</strong><br/> that this may have caused to you. The company is actively working to improve service levels and your feedback has proved to be invaluable. </p>
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
<p>&nbsp;</p>
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