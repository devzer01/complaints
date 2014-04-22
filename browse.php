<?php 
$index  = false;
$follow = true;
include_once('header.inc'); 
include_once('db.inc.php');
?>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>Browse Consumer Complaints</h3>
<?php 
if (isset($_GET['cat']) || (isset($_GET['month']) && isset($_GET['year']))) { 
	require_once('browse.inc'); 
} else {
	require_once('browse.empty.inc');
}
?>
</div>
<div class='body' id='margin' style='width:45px; float: left;'>&nbsp;
</div>
<div class='body' id='runninglist' style="width: 360px; float:left">
<h3 class='subhead'>Browse by Category</h3>
<?php
	$q = "SELECT c.category_id, description, COUNT(*) AS count "
	   . "FROM complaint AS c "
	   . "LEFT OUTER JOIN category AS ca ON c.category_id = ca.id "
	   . "GROUP BY c.category_id ";
	$rs_cat = mysql_query($q, $con);
	
	while ($r_cat = mysql_fetch_assoc($rs_cat)) { ?>

	<span><a href='/browse.php?cat=<?php print $r_cat['category_id']; ?>'><?php print $r_cat['description']; ?></a>(<?php print $r_cat['count']; ?>)</span>
	
<?php } ?>
<h3 class='subhead'>Browse by Location</h3>
<?php 
	$q = "SELECT b.location, COUNT(*) AS count "
	   . "FROM complaint AS c "
	   . "LEFT OUTER JOIN business AS b ON c.business_id = b.id "
	   . "GROUP BY b.location ORDER BY count LIMIT 20 ";
	$rs_loc = mysql_query($q, $con);
	
	while ($r_loc = mysql_fetch_assoc($rs_loc)) { ?>

	<span><?php print $r_loc['location']; ?>(<?php print $r_loc['count']; ?>)</span>
	
<?php } ?>
<h3 class='subhead'>Browse by Tags</h3>
<?php
	$q = "SELECT description, COUNT(*) AS count "
	   . "FROM complaint AS c "
	   . "LEFT OUTER JOIN category AS ca ON c.category_id = ca.id "
	   . "GROUP BY c.category_id ";
?>
<h3 class='subhead'>Popular Queries</h3>
<script type="text/javascript" src="http://www.google.com/cse/query_renderer.js"></script>
<div id="queries"></div>
<script src="http://www.google.com/cse/api/partner-pub-4431395448791719/cse/2079226408/queries/js?oe=UTF-8&amp;callback=(new+PopularQueryRenderer(document.getElementById(%22queries%22))).render"></script>

</div>


<?php include_once('footer.inc'); ?>
