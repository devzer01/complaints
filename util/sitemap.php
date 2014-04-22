<?php
$sitemap_url = 'http://complaintsbbb.com/sitemap.xml';
$sitemap_submissions = array (
	'http://www.google.com/webmasters/tools/ping?sitemap=' . $sitemap_url,
	'http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=SitemapWriter&url=' . $sitemap_url,
	'http://submission.ask.com/ping?sitemap=' . $sitemap_url,
	'http://www.bing.com/webmaster/ping.aspx?siteMap=' . $sitemap_url
);

$ch = curl_init();

foreach($sitemap_submissions as $url) {

	curl_setopt(&$ch, CURLOPT_URL, $url);
	curl_exec(&$ch);	
}

curl_close($ch);
?>