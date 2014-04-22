<?php 
session_start();
if (!isset($_SESSION['auth']) || !isset($_SESSION['user_id'])) {
	header("Location: /login.php");
	exit;
}
include_once('db.inc.php');
include_once('header.inc'); ?>

<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>My Complaints</h3>

 
</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
<h3 class='subhead'>Using My Complaints?</h3>
<?php
	$q = "SELECT c.title AS complaint_title, b.name AS business_name, b.location AS business_location, u.name AS user_name, ct.comment	 "
         . "FROM complaint AS c "
		 . "LEFT OUTER JOIN business AS b ON b.id = c.business_id "
		 . "LEFT OUTER JOIN user AS u ON u.id = c.author_user_id "
		 . "LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id "  
		 . "WHERE c.author_user_id = " . $_SESSION['user_id'] . " " 
		 . "ORDER BY c.created_date DESC "
		 . "LIMIT 0,20";
	$rs = mysql_query($q, &$con);
	if ($rs !== FALSE) {
	while ($r = mysql_fetch_assoc($rs)) { 
?>
<li style="margin: 4px 0px 8px 10px; padding:3px 0px 6px 3px;"><strong><?php echo $r['complaint_title']; ?></strong><br/>
	<div style="text-align:justify; width: 80%; padding-left: 20px; margin: 2px 0px 2px 0px;"><?php print substr($r['comment'], 0, 100); ?></div>
	<div style="text-align:right; padding-right: 40px; margin: 2px 0px 2px 0px;"><em><?php print $r['business_name']; ?> - <?php print $r['business_location']; ?> by <?php print $r['user_name']; ?></em></div></li>
<?php }} ?>
<p>&nbsp;&nbsp;<strong>Editing Complaints</strong><br/>
Your not allowed to edit a complaint after 24 hours of it posting. You can post a follow up comment once the edit deadline is passed</p>
</div>



<?php include_once('footer.inc'); ?>