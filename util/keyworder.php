<?php

include_once('../lib/class.stemmer.inc.php');

$stopwords = array('a','able','about','across','after','all','almost','also','am','among','an','and','any','are','as','at','be','because','been','but','by','can','cannot','could','dear','did','do','does','either','else','ever','every','for','from','get','got','had','has','have','he','her','hers','him','his','how','however','i','if','in','into','is','it','its','just','least','let','like','likely','may','me','might','most','must','my','neither','no','nor','not','of','off','often','on','only','or','other','our','own','rather','said','say','says','she','should','since','so','some','than','that','the','their','them','then','there','these','they','this','tis','to','too','twas','us','wants','was','we','were','what','when','where','which','while','who','whom','why','will','with','would','yet','you','your', 'sure', 'ad', 'up');

$pronouns = array('all','another','any','anybody','anyone','anything','both','each','each other','either','everybody','everyone','everything','few','he','her','hers','herself','him','himself','his','it','its','itself','little','many','me','mine','more','most','much','my','myself','neither','no one','nobody','none','nothing','one','one another','other','others','our','ours','ourselves','several','she','some','somebody','someone','something','that','their','theirs','them','themselves','these','they','this','those','us','we','what','whatever','which','whichever','who','whoever','whom','whomever','whose','you','your','yours','yourself','yourselves', 'issu', 'give');


function get_keywords($words) {
	
	global $stopwords;
	global $pronouns;

	$word_array = explode(" ", $words);

	$filter = array_diff($word_array, $stopwords, $pronouns);

	$stemmer = new Stemmer();
	
	$keywords = array_unique($stemmer->stem_list($filter));
	
	$keywords = array_diff($keywords, $stopwords, $pronouns);

	return $keywords;
}

?>