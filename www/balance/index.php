<?php
/**
* Balance Sheet
* parameters:
* since, until, tag, account
*
*/

$path_to_webroot = "../";

include($path_to_webroot . "common.php");

$text['title'] = $text['balance'];

//get data
$request = clear_request();
$days = get_days($year, $request);
$request['page'] = 'balance';
$request['y'] = $year;
$r = file_get_contents(form_api_address(). "/?" . http_build_query($request));
$data = json_decode($r);
$request = clear_request();

$smarty->assign('text',$text);
$smarty->assign('data',$data);
$smarty->assign('filter',$request);
$smarty->assign('days',$days);
$smarty->assign('page','balance');
$smarty->display('balance.tpl');

?>
