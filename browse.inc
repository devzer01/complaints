<?php 
	$where = '';
	$qry   = '';
	if (isset($_GET['cat']) && is_numeric($_GET['cat'])) {
		$where = ' AND c.category_id = "' . mysql_real_escape_string($_GET['cat']) . '"';
		$qry   = '&cat=' . $_GET['cat'];
	}
	
	if (isset($_GET['month']) && isset($_GET['year'])) {
		$prefix = mysql_real_escape_string($_GET['year'] . "-" . $_GET['month']);
		$start_date = $prefix . "-01";
		$end_date   = $prefix . "-31";
		$where = ' AND c.created_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" ';
		$qry   = '&month=' . $_GET['month'] . '&year=' . $_GET['year'];
	}
	
	$sql = "SELECT count(*) as cnt FROM complaint AS c WHERE c.active = 1 AND c.posted IS NOT NULL " . $where;
	$rspgae = mysql_query($sql, $con) or die(__FILE__ . ":" . __LINE__ . ":" . mysql_error());
	$rpage = mysql_fetch_assoc($rspgae);
	$numpages = $rpage['cnt'] / 10;
	$page = 0;
	if (isset($_GET['page'])) {
		$page = (($_GET['page'] - 1) * 10) + 1;
	}
	$q = "SELECT c.url, c.title AS complaint_title, b.name AS business_name, b.location AS business_location, u.name AS user_name, ct.comment	 "
         . "FROM complaint AS c "
		 . "LEFT OUTER JOIN business AS b ON b.id = c.business_id "
		 . "LEFT OUTER JOIN user AS u ON u.id = c.author_user_id "
		 . "LEFT OUTER JOIN complaint_text AS ct ON ct.complaint_id = c.id AND ct.comment_type = 1 "  
		 . "WHERE c.active = 1 AND c.posted IS NOT NULL " . $where . " "
		 . "ORDER BY c.created_date DESC "
		 . "LIMIT $page,10";
	$rs = mysql_query($q, $con);
	while ($r = mysql_fetch_assoc($rs)) { 
?>
<li style="margin: 4px 0px 8px 10px; padding:3px 0px 6px 3px;"><strong><a href="<?php print $r['url']; ?>"><?php print $r['complaint_title']; ?></a></strong><br/>
	<div style="text-align:justify; width: 80%; padding-left: 20px; margin: 2px 0px 2px 0px;"><?php print substr($r['comment'], 0, 100); ?></div>
	<div style="text-align:right; padding-right: 40px; margin: 2px 0px 2px 0px;"><em><?php print $r['business_name']; ?> - <?php print $r['business_location']; ?> by <?php print $r['user_name']; ?></em></div></li>
<?php } 
	if (!isset($landing_page)) {
?>
	<div style='width:500px; float: left;'> Pages <?php 
			for ($i=1; $i<=$numpages; $i++) {
				printf("<a href='/browse.php?page=%d%s'>%d</a>&nbsp;&nbsp; ", $i, $qry, $i);
			}
	}
	?></div>