<?php
/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 05.08.2016
 * Time: 15:39
 */


// Melde alle PHP Fehler (siehe Changelog)
error_reporting(E_ALL);

// Melde alle PHP Fehler
error_reporting(-1);

// Dies entspricht error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
//$context["ssl"]["local_cert"] = "redurunner.zentrale-woehrl.de.crt";
//$stream_context = stream_context_create($context);

ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache

include('Umlagerung.php');
require_once "request/KommissionierListeRequest.php";
require_once "response/KommissionierListeResponse.php";
require_once 'impl/UmlagerungImpl.php';
require_once "db/DB.php";


$umlagerung = new UmlagerungImpl();
$kommissionierListe = $umlagerung->getKommissionierListe('000000073892');
//$kommissionierListe = $umlagerung->PingPong();
echo '<pre>';
var_dump($kommissionierListe);
echo '</pre>';
