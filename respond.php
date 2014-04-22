<?php
session_start();
$complaint = array();
$complaint['page_title'] = 'Lookup &amp; Respond to a complaint';
$complaint['keywords'] = 'Consumer, Complaints, Services, Products, Response, Respond, Lookup';
if (!isset($_SESSION['formfields'])) {
	$_SESSION['formfields'] = array('complaint' => '', 'user_name' => '', 'user_email' => '');	
}
include_once('header.inc'); 
include_once('db.inc.php');

if (isset($_GET['id'])) { 
	 $q = "SELECT c.id, c.title, b.name AS business_name, b.location AS business_location, ct.comment AS complaint_text, UNIX_TIMESTAMP(c.created_date) AS complaint_date, u.name AS user_name  "
   		. "FROM complaint AS c "
   		. "LEFT OUTER JOIN business AS b ON b.id = c.business_id "
		. "LEFT OUTER JOIN user AS u ON u.id = c.author_user_id "
   		. "LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id AND ct.comment_type = 1 "
   		. "WHERE c.id = " . mysql_real_escape_string($_GET['id']);
	$rs = mysql_query($q, $con);

	$complaint = mysql_fetch_assoc($rs);
	if ($complaint) $_SESSION['complaint_id'] = $complaint['id'];
}
?>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead' style="width: 480px;">Respond to a complaint, Win customer satisfaction.</h3>
  <?php if (!isset($_GET['id']) || $complaint === FALSE) { ?>
<div style="border: 1px double black; float:left; padding: 5px 1px 5px 1px; margin: 10px 1px 10px 1px; width: 550px;">
  		<form method='get' action="respond.php">
   			 <div class='formline' style="width:540px; clear: both; float:left;">
        		<?php if ($complaint === FALSE) { ?>
                <div class="textcell" style="width: 540px; text-align:center; color:red;">
        			<b>Complaint <?php print $_GET['id']; ?> not found. Please try again.</b>
        		</div>
                <?php } ?>
             <div class="textcell" style="width: 540px; text-align:center;">
        			Complaint number you wish to respond <input type='text' size="6" name="id" /> &nbsp;<input style='width: 70; font-size: 24px;' type='submit' value='Search' name='Search' />
        		</div>
    		</div>     
        </form>
  </div>
  <?php } else { ?> 	
<div id='complaintsearch' style="margin-top: 5px; width:540px; float:left; border: 1px red solid; padding: 5px 10px 5px 10px;">
	<?php include_once('view.complaint.inc.php'); ?>
</div>
     <form style='width:100%' id="responseform" name="responseform" method="post" action="response-submit.php">
 	<input type='hidden' name='id' value='<?php print $complaint['id']; ?>' />
    <div class="formline" style="clear:both; padding-top: 3px;">
    	<h3 class='subhead'>Your response to above complaint</h3>
    <div class="inputcell" style="width:550px;"><textarea style='width:550px; <?php isset($_SESSION['errfields']['complaint']) ?  print 'background-color:#CCFF99;' : print ''; ?>' cols="40" rows="10" name="complaint" type="text" id="complaint_text" class="textarea" accesskey="c" tabindex="6" /><?php print $_SESSION['formfields']['complaint']; ?></textarea></div></div>
    
    <div style="width: 550px; clear:both; float:left;">
    	<div style='float: left; width: 275px;' class="formline">
        	<div class="labelcell" style="float: left; width: 75px;">Your Name</div>
            <div class="inputcell" style="width:160px;">
            	<input value="<?php print $_SESSION['formfields']['user_name']; ?>" name="user_name" type="text" id="user_name" class="textbox" accesskey="b" tabindex="4" size="30" style="clear:none; width:175px; <?php isset($_SESSION['errfields']['user_name']) ? print 'background-color:#CCFF99;' : print ''; ?>" /> 
             </div>
        </div>
    	<div style='float: left; width: 275px;' class="formline">
        	<div class="labelcell" style="width: 60px;">Email</div>
            <div class="inputcell" style="width: 200px;">
            	<input value="<?php print $_SESSION['formfields']['user_email']; ?>" name="user_email" type="text" id="user_email" class="textbox" style="clear: none; width:200px; <?php isset($_SESSION['errfields']['user_email']) ? print 'background-color:#CCFF99;' : print ''; ?>" accesskey="l" tabindex="5" size="30" /> 
            </div>
        </div>
     </div>
     <div class="formline" style="clear: both; text-align:right; margin: 5px 0px 5px 1px;">
    	<?php if (isset($_SESSION['errfields']) && count($_SESSION['errfields']) > 0) { ?>
        <div style="float:left; font-size:12px; padding-top: 3px; color:#FF0000; font-weight:bolder;">Please fillout all fields. Empty fields are marked in Yellow.</div>
        <?php } ?>
        <input onclick='window.location.href="?c=1";' type='button' class="formbutton" value="Clear" />
    	  <input onclick='this.form.submit();' type='button' class="formbutton" value="Submit" />
    </div>
   <div class="formline" style="clear: both; text-align:center; font-size:10px; margin: 5px 0px 5px 1px;">
   	By pressing the submit button you are here by claming that you are a representitive of the above mentioned business. We will be recording your IP address to prosecute who abuse this public service to gain commercial leverage over competitor business. 
    </div>
</form>
<?php } ?>
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

<?php if (isset($complaint['id'])) { ?>
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
<?php } ?>
</div>

<?php include_once('footer.inc'); ?>