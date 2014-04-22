<?php 
$index  = false;
$follow = true;
include_once('header.inc'); 
include_once('db.inc.php');
?>
<div class="body" id='complaintsearch' style="width:550px; float:left">
<h3 class='subhead'>Browse Consumer Complaints</h3>
<?php 
	$qry = "SELECT max(created_date) as maxdate, min(created_date) as mindate FROM complaint";
	$rs = mq($qry);
	$r = mysql_fetch_assoc($rs);
	
	$maxdate = date_parse($r['maxdate']);
	$mindate = date_parse($r['mindate']);
	
	$months = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'Augest', 'September', 'October', 'November', 'December');
	
	for ($year=$mindate['year']; $year<= $maxdate['year']; $year++) {
		for($month=1; $month<=12; $month++) {
			if ($year == $mindate['year'] && $month < $mindate['month']) continue;
			if ($year == $maxdate['year'] && $month > $maxdate['month']) break;?>
			
			<?php if ($month==1 || $month % 4 == 0) printf("<div style='width: 550px;'>");?>
			<?php 
			$start = $year . "-" . $month . "-01";
			$end   = $year . "-" . $month . "-31";
			$sql  =  "SELECT count(*) as count FROM complaint WHERE created_date BETWEEN '" . $start . "' AND '" . $end . "'"; 
			$rs = mq($sql); 
			$r = mysql_fetch_assoc($rs);
			?>
				<div style='float:left; margin: 5px; padding: 10px; width:100px;'><?php printf("<a href='/browse.php?year=%d&month=%d'>%s</a> (%d)", $year, $month, $months[$month], $r['count']);?></div>
			<?php if ($month==1 || $month % 4 == 0) printf("</div>");?>
			
<?php		}
	} ?>
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
