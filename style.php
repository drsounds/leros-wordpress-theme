<?php
// From https://wordpress.org/support/topic/dynamic-stylesheet
require('lessc.php');
require_once('../../../wp-load.php');

$style = 'light';

$fil = fopen($style . '.less', 'rb');
$less = fread($fil, filesize($style . '.less'));
fclose($fil);


$lessc = new lessc;
$lessc->setVariables(array('brand-primary' => get_theme_mod('primary_color')));
$lessc->setVariables(array('brand-secondary' => get_theme_mod('secondary_color')));
header('Content-type: text/css');
echo $lessc->compile($less);

// Get taxonomy colors
$fil = fopen('dynamic.less', 'rb');
$less = fread($fil, filesize('dynamic.less'));
fclose($fil);

$categories = get_categories();
foreach($categories as $c):
    $category = get_category($c);
    $color = get_option('custom_taxonomy_meta_', $c);
    $color = $color->color;   
    if (empty($color)) {
        $color = get_theme_mod('primary_color');
    }
    $lessc->setVariables(array('brand-primary' => $color));
    $css = $lessc->compile($less);
    $css = str_replace('cat_id', $category->cat_ID, $css);
    echo $css;
endforeach;