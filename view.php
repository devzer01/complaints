<?php 
@session_start();
global $complaint_id;
global $con;
global $g_url;
if (isset($_GET['id'])) $complaint_id = $_GET['id'];

require_once('db.inc.php');

$q = "SELECT c.id, c.id AS complaint_id, u.name AS user_name, u.id AS author_user_id,
			 UNIX_TIMESTAMP(c.created_date) AS complaint_date,
			 b.name AS business_name, b.location AS business_location,
			 c.title AS title, c.url, 
			 ct.comment AS complaint_text, ct_kywd.comment AS keywords, ct_desc.comment AS description
	  FROM complaint AS c
	  LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id AND ct.comment_type = 1
	   LEFT OUTER JOIN complaint_text AS ct_kywd ON ct_kywd.complaint_id = c.id AND ct_kywd.comment_type = 5
		 LEFT OUTER JOIN complaint_text AS ct_desc ON ct_desc.complaint_id = c.id AND ct_desc.comment_type = 6
	  LEFT OUTER JOIN business AS b ON b.id = c.business_id
	  LEFT OUTER JOIN user AS u on u.id = c.author_user_id "
	  . " WHERE c.id = " . $complaint_id;
  
$rs = mysql_query($q, $con) or die("Error on Complaint Select " . mysql_error());
$complaint = mysql_fetch_assoc($rs);

$q = "SELECT u.name AS user_name, u.id AS author_user_id,
			 UNIX_TIMESTAMP(ct.created_date) AS comment_date,
			 ct.comment AS comment_text, ct.comment_type
	  FROM complaint_text AS ct
  	  LEFT OUTER JOIN complaint_user AS cuct ON cuct.complaint_text_id = ct.id 
	  LEFT OUTER JOIN user AS u ON u.id = cuct.user_id "
	  . " WHERE ct.comment_type IN (2,3) AND ct.complaint_id = " . $complaint_id;
	  

$rs_comments = mysql_query($q, $con) or die("Error on Comment select " . mysql_error());

if (trim($complaint['keywords']) == '') {
	$q = "SELECT k.description FROM keyword AS k "
		. "LEFT OUTER JOIN complaint_keyword AS ck ON ck.keyword_id = k.id "
		. "WHERE ck.complaint_id = " . $complaint_id;
		
	$rs_keyword = mysql_query($q, $con) or die("Error on Keyword Select " . mysql_error());
	$keywords = array();
	
	while ($r_keyword = mysql_fetch_assoc($rs_keyword)) {
		$keywords[] = $r_keyword['description'];
	}
	$tempkeywords = array_chunk($keywords, 20);
	$complaint['keywords'] = implode(", ", $tempkeywords[0]);
}

if (trim($complaint['description']) == '') {
	$complaint['description'] = substr($complaint['complaint_text'], 0, 200);
}

$complaint['page_title'] = $complaint['business_name'] . " - " . $complaint['title'] . " - " . $complaint['business_location'];
include('header.inc');
 ?>

<script type="text/javascript" language="javascript">
	var complaint_id = <?php print $complaint['complaint_id']; ?>;
	function followup() {
		window.location.href="/respond.php?id=" + complaint_id + "&rt=3";
	}
	function response() {
		window.location.href="/respond.php?id=" + complaint_id;

	}
</script>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead' style="width: 480px;">Consumer Complaint / Business Response</h3>
   <div id='complaintsearch' style="margin-top: 5px; width:540px; float:left; border: 1px red solid; padding: 5px 10px 5px 10px;">
   <?php include('view.complaint.inc.php'); ?>
   <?php include('view.buttons.inc.php'); ?>
   <?php if (@mysql_num_rows($rs_comments) > 0) { 
            while ($r_comment = mysql_fetch_assoc($rs_comments)) {
   ?>
   
   <!-- business response begin -->
         <div style="width: 540px; clear:both; float:left; margin-top: 5px; border-top: 1px red solid;">
         <?php include ("view.response.inc.php"); ?>
         </div>
       
       <?php } 
      } ?>
   </div>
   
   <div class="fb-comments" data-href="http://complaintsbbb.com/<?php printf("%s", $complaint['url']);?>" data-num-posts="2" data-width="500"></div>
   
</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
 <h3 class='subhead'>Write a Followup, Response or Comment</h3>
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
<p>&nbsp;&nbsp;<strong>Make your letter brief and to the point.</strong><br/>Include all important facts about your purchase, including the date and place where you made the purchase and any information you can give about the product or service such as serial or model numbers or specific type of service. </p>
<p><div class="fb-facepile" data-href="http://complaintsbbb.com/<?php printf("%s", $complaint['url']);?>" data-width="450" data-max-rows="4"></div></p>
<p><strong>State exactly what you want done</strong><br/> about the problem and how long you are willing to wait to get it resolved. Be reasonable.</p>
<p><strong>Include all documents</strong><br/> using the upload section regarding your problem. If you do not have access to a scanner, send us a fax. </p>
<p><strong>Avoid writing an angry, sarcastic, or threatening</strong><br/> letter. The person reading your letter probably was not responsible for your problem but may be very helpful in resolving it. </p>
</div>
<?php include('footer.inc'); ?>
