<?php if ($r_comment['comment_type'] == 1) { ?>
<h3 style="text-align:center; text-decoration:underline;">Business Response to Complaint #<?php print $complaint['id']; ?></h3>
<?php } else { ?>
<h3 style="text-align:center; text-decoration:underline;">Community Response to Complaint #<?php print $complaint['id']; ?></h3>

<?php } ?>
	<h4 style="text-align:right">
		<?php if (isset($r_comment['user_name'])) print $r_comment['user_name']; else print $_POST['user_name']; ?><br/> 
     <?php if ($r_comment['comment_type'] == 1) { ?>
      	Customer Relations Manager<br/>
      	<?php print $complaint['business_name']; ?><br/>
		<?php print $complaint['business_location'];?><br/>
	 <?php } else { ?>
		Consumer Activist<br/>
	 <?php } ?>
	 <?php print @date('Y-m-d'); ?>
	</h4>
	<h4 style="text-align:left"><?php print $complaint['user_name']?></h4>
<h3 style="text-align:center; text-decoration:underline;">RE: <?php print $complaint['title']; ?></h3>
<p style="text-align:justify"><em>Dear <?php print $complaint['user_name']; ?>,<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?php print (nl2br(stripslashes((isset($r_comment['comment_text'])) ? $r_comment['comment_text'] : $_POST['complaint']))); ?></em></p>
<h4 style="text-align:right">Yours Sincerly<br/><?php print (isset($r_comment['user_name']) ? $r_comment['user_name'] : $_POST['user_name']); ?></h4>