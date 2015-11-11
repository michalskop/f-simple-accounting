<?php
/**
* Frontpage
*/

$path_to_webroot = "../";

include($path_to_webroot . "common.php");

$text['title'] = $text['accounting'];

$smarty->assign('text',$text);
$smarty->assign('page','frontpage');
$smarty->display('frontpage.tpl');

?>
