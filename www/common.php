<?php
/**
* common functions
*/

error_reporting(E_ALL);
//error_reporting(0);

//get settings
global $settings;
$settings = json_decode(file_get_contents("../" . $path_to_webroot . "settings.json"));

// put full path to Smarty.class.php
require($settings->smarty_path);
$smarty = new Smarty();
$smarty->setTemplateDir('../../smarty/templates');
$smarty->setCompileDir('../../smarty/templates_c');

//get language
$lang = lang();
include($path_to_webroot . "texts_".$lang.".php");

//get tags
$tags = get_tags();

$smarty->assign('lang',$lang);
$smarty->assign('settings',$settings);
$smarty->assign('tags',$tags);


/**
* reads Journal into array
*/
function get_journal() {
    global $settings;
    $url = $settings->journal_url;
    //$url = "http://localhost/michal/project/f-simple-accounting/dev/journal.json";
    $json = json_decode(file_get_contents($url));
    $data = [];
    foreach($json->feed->entry as $row) {
        $t = '$t';
        $item = [];
        foreach ($row as $key => $it) {
            if (substr($key,0,3) == 'gsx') {
                $item[substr($key,4)] = trim($row->$key->$t);
            }
        }
        $data[] = $item;
    }
    return $data;
}

/**
* reads Tags into associative array
*/
function get_tags() {
    global $settings;
    $url = $settings->tags_url;
    //$url = "http://localhost/michal/project/f-simple-accounting/dev/accounts.json";
    $json = json_decode(file_get_contents($url));
    $data = [];
    foreach($json->feed->entry as $row) {
        $t = '$t';
        $item = [];
        foreach ($row as $key => $it) {
            if (substr($key,0,3) == 'gsx') {
                $item[substr($key,4)] = trim($row->$key->$t);
            }
        }
        $data[trim($row->{'gsx$tag'}->$t)] = $item;
    }
    return $data;
}


/**
* reads Accounts into associative array
*/
function get_accounts() {
    global $settings;
    $url = $settings->accounts_url;
    //$url = "http://localhost/michal/project/f-simple-accounting/dev/accounts.json";
    $json = json_decode(file_get_contents($url));
    $data = [];
    foreach($json->feed->entry as $row) {
        $t = '$t';
        $item = [];
        foreach ($row as $key => $it) {
            if (substr($key,0,3) == 'gsx') {
                $item[substr($key,4)] = trim($row->$key->$t);
            }
        }
        $data[trim($row->{'gsx$number'}->$t)] = $item;
    }
    return $data;
}

/**
* filters Journal entries
* @filter   array of filters
* example: 
* filter = ['since' => '2015-03-01', 'until' => '2015-03-30', 'account' => '22', 'tag' => 'v4']
* note: account '22' includes also '22-CZK'
*/
function filter_journal($data,$filter) {
    $filtered = [];
    foreach ($data as $row) {
        $ok = true;
        if (isset($filter['since']) and $row['date'] < $filter['since'])
            $ok = false;
        if (isset($filter['until']) and $row['date'] > $filter['until'])
            $ok = false;
        if (isset($filter['tag'])) {
            $filter_tags = explode(',',$filter['tag']); 
            $tags = explode(',',$row['tags']);       
            foreach ($tags as $key => $tag) 
                $tags[$key] = sanitize(trim($tag));
            foreach ($filter_tags as $filter_tag) {
                if (!in_array($filter_tag,$tags))
                    $ok = false;
            }
        }
        if (isset($filter['account'])) {
                //we have to divided it, because of accounts like '22-v4' and '22-v4e':
            if (strpos($filter['account'],'-') !== false) {
                if (($row['debit'] != $filter['account']) and ($row['credit'] != $filter['account']))
                    $ok = false;
            } else {
                if ((strpos($row['debit'],$filter['account']) !== 0) and (strpos($row['credit'],$filter['account']) !== 0)) {            
                    $ok = false;
                }
            }
        }
        if (trim($row['amount']) == '')
            $ok = false;

        if ($ok)
            $filtered[] = $row;
    }
    return $filtered; 
}

/**
* finds out if a string begins with substring
*/

/**
 * Function: sanitize
 * Returns a sanitized string, typically for URLs.
 *
 * Parameters:
 *     $string - The string to sanitize.
 *     $force_lowercase - Force the string to lowercase?
 *     $anal - If set to *true*, will remove all non-alphanumeric characters.
 *
 * http://stackoverflow.com/questions/2668854/sanitizing-strings-to-make-them-url-and-filename-safe
 */
function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

/**
* get language
*/
function lang() {
    if (isset($_REQUEST['lang']) and ($_REQUEST['lang'] == 'en'))
        return 'en';
    else //default language
        return 'cs';
}

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

/**
*
*/
function clear_request() {
    $allowed = ['since','until','tag','account'];
    $request = [];
    foreach ($_REQUEST as $k => $r) {
        if (in_array($k,$allowed) and (trim($r) != ''))
            $request[$k] = $r;
    }
    return $request;
}

//$journal = get_journal();
//$filtered = filter_journal($journal, array('account' => '22-CZK'));
//print_r($filtered);
/*$accounts = get_accounts();
print_r($accounts);*/

?>
