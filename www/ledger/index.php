<?php
/**
* General Ledger
* parameters:
* since, until, tag, account
* 
*/

//echo realpath("../");

//print_r($_SERVER);die();

include("../common.php");

//get language
$lang = lang();
include("../texts_".$lang.".php");
$text['title'] = $text['ledger'];
$text['brand'] = $text['brand'];

// put full path to Smarty.class.php
require('/usr/local/lib/php/Smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir('../../smarty/templates');
$smarty->setCompileDir('../../smarty/templates_c');

//get data
$r = file_get_contents(form_api_address(). "/?" . http_build_query($_REQUEST));
$data = json_decode($r);

$smarty->assign('lang',$lang);
$smarty->assign('text',$text);
$smarty->assign('data',$data);
$smarty->assign('filter',$_REQUEST);
$smarty->assign('page','ledger');
$smarty->display('ledger.tpl');



/**
* creates api URL using known relative path
*/
function form_api_address() {
    $phpself = explode('/',$_SERVER['PHP_SELF']);
    array_pop($phpself);
    array_pop($phpself);
    $out = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . implode('/',$phpself) . '/api';
    return $out;
}



?>
