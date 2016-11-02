<?php


// Melde alle PHP Fehler (siehe Changelog)
error_reporting(E_ALL);

// Melde alle PHP Fehler
error_reporting(-1);

// Dies entspricht error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
//$context["ssl"]["local_cert"] = "redurunner.zentrale-woehrl.de.crt";
//$stream_context = stream_context_create($context);

ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache

$zwischen = array(
    'key1' => 'log 1',
    'key2' => 'log 2',
);

$b = new stdClass();
$b->Pin = '2B9AFD95';
$b->redunummer = 'RED00035343';
//$b->log= $zwischen;

//$redu->ReduNummer = 'RED00033854';

/*
$client = new SoapClient("server.wsdl", 
				array(
				'login' => 'developer',
				'password' => 'developer',
				'trace' => 1,
				'exceptions' => 1,
				));




$result = $client -> DebugRecord($b);


echo '<pre>';
var_dump($result);
echo '</pre>';


die;
*/
//phpinfo();


//echo "hallo";


require_once 'models/eanscanner.inc.php';
$redu = new FingerScanner;
//$redu->uid = 17;
//$redu->FilialId = 2;
//$redu->ReduNummer = 'RED00033854';
$Redu = $redu->GetReduNachReduNummer($b);


echo '<pre>';
var_dump($Redu);
echo '</pre>';


?>
