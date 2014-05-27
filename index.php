<?php
/**
 * Just an auto reply service
 * @author Tim Lytle <tim@timlytle.net>
 */

define('NEXMO_KEY', $_SERVER['NEXMO_KEY']);
define('NEXMO_SECRET', $_SERVER['NEXMO_SECRET']);

//request looks to be from Nexmo
$request = array_merge($_GET, $_POST); //method configurable via Nexmo API / Dashboard
if(isset($request['msisdn'], $request['text'])){
    try{
        $text = 'Hey, this is an demo number on Nexmo.com';
        $uri = sprintf('http://rest.nexmo.com/sms/json?username=%1$s&password=%2$s&from=%3$s&to=%4$s&text=%5$s',
            NEXMO_KEY,
            NEXMO_SECRET,
            $request['to'],
            $request['msisdn'],
            urlencode($text));

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        error_log($result);
    } catch (Exception $e) {
        error_log($e); //NOTE: if you want Nexmo to retry, just give a non-2XX response
    }
}