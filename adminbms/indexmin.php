<?php
session_start();
date_default_timezone_set("UTC");
include_once('admin.db.inc.php');

	if (isset($_POST['siteid'])) {
		switch($_POST['siteid']) {
			case "1":
				$_SESSION['siteid'] = 1;
				break;
			default:
				break;
		}
	}
	
	if (isset($_SESSION['siteid'])) {
		$q = "SELECT id, title, created_date, posted, active FROM complaint";
		$rs_items = mysql_query($q, $adbcon) or die("Error on selecting items" . mysql_error());
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>BMS Management</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="indexmin.php">
  <label for="siteid">Select Blog</label>
  <select name="siteid" id="siteid">
  	<?php 
		$q = "SELECT id, name FROM bms_master";
		$rs_sitelist = mysql_query($q, $adbcon) or die("Error on Selecting BMS site list " . mysql_error());
		while ($r_site = mysql_fetch_assoc($rs_sitelist)) {
			echo "<option value='" . $r_site['id'] . "'>" . $r_site['name'] . "</option>";
		}
	?>
  </select> <input type="submit" value="submit" />
</form> <span><?php print date("Y-m-d");?><span id='sp_hours'><?php print date("H");?></span>:<span id='sp_minutes'><?php print date("i"); ?></span>:<span id='sp_seconds'><?php print date("s");?></span></span>
<table width="700">
	<tr>
   	<td>ID</td>
   	<td>Title</td>
      <td>Created Date</td>
      <td>Posted</td>
      <td>Active</td>
      <td>Keywords</td>
      <td>Description</td>
      <td>Repost</td>
      <td>Delete</td>
   </tr>
   <form method="post" action="repost.php">
	<?php while ($r_item = mysql_fetch_assoc($rs_items)) { 	?>
	<tr>
    	  <td><?php print $r_item['id']; ?></td>
        <td><input type='text' size='40' name='title_<?php print $r_item['id'];?>' value='<?php print $r_item['title']; ?>' /></td>
        <td><?php print $r_item['created_date']; ?></td>
        <td><?php print $r_item['posted']; ?></td>
        <td><?php print $r_item['active']; ?></td>
        <td><a target='new' href="keywords.php?id=<?php print $r_item['id']; ?>">Edit</a></td>
        <td><a target='new' href="description.php?id=<?php print $r_item['id']; ?>">Edit</a></td>
        <td><input type='checkbox' name='repost_<?php print $r_item['id']; ?>' /></td>
         <td><input type='checkbox' name='del_<?php print $r_item['id']; ?>' /></td>
    </tr>
    <?php } ?>
	<tr><td colspan='9' style='text-align: right;'>
		<span><?php print date("Y-m-d H:i:s"); ?> </span>
      <input type='submit' value='Repost Selected' />
      <input type='hidden' name='savetitle' id='savetitle' value='0' />
      <input type='button' value='Save Titles' onclick='document.getElementById("savetitle").value=1;this.form.submit();' />
       </td></tr>
    </form>
</table>
<script>
	var jq = document;
	var sp_seconds = jq.getElementById('sp_seconds');
	var sp_minutes = jq.getElementById('sp_minutes');
	var sp_hours   = jq.getElementById('sp_hours');
	
	setTimeout(settime, 1000);
	
	function settime() {
		var isec = parseInt(sp_seconds.innerHTML.valueOf());
		var imin = parseInt(sp_minutes.innerHTML.valueOf());
		var ihrs = parseInt(sp_hours.innerHTML.valueOf());
		
		if (++isec == 60) {
			isec = 0;
			imin++;
		} 
		
		if (imin == 60) {
			imin = 0;
			ihrs++;	
		}
		
		if (ihrs == 24) {
			ihrs = 0; //increment i day	
		}
		
		if (isec < 10) {
			sp_seconds.innerHTML.valueOf("0" + String(isec));
		} else {
			sp_seconds.innerHTML.valueOf(String(isec));
		}
		
		if (imin < 10) {
			sp_minutes.innerHTML = "0" + String(imin);
		} else {
			sp_minutes.innerHTML = String(imin);
		}
		
		setTimeout(settime, 1000);
	}
	
</script>
</body>
</html>