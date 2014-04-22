<?php
include_once('db.inc.php');

$ip_addr = $_SERVER['REMOTE_ADDR'];
//unset($_SESSION['formfields']);
if (!isset($_SESSION['formfields'])) {
	$_SESSION['formfields'] = array('title' => '', 
								    'business_name' => '', 
									'business_location' => '', 
									'user_name' => '', 
									'user_email' => '', 
									'complaint' => '');	
}

$q = "SELECT l.city, c.description AS country "
   . "FROM ip_block AS b "
   . "LEFT OUTER JOIN ip_location AS l ON l.id = b.location_id "
   . "LEFT OUTER JOIN country AS c ON l.country = c.code "
   . "WHERE b.ipStartNum <= INET_ATON('" . $ip_addr . "') AND b.ipEndNum >= INET_ATON('" . $ip_addr . "') ";

$rs_location = mysql_query($q, $con) or die("Error in geolookup" . mysql_error());
@$r_location = mysql_fetch_assoc($rs_location);
   
$q = "SELECT id, description FROM category ORDER BY description ";
$rs_category = mysql_query($q, $con);



?>
  <form style='width:100%' id="complaintsearchform" name="complaintsearchform" method="post" action="complaint-submit.php">
    <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Subject</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['title']; ?>" name="title" type="text" id="complaint_title" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['title']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div></div>
    <div style="width: 550px; clear:both; float:left;">
    	<div style='float: left; width: 275px;' class="formline">
        	<div class="labelcell" style="float: left; width: 75px;">Business</div>
            <div class="inputcell" style="width:160px;">
            	<input value="<?php print $_SESSION['formfields']['business_name']; ?>" name="business_name" type="text" id="business_name" class="textbox" accesskey="b" tabindex="2" size="30" style="clear:none; width:175px; <?php isset($_SESSION['errfields']['business_name']) ? print 'background-color:#CCFF99;' : print ''; ?>" /> 
             </div>
        </div>
    	<div style='float: left; width: 275px;' class="formline">
        	<div class="labelcell" style="width: 60px;">Location</div>
            <div class="inputcell" style="width: 200px;">
            	<input value="<?php (!isset($_SESSION['formfields']['business_location']) || trim($_SESSION['formfields']['business_location']) == '') ? print $r_location['city'] . ", " . $r_location['country'] : print $_SESSION['formfields']['business_location']; ?>" name="business_location" type="text" id="business_location" class="textbox" style="clear: none; width:200px; <?php isset($_SESSION['errfields']['business_location']) ? print 'background-color:#CCFF99;' : print ''; ?>" accesskey="l" tabindex="3" size="30" /> 
            </div>
        </div>
     </div>
     <div style="width: 550px; clear:both; float:left;">
    	<div style='float: left; width: 275px;' class="formline">
        	<div class="labelcell" style="float: left; width: 75px;">Name</div>
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
     <div style="width: 550px; clear:both; float:left;">
     	
    	<!-- <div class="formline" style='width: 275px; float: left;'>
        	<div class="labelcell" style="width: 60px;">Captcha</div>
        	<div class="inputcell" style="width: 200px;">
            	 <img id="siimage" align="left" style="padding-right: 5px; border: 0" src="/captcha.php?sid=<?php echo md5(time()); ?>" />
			</div>
            <div style="float:left; width: 70px; margin-left: 50px;clear:both;">
            	  <input type="text" class='textbox' name="code" size="8" />
			</div>
            <div style="float:right; width: 100px; margin-top: -10px;">
        <object style='' classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="SecurImage_as3">
			    <param name="allowScriptAccess" value="sameDomain" />
			    <param name="allowFullScreen" value="false" />
			    <param name="movie" value="/lib/securimage_play.swf?audio=/lib/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
			    <param name="quality" value="high" />
			
			    <param name="bgcolor" value="#ffffff" />
			    <embed src="/lib/securimage_play.swf?audio=/lib/securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			  </object>
        
        
        <a tabindex="-1" style="border-style: none; margin-top: 10px;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '/captcha.php?sid=' + Math.random(); return false"><img src="/lib/images/refresh.gif" alt="Reload Image" border="0" onclick="this.blur()" /></a>
            </div> -->
  
        <div style='float: left; width: 300px;' class='formline'>
        	<div class="labelcell" style='width: 80px; float:left;'>Category</div>
        	<div class="inputcell" style="width: 200px; float:left; padding-top: 3px;">
            	<select name='category_id' size="4" class='textbox' style="width: 199px;">
                	<?php while ($r_category = mysql_fetch_assoc($rs_category)) { ?>
                    	<option value='<?php print $r_category['id']; ?>'><?php print $r_category['description']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div style='float: left; width: 250px;' class='formline'>
        	<script type="text/javascript"><!--
google_ad_client = "ca-pub-4431395448791719";
/* form */
google_ad_slot = "3387610426";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
        </div>
        </div>
    <div class="formline" style="width: 550px; float: left;">
    	<div class="labelcell" style="width:60px; float: left;">Complaint</div>
    <div class="inputcell" style="float: left;"><textarea style='width:550px; <?php isset($_SESSION['errfields']['complaint']) ?  print 'background-color:#CCFF99;' : print ''; ?>' cols="40" rows="10" name="complaint" type="text" id="complaint_text" class="textarea" accesskey="c" tabindex="6" /><?php print $_SESSION['formfields']['complaint']; ?></textarea></div></div>
    <div class="formline" style="clear: both; float: left; width: 550px; text-align:right; margin: 5px 0px 5px 1px;">
    	<?php if (isset($_SESSION['errfields']) && count($_SESSION['errfields']) > 0) { ?>
        <div style="float:left; font-size:12px; padding-top: 3px; color:#FF0000; font-weight:bolder;">Please fillout all fields. Empty fields are marked in Yellow.</div>
        <?php } else { ?>
        	<!-- <div style='float:left; width: 95%;'>
            <span class='labelcell'>Captcha</span>
            </div>-->
        	<div style='float:left; width: 99%;'>
                <div style='float: right; text-align: right; padding:5px 0px 0px 10px;'>
                	<input onclick='window.location.href="?c=1";' type='button' class="formbutton" value="Clear" />&nbsp;&nbsp;
    				<input onclick='this.form.submit();' type='button' class="formbutton" value="Submit" />
                </div>
             </div>
         <?php } ?>
        
    </div>
</form>
