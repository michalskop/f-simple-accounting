<?php
/*
    API Demo, http://markroland.com/blog/restful-php-api/

    This script provides a RESTful API interface for a web application

    Input:

        $_GET['format'] = [ json | html | xml ]
        $_GET['method'] = []

    Output: A formatted HTTP response

    Author: Mark Roland

    History:
        11/13/2012 - Created

*/

// --- Step 1: Initialize variables and functions

/**
 * Deliver HTTP Response
 * @param string $format The desired HTTP response content type: [json, html, xml]
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($format, $api_response){

    // Define HTTP responses
    $http_response_code = array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found'
    );


    // Set HTTP Response
    header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);

    // Process different content types
    if( strcasecmp($format,'json') == 0 ){

        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');

        // Format data into a JSON response
        $json_response = json_encode($api_response);

        // Deliver formatted data
        echo $json_response;

    }elseif( strcasecmp($format,'xml') == 0 ){

        // Set HTTP Response Content Type
        header('Content-Type: application/xml; charset=utf-8');

        // Format data into an XML response (This is only good at handling string data, not arrays)
        $xml_response = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
            '<response>'."\n".
            "\t".'<code>'.$api_response['code'].'</code>'."\n".
            "\t".'<data>'.$api_response['data'].'</data>'."\n".
            '</response>';

        // Deliver formatted data
        echo $xml_response;

    }else{

        // Set HTTP Response Content Type (This is only good at handling string data, not arrays)
        header('Content-Type: text/html; charset=utf-8');

        // Deliver formatted data
        echo $api_response['data'];

    }

    // End script process
    exit;

}

// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;

// Define whether user authentication is required
$authentication_required = FALSE;

// Define API response codes and their related HTTP response
$api_response_code = array(
    'unknown_error' => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
    'success' => array('HTTP Response' => 200, 'Message' => 'Success'),
    'https_required' => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'),
    'authentication_required' => array('HTTP Response' => 401, 'Message' => 'Authentication Required'),
    'authentication_failed' => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'),
    'invalid_request' => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
    'invalid_response_format' => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);

// Set default HTTP response to unknown_error 'ok'
$response['code'] = 'unknown_error';
$response['status'] = 400;
$response['data'] = NULL;

// --- Step 2: Authorization

// --- Step 3: Process Request

$path_to_webroot = "../";

include $path_to_webroot . "common.php";
//print_r($_REQUEST);die();

global $year;

/**
* calculates sums of debits and credits for given account number
*/
function sum_side($rows,$account_number) {
    $debit = 0;
    $credit = 0;
    $scredit = 0;   //start credit
    $sdebit = 0;    //start debit
    foreach ($rows as $row) {
        if (strpos($account_number,'96') === 0){
            if (strpos($row['debit'],$account_number) === 0)
                $debit += $row['amountczk'];
            if (strpos($row['credit'],$account_number) === 0)
                $credit += $row['amountczk'];
        } else {
            if ((strpos($row['debit'],'96-701') === 0) or (strpos($row['credit'],'96-701') === 0)) {
                if (strpos($row['debit'],$account_number) === 0)
                    $sdebit += $row['amountczk'];
                if (strpos($row['credit'],$account_number) === 0)
                    $scredit += $row['amountczk'];
            } else {
                if ((strpos($row['debit'],'96-702') === 0) or (strpos($row['credit'],'96-702') === 0) or (strpos($row['debit'],'93') === 0) or (strpos($row['credit'],'93') === 0)) {
                    // do nothing
                } else {
                    if (strpos($row['debit'],$account_number) === 0)
                        $debit += $row['amountczk'];
                    if (strpos($row['credit'],$account_number) === 0)
                        $credit += $row['amountczk'];
                }
            }
        }
    }
    return ['credit' => $credit, 'debit' => $debit, 'start' => $sdebit-$scredit];
}

/**
* sort accounts by their category
*/
function sort_accounts($data, $filtered, $account, $accs) {
    global $year;
    $rows = filter_journal($filtered, ['account' => $account['number']]);
    if (count($rows) > 0) {
        $sums = sum_side($rows,$account['number']);
        $month = months();
        $months = [];
        for ($i=$month['start'];$i<=$month['end'];$i++) {
            $rs = filter_journal($rows,['since' => implode('-',[$year,n2($i),'01']), 'until' => implode('-',[$year,n2($i),'31'])]);
            $months[$i] = sum_side($rs,$account['number']);
        }
        $row = ['account' => $accs[$account['number']], 'rows' => $rows, 'sums' => $sums, 'months' => $months];
        //super accounts, main accounts vs. analytical ones
        if (strpos($account['number'],'-') === false) {
            if ($account['number'] < 10)
                $data['super'][] = $row;
            else
                $data['main'][] = $row;
        } else {
            $data['analytical'][] = $row;
        }
    }
    return $data;
}

/**
*
*/
function n2($n) {
    if ($n < 10)
        return '0' . $n;
    else
        return $n;
}

/**
* find suitable months
*/
function months() {
    global $year;
    if ($year == (int) date("Y")) {
        if (isset($_REQUEST['since'])) {
            $s = explode('-',$_REQUEST['since']);
            $start = (int) $s[1];
        } else {
            $start = '1';
        }
        if (isset($_REQUEST['until'])) {
            $u = explode('-',$_REQUEST['until']);
            $end = (int) $u[1];
        } else {
            $end = date('n');
        }
    } else {
        $start = '1';
        $end = '12';
    }
    return ['start' => $start, 'end' => $end];
}


$journal = get_journal();
$accounts = get_accounts();
$filtered = filter_journal($journal, $_REQUEST);
    //prepare accounts for easier access:
$accs = [];
foreach ($accounts as $account) {
    $accs[$account['number']] = $account;
}

if (isset($_REQUEST['page']) and ($_REQUEST['page'] == 'ledger')) { //ledger
    $data = ['super' => [], 'main' => [], 'analytical' => []];
    if (isset($_REQUEST['account']) and (isset($accs[trim($_REQUEST['account'])]))) {
        $data = sort_accounts($data, $filtered, $accs[trim($_REQUEST['account'])], $accs);
    } else {
        foreach ($accounts as $account) {
            $data = sort_accounts($data, $filtered, $account, $accs);
        }
    }
} else { //journal, default
    $data = $filtered;
    foreach ($data as $k => $row) {
        $data[$k]['debit_name'] = $accs[$row['debit']]['name'];
        $data[$k]['credit_name'] = $accs[$row['credit']]['name'];
    }
}
//print_r($data);
$response['code'] = 'success';
$response['data'] = $data;
$response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];


// --- Step 4: Deliver Response

// Return Response to browser
    //set default:
if (isset($_GET['format']))
  $format = $_GET['format'];
else
  $format = 'json';
if ((!($format)) or (!in_array(strtolower($format),['json']))) $format = 'json';
deliver_response($format, $response);

?>
