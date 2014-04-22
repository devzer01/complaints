<?php
include_once('lib/secureimage.php');
$image = new Securimage();
$image->gd_font_file = dirname(__FILE__) . "/lib/gdfonts/automatic.gdf";
$image->image_height = 40;
$image->image_width = 200;
$image->image_type = SI_IMAGE_PNG;
//$image->background_directory = './lib/backgrounds/';
$image->use_multi_text = 1;
//$image->multi_text_color = array('CC0000', '660099', '000000'); 
$image->multi_text_color = array(
	new Securimage_Color("#CC0000"), new Securimage_Color("#660099"), new Securimage_Color("#FF6600"), new Securimage_Color("#000000")
);
$image->num_lines = 2;
$image->code_length = 5;
$image->line_color = new Securimage_Color("#cccccc");
$image->show();

?>