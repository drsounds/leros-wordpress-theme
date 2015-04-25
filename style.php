<?php
// From https://wordpress.org/support/topic/dynamic-stylesheet
require('lessc.php');
require_once('../../../wp-load.php');

$fil = fopen('style2.less', 'rb');
$less = fread($fil, filesize('style2.less'));
fclose($fil);


$lessc = new lessc;
$lessc->setVariables(array('brand-primary' => get_theme_mod('primary_color')));
header('Content-type: text/css');
echo $lessc->compile($less);