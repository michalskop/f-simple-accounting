<?php
/**
* Journal
* parameters:
* since, until, tag, account
* 
*/

$path_to_webroot = "../";

include($path_to_webroot . "common.php");

$text['title'] = $text['journal'];
$text['brand'] = $text['brand'];

//get data
$request = clear_request();
$request['page'] = 'journal';
$r = file_get_contents(form_api_address(). "/?" . http_build_query($request));
$data = json_decode($r);
$request = clear_request();

$smarty->assign('text',$text);
$smarty->assign('data',$data);
$smarty->assign('filter',$request);
$smarty->assign('page','journal');
$smarty->display('journal.tpl');

?>
