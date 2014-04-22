<?php 
session_start();
$landing_page = true;
if (isset($_GET['c']) && $_GET['c'] == 1) { 
	unset($_SESSION['formfields']);
	unset($_SESSION['errfields']);
}
include_once('db.inc.php');
include_once('header.inc'); 

?>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>Most recent complaints</h3>
<?php include_once('browse.inc');?>
</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 450px; float:left">
<h3 class='subhead'>Unsatisfied with a business dealing?</h3>
<p>&nbsp;&nbsp;Well you have come to the right place to take the first step towards resolving your issue. We are commited to provide you with the best available tools to reach out to your business associates to resolve the issue you are facing. </p>
<h3 class='subhead'>Social Network Integrated?</h3>
<p>We are commited to share your message with a globe full of consumers through our integrated social networks.</p>
<p><div class="fb-like" data-href="http://www.facebook.com/consumeristjury" data-send="true" data-width="450" data-show-faces="true" data-action="recommend" data-font="arial"></div></p>
<p>If you do not receive a satisfactionary response from the business in question we will assist you with filing a report to the local Better Business Buearu(R). </p>
<h3 class='subhead'>Free Membership!</h3>
<p>The membership for this site is absolutly free and has no hidden costs involved. Your membership will allow you to keep your self up to date with happenings in your neighborhood, Post a complaint or search for other complaints.</p>
<h3 class='subhead'>Business Owner/Representative?</h3>
<p> If your are someone who is representing a business feel free to check your business listing in the business directory, if there is an existing complaint regarding your business please be sure to post a response.</p>
</div>
<?php include_once('footer.inc'); ?>
