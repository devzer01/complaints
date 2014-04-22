<?php 
session_start();
$error = false;

function isFormError() {
	$fields = array('user_name', 'user_email', 'user_password', 'user_password_confirm');
	foreach ($fields as $field) {
		if (isset($_POST[$field]) && $_POST[$field] != "") continue;
		$_SESSION['errfields'][$field] = 1;	
	}
	
	if (count($_SESSION['errfields']) == 0) {
		
		if ($_POST['user_password'] != $_POST['user_password_confirm']) {
			$_SESSION['errfields']['user_password'] = 1;
		} else {
			return true;	
		}
	
	return false;	
}

//HANDLE SUBMISSION
if (count($_POST) > 0) {
	include_once('db.inc.php'); 
	
	if (!isFormError()) {
		if (isset($r['prereg'])) { 
				$q = "UPDATE user SET verified = 1, active = 1, pass = PASSWORD('" . mysql_real_escape_string($_POST['user_password']) . "') WHERE id = " . $_SESSION['prereg'];
				mysql_query($q, &$con);
			} else {
				//add the db logic
				//check if email address exisit in the db
				$q = "SELECT count(*) AS isuser FROM user WHERE email = '" . mysql_real_escape_string($_POST['user_email']) . "'";
				$rs = mysql_query($q, &$con);
				$r = mysql_fetch_assoc($rs);
		
				if ($r['isuser'] == 0) {
					//then insert
					$q = "INSERT INTO user (name,email,pass,created_date,ipaddr) "
					   . "VALUES ('" . mysql_real_escape_string($_POST['user_name']) . "', "
					   . "'" . mysql_real_escape_string($_POST['user_email']) . "', "
					   . " PASSWORD('" . mysql_real_escape_string($_POST['user_password']) . "'), NOW(),"
					   . "'" . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . "')";
					$rs = mysql_query($q, &$con) or die(mysql_error());
					$user_id = mysql_insert_id();
					if ($user_id) {
						$verifykey = md5($user_id . $_SERVER['REMOTE_ADDR'] . @date('Ymdhsi'));
						$q = "UPDATE user SET verifykey = '" . $verifykey . "' WHERE id = " . $user_id;
						
						mysql_query($q, &$con);
						
						//send the email 
						$body = "Dear " . $_POST['user_name'] .", "
						. "Thank you for signing up for complaints, verify your email address by clicking the following link "
						. "http://complaintsbbb.com/login.php?verify=1&key=" . $verifykey . " "
						. "Regards ComplaintsBBB Team";
						mail($_POST['user_email'], "Verify Your Email Address", $body);
						
					} 
				} else {
				//user already exist in the database
				$error = true;
				$error_message = "Email Address Already Signed up, Please use forgot password to reset";
				//or add the logic automatically. 
			} //end user create block
		}
	}
		
	} else {
		$error = true;
	}
	
	if ($error) {
		$_SESSION['formfields'] = $_POST;	
	}
}

if (isset($_GET['password']) && $_GET['password'] == 1) { 
		include_once('db.inc.php');
	$q = "SELECT u.id, u.name, u.email FROM user AS u WHERE verified = 0 AND active = 0 AND verifykey = '" . mysql_real_escape_string($_GET['key']) . "'";
	$rs = mysql_query($q, &$con);

	if (mysql_num_rows($rs) == 0) {
		$error = true;
		$error_message = "This account has already been verified";
	} else {
		$r = mysql_fetch_assoc($rs);
		$_SESSION['formfields']['user_name'] = $r['name'];
		$_SESSION['formfields']['user_email'] = $r['email'];
		$_SESSION['prereg'] = $r['id'];
		
	}
	
	

}

include_once('header.inc'); 
?>

<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>Register for My Complaints Portal</h3>

 <form style='width:100%' id="registerform" name="registerform" method="post" action="register.php">
    <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Name:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_name']; ?>" name="user_name" type="text" id="user_name" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_name']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div>
    </div>
    
    <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Email:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_email']; ?>" name="user_email" type="text" id="user_email" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_email']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div>
    </div>
     <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Password:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_password']; ?>" name="user_password" type="password" id="user_password" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_password']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div>
    </div>
    <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Password Confirm:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_password_confirm']; ?>" name="user_password_confirm" type="password" id="user_password_confirm" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_password_confirm']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div>
    </div>
     
     <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'></div>
        <div class="inputcell" style="width: 475px;"> 
			<?php if ($error) { ?> 
				<?php print $error_message; ?>
			<?php } ?>
        	<input type='button' value='Cancel'> <input type='button' value='Login' onClick="this.form.submit();"> <br />
            [<a href='/register.php?forgotpass=1'>Forgot Password</a>]
        </div>
    </div>
 </form>

</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
<h3 class='subhead'>Need Help?</h3>
<p>&nbsp;&nbsp;<strong>Send us an email</strong><br/>
You can find our contact information in this page.</p>
</div>



<?php include_once('footer.inc'); ?>