<?php
// Melde alle PHP Fehler
error_reporting(E_ALL);

// Melde alle PHP Fehler
error_reporting(-1);

// Dies entspricht error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

ini_set("soap.wsdl_cache_enabled", "0");
require_once 'models/eanscanner.inc.php';

try {
  $server = new SOAPServer('server.wsdl');
  $server->setClass('Fingerscanner', array(
		'cache_wsdl' => WSDL_CACHE_NONE,
		"trace"         => 1, 
         "exceptions"    => 0,
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
?>