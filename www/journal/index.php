<?php
/**
* Journal
* parameters:
* since, until, tag, account
* 
*/

include("../common.php");

//get language
$lang = lang();
include("../texts_".$lang.".php");
$text['title'] = $text['journal'];
$text['brand'] = $text['brand'];

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('../../smarty/templates');
$smarty->setCompileDir('../../smarty/templates_c');

//get data
$request = clear_request();
$request['page'] = 'journal';
$r = file_get_contents(form_api_address(). "/?" . http_build_query($request));
$data = json_decode($r);

$smarty->assign('lang',$lang);
$smarty->assign('text',$text);
$smarty->assign('data',$data);
$smarty->assign('filter',$_REQUEST);
$smarty->assign('page','journal');
$smarty->display('journal.tpl');

?>
