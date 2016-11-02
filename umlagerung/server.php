<?php
/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 05.08.2016
 * Time: 15:27
 */

// Melde alle PHP Fehler
error_reporting(E_ALL);

// Melde alle PHP Fehler
error_reporting(-1);

// Dies entspricht error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

ini_set("soap.wsdl_cache_enabled", "0");

include('Umlagerung.php');
require_once "request/KommissionierListeRequest.php";
require_once "response/KommissionierListeResponse.php";
require_once 'impl/UmlagerungImpl.php';
require_once "db/DB.php";

try {
    $server = new SOAPServer('server.wsdl');
    $server->setClass('UmlagerungImpl',
        array(
            'cache_wsdl' => WSDL_CACHE_NONE,
            "trace"         => 1,
            "exceptions"    => 1,
            "style"         => SOAP_RPC,
            "use"           => SOAP_ENCODED,
            "soap_version"  => SOAP_1_2 ,
        )
    );
    $server->handle();
}

catch (SOAPFault $f) {
    print $f->faultstring;
}