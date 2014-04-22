<h3 style="text-align:center; text-decoration:underline;">Complaint #<?php print $complaint['id']; ?><div class="fb-like" data-href="<?php print "http://complaintsbbb.com" . $complaint['url'];?>" data-send="true" data-width="450" data-show-faces="true" data-font="verdana"></div></h3>
	<h4 style="text-align:right">
		<?php print $complaint['user_name']; ?><br/> 
		<?php print @date('Y-m-d', $complaint['complaint_date']); ?>
	</h4>
	<h4 style="text-align:left">Relations Manager<br/><?php print $complaint['business_name']; ?><br/><?php print $complaint['business_location']; ?></h4>
<h3 style="text-align:center; text-decoration:underline;"><?php print $complaint['title']; ?></h3>
<p style='text-align: center;'><?php include('adsense.banner.inc.php'); ?></p>
<p style="text-align:justify"><em>To Whom it may concern,<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?php print nl2br(stripslashes($complaint['complaint_text'])); ?></em></p>
<p style='text-align: center;'><?php include('adsense.banner.inc.php'); ?></p>
<h4 style="text-align:right">Yours Sincerly<br/><?php print $complaint['user_name']; ?></h4>