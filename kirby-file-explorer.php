<?php
$plugin_name = 'kirby-file-explorer';
include kirby()->roots()->plugins() . DS . $plugin_name . DS . 'routes-class.php';
include kirby()->roots()->plugins() . DS . $plugin_name . DS . 'breadcrumb-class.php';
include kirby()->roots()->plugins() . DS . $plugin_name . DS . 'routes.php';

$kirby->set('field', 'explorer',  __DIR__ . DS . 'field');

//$test = 'C:\wamp\www\kirby-file-explorer';
//$aaa = rawurlencode($test);
#echo $aaa;
#echo rawurlencode('C:\some\path\with\a\file\filename@.txt');
#echo utf8_decode($decode);

#echo http_build_query($data);