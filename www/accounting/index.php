<?php
/**
* Frontpage
*/

include("../common.php");

//get language
$lang = lang();
include("../texts_".$lang.".php");
$text['title'] = $text['accounting'];

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('../../smarty/templates');
$smarty->setCompileDir('../../smarty/templates_c');

$smarty->assign('lang',$lang);
$smarty->assign('text',$text);
$smarty->assign('page','frontpage');
$smarty->display('frontpage.tpl');

?>
