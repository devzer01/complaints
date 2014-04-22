<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	//global $complaint;
	if (isset($complaint) && $complaint['page_title'] != '') { ?>
<title><?php print $complaint['page_title']; ?></title>
<?php } else { ?>
<title>Consumer Complaints Business Bulletin Board</title>
<?php } ?>
<!-- Dont forget all the required meta tags stuff -->
<!-- We should seperate out two values for title and description -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="verify-v1" content="PRFHkej076Av0tWX9CBc1+Xt1x5ccb+ZA3lzUIaYsao=" />
<meta name="google-site-verification" content="iKHlTjyR2kQCM_fX-xlaBoVE5iopM9YvUUfKfANJTYU" />
<meta property="fb:admins" content="562830016" />
<meta property="fb:page_id" content="269650196401426" />
<?php 
if (!isset($index)) $index = true;

if ($index == true) { 
	$robots[] = 'index';
} else {
	$robots[] = 'noindex';
}

if ($follow == true) {
	$robots[] = 'follow';
} else {
	$robots[] = 'nofollow';
}

$robots = implode(",", $robots);
?>
<meta name="robots" content="<?php echo $robots; ?>">
<meta name="language" content="en-us">
<?php 
	if (isset($complaint['description']) && isset($complaint['keywords'])) { ?>
<meta name="keywords" content="<?php print $complaint['keywords']; ?>" />
<meta name="description" content="<?php print $complaint['description']; ?>" />
<?php } else { ?>
<meta name="keywords" content="complaints business bulletin board, bulletinboard, collection, credit, debt, banks, politicians, government, reviews, feedback, satisfaction, fraud, research, counterfit, resolutions, problems, sucks, scam, ripoff, scam, warrenty, damaged, insurance, flood" />
<meta name="description" content="We are here to provide you a community stage to voice your concerns to the public. let us all help each other for a better world. we will not delete any legitimate complaints unless requested with written request by both parties involved and verified." />
<?php } ?>
<meta name="distribution" content="global">
<meta name="page-topic" content="home">
<meta name="page-type" content="home">
<meta name="rating" content="general">
<meta name="classification" content="consumer">
<meta name="copyright" content="2011 Consumer Complaint Business Bulletin Board">
<meta name="msvalidate.01" content="184722F3D4E452CA7862AF90225AFC0C" />
<style type="text/css">
.title {
	text-align: center;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 30px;
	margin: 0px;
	padding: 0px;
}
.footer {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 10px;
	text-align: center;
}
.body {
	font-size: 12px;
}
.body {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
#form1 label {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 14px;
}
.searchbox {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.body {
	//text-align: center;
}
.formline {
	font-size:14px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.labelcell {
	float: left;
	margin: 5px 5px 5px 1px;
	padding-top: 5px;
	font-weight: 900;
	color: #000000;
	text-align: left;
}
.textbox {
	font-size:14px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

.textarea {
	font-size:14px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

.formbutton {
	font-size:16px;
	width: 100px;
	height: 40px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.inputcell {
	float: left;
	margin: 5px 0px 5px 1px;
}
.textcell {
	padding: 5px 0px 0px 10px; 
	float: left;
	margin: 5px 0px 5px 1px;
}
h3 {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 18px;
	text-align: left;
}
h3.subhead {
	color:#CC0000;
	width: 375px;	
}

.navbar A:link { 
	text-decoration:none;
	color: #FFFFFF;
}

.navbar A:visited { 
	text-decoration:none;
	color: #FFFFFF;
}


.navbar A:hover {
	color: #FF0000;
}
</style>
</head>

<body>
<div id="fb-root"></div>
<script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '255297464519723',
            status     : true, 
            cookie     : true,
            xfbml      : true
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
<div class='body' id='content' style="width: 99%;">
<div style="margin-top: 5px; text-align: right; width:99%; height:20px;">
<?php if (!isset($_SESSION['user_id'])) { ?>
<div class="fb-login-button" data-perms="email,user_checkins">Login with Facebook</div>
<?php } else { ?>
[ <a href='/myaccount.php'>My Account</a> ] [ <a href='/login.php?logout=1'>Logout</a> ] 
<?php } ?>
</div>
<h1 class="title" style="color:#CC0000">Consumer Complaints Business Bulletin Board</h1>
<div style="text-align: center; margin-top: 5px; background-color:#FF6600; width:99%; height:23px;">
	<div style="background-color: #FFFFFF; height: 100%; width:30px; float: left;">&nbsp;</div>
    <div style="text-align: center; float: left; width: 75px; height:84%; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;">
    <span class='navbar'><a href='/'>Home</a></span></div>
     <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href='/complain.php'>Complain</a></span></div>
      <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href="/respond.php">Respond</a></span></div>
    <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href="/browse.php">Browse</a></span></div>
    <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href="/faq.php">FAQ</a></span></div>
        <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href="/about.php">About</a></span></div>
    <div style="text-align: center; float: left; width: 75px; height:84%; margin-left: 4px; padding: 2px; background-color: #660099; color:#FFFFFF; font-weight:bolder;"><span class='navbar'><a href="/contact.php">Contact</a></span></div>
    <div style="float: left; width: 35px;">&nbsp;</div>
    <div style="float: left; height: 84%; margin-top: 1px;">
    	<form action="http://complaintsbbb.com/search.php" id="cse-search-box">
    <input type="hidden" name="cx" value="partner-pub-4431395448791719:2079226408" />
    <input type="hidden" name="cof" value="FORID:11" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="50" />
    <input type="submit" name="sa" value="Search" />
</form>
<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
    </div>
</div>
<div class='body' id='margin' style='clear:both; width:5%; float: left;'>&nbsp;
</div>
