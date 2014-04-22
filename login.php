<?php 
session_start();
include_once('db.inc.php');

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
	session_destroy();
	session_regenerate_id(true);
	header("Location: /");
	exit;	
}

if (isset($_GET['verify']) && isset($_GET['key'])) {
	$verified = false;
	$q = "SELECT id FROM user WHERE verified = 0 AND verifykey = '" . mysql_real_escape_string($_GET['key']) . "'";
	$rs = mysql_query($q, &$con);
	if (mysql_num_rows($rs) == 1) {
		$r = mysql_fetch_assoc($rs);
		$q = "UPDATE user SET active = 1, verified = 1 WHERE id = " . $r['id'];
		mysql_query($q, &$con);
	 	$verified = true;
	}
	
	if ($verified) {
		$_SESSION['auth'] = 1;
		$_SESSION['user_id'] = $r['id'];
		header("Location: /myaccount.php");
		exit;
	}
}

if (count($_POST) > 0) { 
	$fields = array('user_email', 'user_password');
	$error = false;
	foreach ($fields as $field) {
		if (isset($_POST[$field]) && $_POST[$field] != "") continue;
		$_SESSION['errfield'][$field] = 1;	
		$error = true;
	}
	
	if (!$error) {
		$q = "SELECT id, name, email FROM user WHERE email = '" . mysql_real_escape_string($_POST['user_email']) . "' AND pass = PASSWORD('" . mysql_real_escape_string($_POST['user_password']) . "')";
		$rs = mysql_query($q, &$con);
		if (mysql_num_rows($rs) == 1) {
			$r = mysql_fetch_assoc($rs);
			$_SESSION['auth'] = 1;
			$_SESSION['user_id'] = $r['id'];
			$_SESSION['name'] = $r['name'];
			$_SESSION['email'] = $r['email'];
			
			header("Location: /myaccount.php");
			exit;
		}
	}
	
	
}
include_once('header.inc'); ?>

<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>Login to My Complaints Portal</h3>
      <div 
        class="fb-registration" 
        data-fields="[{'name':'name'}, {'name':'email'},
          {'name':'favorite_car','description':'What is your favorite car?',
            'type':'text'}]" 
        data-redirect-uri="http://complaintsbbb.com/register.php"
      </div>
 <form style='width:100%' id="loginform" name="loginform" method="post" action="login.php">
    <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Email:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_email']; ?>" name="user_email" type="text" id="user_email" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_email']) ? print 'background-color:#CCFF99;' : print ''?>" />
        </div>
    </div>
     <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'>Password:</div>
        <div class="inputcell" style="width: 475px;">
        	<input value="<?php print $_SESSION['formfields']['user_password']; ?>" name="user_password" type="password" id="user_password" class="textbox" accesskey="t" tabindex="1" style="width: 470px; <?php isset($_SESSION['errfields']['user_password']) ? print 'background-color:#CCFF99;' : print ''; ?>" />
        </div>
    </div>
     <div class='formline' style="width:550px; clear: both; float:left;">
    	<div class="labelcell" style='width: 60px;'></div>
        <div class="inputcell" style="width: 475px;">
        	<input type='button' value='Cancel'> <input type='button' value='Login' onClick="this.form.submit();"> <br />
            [<a href=''>Forgot Password</a>]
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