<?php
/**
* common functions
*/

error_reporting(E_ALL);
//error_reporting(0);

/**
* reads Journal into array
*/
function get_journal() {
    $url = "https://spreadsheets.google.com/feeds/list/1dyyZUyLlKIc1U79qCmKMU4BGKUeZsyB68i2RRSd2bXY/1/public/full?alt=json";
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
* reads Accounts into associative array
*/
function get_accounts() {
    $url = "https://spreadsheets.google.com/feeds/list/1dyyZUyLlKIc1U79qCmKMU4BGKUeZsyB68i2RRSd2bXY/2/public/full?alt=json";
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
            $tags = explode(',',$row['tags']);
            foreach ($tags as $key => $tag) 
                $tags[$key] = sanitize(trim($tag));
            if (!in_array($filter['tag'],$tags))
                $ok = false;
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

//$journal = get_journal();
//$filtered = filter_journal($journal, array('account' => '22-CZK'));
//print_r($filtered);
/*$accounts = get_accounts();
print_r($accounts);*/

?>
