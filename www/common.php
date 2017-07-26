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

//get year
global $ysettings, $year;
if (isset($_GET['y'])) {
    $year = $_GET['y'];
    foreach ($settings->years as $syear){
        if ($syear->year == $year)
            $ysettings = $syear;
    }
    if (!isset($ysettings))
        $ysettings = $settings->years[0];
} else {
    $year = $settings->years[0]->year;
    $ysettings = $settings->years[0];
}

//get tags
$tags = get_tags();

$smarty->assign('lang',$lang);
$smarty->assign('settings',$settings);
$smarty->assign('tags',$tags);
$smarty->assign('ysettings',$ysettings);
$smarty->assign('year',$year);


/**
* reads Journal into array
*/
function get_journal() {
    global $ysettings;
    $url = $ysettings->journal_url;
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
* reads ledger into array
*/
function get_ledger($filtered, $accounts, $accs) {
    $data = ['super' => [], 'main' => [], 'analytical' => []];
    if (isset($_REQUEST['account']) and (isset($accs[trim($_REQUEST['account'])]))) {
        $data = sort_accounts($data, $filtered, $accs[trim($_REQUEST['account'])], $accs);
    } else {
        foreach ($accounts as $account) {
            $data = sort_accounts($data, $filtered, $account, $accs);
        }
    }
    return $data;
}

/**
* reads balance into array
*/
function read_balance_profit_loss($what) {
    global $ysettings;
    $url = $ysettings->$what;
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
    foreach($data as $k=>$item) {
        $data[$k]['level'] = strlen($data[$k]['code']);
        $data[$k]['accounts'] = [
            'full' => [],
            'positive' => [],
            'negative' => []
        ];
        $data[$k]['value'] = 0;
        $data[$k]['previous_value'] = 0;
    }
    return $data;
}

/**
* calculates final
*/
function calc_final($d) {
    return $d['debit'] - $d['credit'] + $d['start'];
}


/**
* adds codes of accounts to balance
*/
function add_codes_balance($ledger, $balance, $code) {
    foreach($balance as $k=>$item) {
        foreach($ledger['main'] as $row) {
            $balance_codes = explode(',', $row['account'][$code]);
            if ((count($balance_codes) > 1) or (strlen($balance_codes[0]) > 0)) {
                foreach($balance_codes as $bc) {
                    if ($item['code'] == substr($bc, 0, strlen($item['code']))) {
                        // print_r([$item, $row['account'], $bc]);
                        $last_char = substr($bc, -1);
                        $final = calc_final($row['sums']);
                        $previous = $row['sums']['start'];
                        if (in_array($last_char, ['+','-'])) {
                            if ($last_char == '+') {
                                $balance[$k]['accounts']['positive'][] = $row['account']['number'];
                                if ($final > 0) {
                                    $balance[$k]['value'] += $final;
                                }
                                if ($previous > 0) {
                                    $balance[$k]['previous_value'] += $previous;
                                }
                            } else {
                                $balance[$k]['accounts']['negative'][] = $row['account']['number'];
                                if ($final < 0) {
                                    $balance[$k]['value'] += $final;
                                }
                                if ($previous < 0) {
                                    $balance[$k]['previous_value'] += $previous;
                                }
                            }
                        } else {
                            $balance[$k]['accounts']['full'][] = $row['account']['number'];
                            $balance[$k]['value'] += $final;
                            $balance[$k]['previous_value'] += $previous;
                        }
                    }
                }
            }
        }
    }
    return $balance;
}

/**
* gets last and first day
*/
function get_days($year, $request) {
    if (isset($request['until'])) {
        $until_arr = explode('-', $request['until']);
        $until = mktime(23, 59, 59, $until_arr[2], $until_arr[1], $until_arr[0]);
    } else {
        $until = mktime(23, 59, 59, 12, 31, $year);
    }
    if (isset($request['since'])) {
        $since_arr = explode('-', $request['since']);
        $since = mktime(0, 0, 0, $since_arr[2], $since_arr[1], $since_arr[0]);
    } else {
        $since = mktime(0, 0, 0, 1, 1, $year);
    }
    $today = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
    if ($today < $until) {
        $until = $today;
    }
    return [
        'since' => $since,
        'until' => $until
    ];
}

/**
* reads Tags into associative array
*/
function get_tags() {
    global $ysettings;
    $url = $ysettings->tags_url;
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
    global $ysettings;
    $url = $ysettings->accounts_url;
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
