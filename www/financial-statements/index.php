<?php
/**
* Finnancil Statements
*
*/

$path_to_webroot = "../";

include($path_to_webroot . "common.php");
include($path_to_webroot . "Parsedown.php");

$text['title'] = $text['attachement'];

foreach($settings->years as $y) {
    if ($year == $y->year) {
        $url = $y->financial_statements_url;
    }
}

$markdown = file_get_contents($url);
$Parsedown = new Parsedown();
$parsed = $Parsedown->text($markdown);

$smarty->assign('text',$text);
$smarty->assign('financial_statements',$parsed);
$smarty->assign('page','financial_statements');
$smarty->display('financial_statements.tpl');
