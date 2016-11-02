<?php

include_once './../config/Config.php';
class Fingerscanner
{
    private $db = null;

    private $MSSQLpasswort = Config::MSSQLPASSWORT;
    private $MSSQLhost = Config::MSSQLHOSTPRODUKTIV;
    private $MSSQLdbname = Config::MSSQLDBNAME;
    private $MSSQLdbuser = Config::MSSQLDBUSER;

    private $mySQLpasswort = Config::MYSQLPASSWORT;
    private $mySQLhost = Config::MYSQLHOST ;
    private $mySQLdbname = Config::MYSQLDBNAME;
    private $mySQLdbuser = Config::MYSQLDBUSER;


    public $uid;

    public function  PingPong()
    {


        $parm[] = new SoapVar('<Pong>1</Pong>', XSD_ANYXML);

        $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Settings');

        return $rueckgabewert;
    }

    private function ObPinVorhandenIst($pin)
    {

        $optionen = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
        );

        $this->db = new PDO('mysql:host=' . $this->mySQLhost . ';dbname=' . $this->mySQLdbname, $this->mySQLdbuser, $this->mySQLpasswort);
        $this->db->query('SET NAMES utf8');

        $sql = "SELECT imei, debug, debugLevel, zeitstempel, url_startpage, url_helppage, scanner, drucker FROM  settings_redurunner WHERE imei = :imei";

        $abfrage = $this->db->prepare($sql);
        $abfrage->bindParam(':imei', $pin, PDO::PARAM_INT, 15);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetch(PDO::FETCH_ASSOC);
        return $rueckgabewert;


    }

    function GetSettings($parameters)
    {


        $optionen = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
        );

        $this->db = new PDO('mysql:host=' . $this->mySQLhost . ';dbname=' . $this->mySQLdbname, $this->mySQLdbuser, $this->mySQLpasswort);
        $this->db->query('SET NAMES utf8');

        $sql = "SELECT debug, debugLevel, zeitstempel, url_startpage, url_helppage, scanner, drucker FROM  settings_redurunner WHERE imei = :imei";

        //return  $sql;
        //$imei = 123456789012345;
        $abfrage = $this->db->prepare($sql);
        $abfrage->bindParam(':imei', $parameters->pin, PDO::PARAM_STR, 8);
        $abfrage->execute();

        $parm = array();
        if ($rueckgabewert = $abfrage->fetchObject()) {

            $date = new DateTime($rueckgabewert->zeitstempel);
            $zeitstempel = $date->format('d-m-Y H:i:s');
            $parm[] = new SoapVar('<Parameters>', XSD_ANYXML);
            $parm[] = new SoapVar('<Type>PIN: ' . $parameters->pin . '</Type>', XSD_ANYXML);
            $parm[] = new SoapVar('<DebugLevel>' . $rueckgabewert->debugLevel . '</DebugLevel>', XSD_ANYXML);
            $parm[] = new SoapVar('<Debug>' . $rueckgabewert->debug . '</Debug>', XSD_ANYXML);
            $parm[] = new SoapVar('<Zeitstempel>' . $zeitstempel . '</Zeitstempel>', XSD_ANYXML);
            $parm[] = new SoapVar('<Scanner>' . $rueckgabewert->scanner . '</Scanner>', XSD_ANYXML);
            $parm[] = new SoapVar('<Drucker>' . $rueckgabewert->drucker . '</Drucker>', XSD_ANYXML);
            $parm[] = new SoapVar('<Url_startpage>' . $rueckgabewert->url_startpage . '</Url_startpage>', XSD_ANYXML);
            $parm[] = new SoapVar('<Url_helppage>' . $rueckgabewert->url_helppage . '</Url_helppage>', XSD_ANYXML);
            $parm[] = new SoapVar('</Parameters>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Settings');

        } else {
            $sql = "SELECT debug, debugLevel, url_helppage, url_startpage, zeitstempel FROM settings_redurunner WHERE imei = 1";
            $abfrage = $this->db->prepare($sql);
            $abfrage->execute();
            $rueckgabewert = $abfrage->fetchObject();
            $date = new DateTime($rueckgabewert->zeitstempel);
            $zeitstempel = $date->format('d-m-Y H:i:s');
            $parm[] = new SoapVar('<Parameters>', XSD_ANYXML);
            $parm[] = new SoapVar('<Type>Default</Type>', XSD_ANYXML);
            $parm[] = new SoapVar('<DebugLevel>' . $rueckgabewert->debugLevel . '</DebugLevel>', XSD_ANYXML);
            $parm[] = new SoapVar('<Debug>' . $rueckgabewert->debug . '</Debug>', XSD_ANYXML);
            $parm[] = new SoapVar('<Zeitstempel>' . $zeitstempel . '</Zeitstempel>', XSD_ANYXML);
            $parm[] = new SoapVar('<Scanner>' . $rueckgabewert->scanner . '</Scanner>', XSD_ANYXML);
            $parm[] = new SoapVar('<Drucker>' . $rueckgabewert->drucker . '</Drucker>', XSD_ANYXML);
            $parm[] = new SoapVar('<Url_startpage>' . $rueckgabewert->url_startpage . '</Url_startpage>', XSD_ANYXML);
            $parm[] = new SoapVar('<Url_helppage>' . $rueckgabewert->url_helppage . '</Url_helppage>', XSD_ANYXML);
            $parm[] = new SoapVar('</Parameters>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Settings');
        }

        return $rueckgabewert;


    }

    function SetSettings($parameters)
    {


        $debug = trim($parameters->Parameters->debug);
        $pin = trim($parameters->Parameters->pin);
        $debugLevel = $parameters->Parameters->debugLevel;
        $url_helppage = trim($parameters->Parameters->url_helppage);
        $url_startpage = trim($parameters->Parameters->url_startpage);
        $scanner = trim($parameters->Parameters->scanner);
        $drucker = trim($parameters->Parameters->drucker);

        //$debugLevel	= 0 Normalbetrieb
        //$debugLevel	= 1 DebugLogs schreiben
        //$debugLevel	= 2 DebugLogs schreiben+Adminmodus


        $num_length = strlen((string)$pin);

        $optionen = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
        );
        $this->db = new PDO('mysql:host=' . $this->mySQLhost . ';dbname=' . $this->mySQLdbname, $this->mySQLdbuser, $this->mySQLpasswort);
        $this->db->query('SET NAMES utf8');


        if ($num_length != 8) {

            $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
            $parm[] = new SoapVar('Die IMEI bzw. PIN-Nummer muss 8-stellig sein, die ist aber ' . $num_length . '-stellig</Fehler></Parameters>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
            return $rueckgabewert;


        } else {

            if ($res = $this->ObPinVorhandenIst($pin)) {

                $sql = "UPDATE fingerscanner.settings_redurunner SET
					debug = :debug,
					debugLevel = :debugLevel,
					url_helppage = :url_helppage,
                    url_startpage = :url_startpage,
                    scanner = :scanner,
                    drucker = :drucker
					WHERE settings_redurunner.imei = :pin";

                $abfrage = $this->db->prepare($sql);

                if ($debugLevel >= 3 OR $debugLevel < 0) {
                    $debugLevel = 0;
                }

                if ($url_helppage == '' OR $url_helppage == NULL) {
                    $url_helppage = $res['url_helppage'];
                }
                if ($url_startpage == '' OR $url_startpage == NULL) {
                    $url_startpage = $res['url_startpage'];
                }
                if ($scanner == '' OR $scanner == NULL) {
                    $scanner = $res['scanner'];
                }
                if ($drucker == '' OR $drucker == NULL) {
                    $drucker = $res['drucker'];
                }

                $abfrage->bindParam(':debug', $debug, PDO::PARAM_INT);
                $abfrage->bindParam(':pin', $pin, PDO::PARAM_STR, 8);
                $abfrage->bindParam(':debugLevel', $debugLevel, PDO::PARAM_INT);
                $abfrage->bindParam(':url_helppage', $url_helppage, PDO::PARAM_STR);
                $abfrage->bindParam(':url_startpage', $url_startpage, PDO::PARAM_STR);
                $abfrage->bindParam(':scanner', $scanner, PDO::PARAM_STR);
                $abfrage->bindParam(':drucker', $drucker, PDO::PARAM_STR);

            } else {

                $sql = "INSERT INTO fingerscanner.settings_redurunner (imei, debug, debugLevel,url_helppage,url_startpage, scanner,drucker )
VALUES (:pin, :debug,  :debugLevel, :url_helppage, :url_startpage, :scanner, :drucker)";

                $abfrage = $this->db->prepare($sql);
                $abfrage->bindParam(':debug', $debug, PDO::PARAM_INT);
                $abfrage->bindParam(':pin', $pin, PDO::PARAM_STR, 8);
                $abfrage->bindParam(':debugLevel', $debugLevel, PDO::PARAM_BOOL);
                $abfrage->bindParam(':url_helppage', $url_helppage, PDO::PARAM_STR);
                $abfrage->bindParam(':url_startpage', $url_startpage, PDO::PARAM_STR);
                $abfrage->bindParam(':scanner', $scanner, PDO::PARAM_STR);
                $abfrage->bindParam(':drucker', $drucker, PDO::PARAM_STR);

            }


            /*print '<pre>';
            var_dump($abfrage->debugDumpParams());
            print '</pre>';
            print '<pre>';
            $error = $abfrage->errorInfo();
            var_dump($error);
            print '<pre>';
            */

            if ($abfrage->execute()) {

                $parm[] = new SoapVar('<Parameters><Success>', XSD_ANYXML);
                $parm[] = new SoapVar('Daten wurden erfolgreich geändert.</Success></Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
                return $rueckgabewert;

            } else {

                $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
                $parm[] = new SoapVar('Es ist ein Fehler aufgetreten. Daten wurden nicht in die Datenbank eingetragen.</Fehler></Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
                return $rueckgabewert;
            }

        }

    }

    function GetDebugRecord($parameters)
    {

        $pin = trim($parameters->pin);


        $optionen = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
        );
        $this->db = new PDO('mysql:host=' . $this->mySQLhost . ';dbname=' . $this->mySQLdbname, $this->mySQLdbuser, $this->mySQLpasswort);
        $this->db->query('SET NAMES utf8');


        $sql = "SELECT log FROM fingerscanner.log_redurunner WHERE pin = :pin";

        $abfrage = $this->db->prepare($sql);
        $abfrage->bindParam(':pin', $pin, PDO::PARAM_STR, 8);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchAll();

        return $rueckgabewert;
    }


    function DebugRecord($parameters)
    {

        $log = $parameters->log;
        $pin = trim($parameters->pin);


        // if(is_array($log)){
        $log = serialize($log);
        //}else{
        //  $log = trim($parameters->log);
        //}

        //return $log;
        //$log = trim($parameters->log);
        //$pin = trim($parameters->pin);

        $num_length = strlen((string)$pin);


        if ($num_length != 8) {

            $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
            $parm[] = new SoapVar('Die IMEI bzw. PIN-Nummer muss 8-stellig sein, die ist aber ' . $num_length . '-stellig</Fehler></Parameters>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
            return $rueckgabewert;


        } elseif (!isset($log)) {
            $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
            $parm[] = new SoapVar('Das Feld "Log" darf nicht leer sein</Fehler></Parameters>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');

        } else {

            $optionen = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
            );
            $this->db = new PDO('mysql:host=' . $this->mySQLhost . ';dbname=' . $this->mySQLdbname, $this->mySQLdbuser, $this->mySQLpasswort);
            $this->db->query('SET NAMES utf8');


            $sql = "INSERT INTO fingerscanner.log_redurunner (pin, log) VALUES (:pin, :log)";

            $abfrage = $this->db->prepare($sql);
            $abfrage->bindParam(':log', $log, PDO::PARAM_STR);
            $abfrage->bindParam(':pin', $pin, PDO::PARAM_STR, 8);

            if ($abfrage->execute()) {

                $parm[] = new SoapVar('<Parameters><Success>', XSD_ANYXML);
                $parm[] = new SoapVar('Daten wurden erfolgreich in die Datenbank eingetragen!</Success></Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
                return $rueckgabewert;

            } else {

                $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
                $parm[] = new SoapVar('Es ist ein Fehler aufgetreten. Daten wurden nicht in die Datenbank eingetragen.</Fehler></Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Debug');
                return $rueckgabewert;
            }
        }

    }

    function GetFilialen($uid)
    {


        $this->db = new PDO("dblib:host=" . $this->MSSQLhost . ";" . $this->MSSQLdbname, $this->MSSQLdbuser, $this->MSSQLpasswort);

        if ($uid->uid == 99) {
            $sql = "exec dbo.uspGetHausListe";
            $daten = array($uid->uid);
            $abfrage = $this->db->prepare($sql);
            $abfrage->execute($daten);
            $rueckgabewert = $abfrage->fetchAll(PDO::FETCH_ASSOC);

            $parm = array();
            foreach ($rueckgabewert as $rueckgabewer) {
                $parm[] = new SoapVar('<Parameters>', XSD_ANYXML);
                //$parm[] = new SoapVar('<uid>'.$rueckgabewer['uid'].'</uid>', XSD_ANYXML );
                $parm[] = new SoapVar('<Filialnummer>' . $rueckgabewer['Filialnummer'] . '</Filialnummer>', XSD_ANYXML);
                $parm[] = new SoapVar('<Filialbezeichnung>' . utf8_encode($rueckgabewer['Filialbezeichnung']) . '</Filialbezeichnung>', XSD_ANYXML);
                $parm[] = new SoapVar('</Parameters>', XSD_ANYXML);
            }
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Filialen');


        } else {
            $sql = "exec dbo.uspGetHaus ? ";
            $daten = array($uid->uid);
            $abfrage = $this->db->prepare($sql);
            $abfrage->execute($daten);
            $parm = array();
            if ($rueckgabewert = $abfrage->fetchObject()) {
                $parm[] = new SoapVar('<Parameters>', XSD_ANYXML);
                //$parm[] = new SoapVar('<uid>'.$rueckgabewert->uid.'</uid>', XSD_ANYXML );
                $parm[] = new SoapVar('<Filialnummer>' . $rueckgabewert->Filialnummer . '</Filialnummer>', XSD_ANYXML);
                $parm[] = new SoapVar('<Filialbezeichnung>' . utf8_encode($rueckgabewert->Filialbezeichnung) . '</Filialbezeichnung>', XSD_ANYXML);
                $parm[] = new SoapVar('</Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Filialen');

            } else {

                $parm[] = new SoapVar('<Parameters><Fehler>', XSD_ANYXML);
                $parm[] = new SoapVar('Keine gueltige Filial-ID</Fehler></Parameters>', XSD_ANYXML);
                $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Filialen');
            }
        }


        /*
        print '<pre>';
        var_dump($abfrage->debugDumpParams());
        print '</pre>';
        $error = $abfrage->errorInfo();
        var_dump($error);
        print '<pre>';
        var_dump($uid);
        print '</pre>';
        print '<pre>';
        var_dump($rueckgabewert);
        print '</pre>';
        */
        //$error = $abfrage->errorInfo();
        //$rueckgabewert = $error;

        return $rueckgabewert;


    }

    function GetReduNachEan($filiale)
    {


        $idFiliale = $filiale->FilialId;
        $ean = $filiale->EAN;
        $ean = '4053059767994';
        $idFiliale = 13;
        $sql = "SELECT filialen.name as Filialbezeichnung ,filialen.nummer as Filialnummer,
		header.ReduNummer, body.Artikelnummer, body.Warengruppe, body.KredArtNr, body.ModellNr, body.Artikelbezeichnung,
		body.KredFarbe, body.UmsatzStueck, body.LBStueck, body.UrsprVK, body.AktVK, body.NeuVK,
		mm.Strichcode, mm.Farbe, header.Lieferant, header.Mitarbeiter, header.Abschriftenart, header.Bemerkung, header.Kategorie, header.Flaechengruppe, header.GueltigAb
		FROM soap_reduBody body
		JOIN soap_strichcode_artikelnummer_mm mm ON  body.Artikelnummer =  mm.Artikelnummer
		JOIN soap_reduHeader header ON  header.idReduHeader =  body.soap_reduHeader_idReduHeader
		JOIN soap_filialen filialen ON  filialen.idFilialen = header.soap_filialen_idFilialen where filialen.idFilialen = :idFiliale AND mm.Strichcode = :ean
		order by filialen.nummer";


        $abfrage = $this->db->prepare($sql);

        $abfrage->bindParam(':idFiliale', $idFiliale, PDO::PARAM_INT);
        $abfrage->bindParam(':ean', $ean, PDO::PARAM_STR, 13);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchObject();
        if ($rueckgabewert) {
            $rueckgabewert = new SoapVar($rueckgabewert, SOAP_ENC_OBJECT);
            /*$parm = array();
            $parm[] = new SoapVar('<Filialbezeichnung>'.$rueckgabewert->Filialbezeichnung.'</Filialbezeichnung>', XSD_ANYXML);
            $parm[] = new SoapVar('<Filialnummer>'.$rueckgabewert->Filialnummer.'</Filialnummer>', XSD_ANYXML);
            $parm[] = new SoapVar('<ReduNummer>'.$rueckgabewert->Artikelnummer.'</ReduNummer>', XSD_ANYXML);
            $parm[] = new SoapVar('<Artikelnummer>'.$rueckgabewert->Filialnummer.'</Artikelnummer>', XSD_ANYXML);
            $parm[] = new SoapVar('<Warengruppe>'.$rueckgabewert->Warengruppe.'</Warengruppe>', XSD_ANYXML);
            $parm[] = new SoapVar('<KredArtNr>'.$rueckgabewert->KredArtNr.'</KredArtNr>', XSD_ANYXML);
            $parm[] = new SoapVar('<ModellNr>'.$rueckgabewert->ModellNr.'</ModellNr>', XSD_ANYXML);
            $parm[] = new SoapVar('<Artikelbezeichnung>'.$rueckgabewert->Artikelbezeichnung.'</Artikelbezeichnung>', XSD_ANYXML);
            $parm[] = new SoapVar('<KredFarbe>'.$rueckgabewert->KredFarbe.'</KredFarbe>', XSD_ANYXML);
            $parm[] = new SoapVar('<UmsatzStueck>'.$rueckgabewert->UmsatzStueck.'</UmsatzStueck>', XSD_ANYXML);
            $parm[] = new SoapVar('<LBStueck>'.$rueckgabewert->LBStueck.'</LBStueck>', XSD_ANYXML);
            $parm[] = new SoapVar('<UrsprVK>'.$rueckgabewert->UrsprVK.'</UrsprVK>', XSD_ANYXML);
            $parm[] = new SoapVar('<AktVK>'.$rueckgabewert->AktVK.'</AktVK>', XSD_ANYXML);
            $parm[] = new SoapVar('<NeuVK>'.$rueckgabewert->NeuVK.'</NeuVK>', XSD_ANYXML);
            $parm[] = new SoapVar('<Strichcode>'.$rueckgabewert->Strichcode.'</Strichcode>', XSD_ANYXML);
            $parm[] = new SoapVar('<Farbe>'.$rueckgabewert->Farbe.'</Farbe>', XSD_ANYXML);
            $parm[] = new SoapVar('<Lieferant>'.$rueckgabewert->Lieferant.'</Lieferant>', XSD_ANYXML);
            $parm[] = new SoapVar('<Mitarbeiter>'.$rueckgabewert->Mitarbeiter.'</Mitarbeiter>', XSD_ANYXML);
            $parm[] = new SoapVar('<Abschriftenart>'.$rueckgabewert->Abschriftenart.'</Abschriftenart>', XSD_ANYXML);
            $parm[] = new SoapVar('<Bemerkung>'.$rueckgabewert->Bemerkung.'</Bemerkung>', XSD_ANYXML);
            $parm[] = new SoapVar('<Kategorie>'.$rueckgabewert->Kategorie.'</Kategorie>', XSD_ANYXML);
            $parm[] = new SoapVar('<Flaechengruppe>'.$rueckgabewert->Flaechengruppe.'</Flaechengruppe>', XSD_ANYXML);
            $parm[] = new SoapVar('<GueltigAb>'.$rueckgabewert->GueltigAb.'</GueltigAb>', XSD_ANYXML);
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
            */
            return $rueckgabewert;
        } else {
            $parm = array();
            $parm[] = new SoapVar('Artikel konnte nicht gefunden werden', XSD_STRING, null, null, 'Fehler');
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
            return $rueckgabewert; //'Artikel konnte nicht gefunden werden' ;
        }

    }

    function GetReduNachReduNummer($filiale)
    {

        $this->db = new PDO("dblib:host=" . $this->MSSQLhost . ";" . $this->MSSQLdbname, $this->MSSQLdbuser, $this->MSSQLpasswort);

        $idFiliale = trim($filiale->FilialId);
        $redunummer = trim($filiale->ReduNummer);

        //$redunummer = 'RED00035343';
        //$idFiliale = 1;

        $sql = "exec dbo.uspGetReduanweisung :idFiliale, :redunummer";

        $abfrage = $this->db->prepare($sql);
        $abfrage->bindParam(':idFiliale', $idFiliale, PDO::PARAM_INT);
        $abfrage->bindParam(':redunummer', $redunummer, PDO::PARAM_STR);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchAll(PDO::FETCH_ASSOC);

        //return  $rueckgabewert[0]['ErrMsg'] ;

        if ($rueckgabewert[0]['ErrMsg']) {

            $parm = array();

            switch ($rueckgabewert[0]['ErrMsg']) {
                case -1:
                    $parm[] = new SoapVar('Fehler-Redunummer ist nicht vorhanden!', XSD_STRING, null, null, 'Fehler');
                    $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
                    return $rueckgabewert;
                    break;
                case -2:
                    $parm[] = new SoapVar('Fehler-ungültiger Status!', XSD_STRING, null, null, 'Fehler');
                    $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
                    return $rueckgabewert;
                    break;
                default:
                    $parm[] = new SoapVar('Fehler-' . $rueckgabewert[0]['ErrMsg'], XSD_STRING, null, null, 'Fehler');
                    $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
                    return $rueckgabewert;
            }


        } else {
            $parm = array();
            $parm[] = new SoapVar('<ArtikelHeader>', XSD_ANYXML);
            $date = new DateTime($rueckgabewert[0]['GueltigAb']);
            $zeitstempel = $date->format('d.m.Y');
            $parm[] = new SoapVar('<Filialbezeichnung>' . htmlspecialchars($rueckgabewert[0]['Filialbezeichnung']) . '</Filialbezeichnung>', XSD_ANYXML);
            $parm[] = new SoapVar('<Filialnummer>' . $rueckgabewert[0]['Filialnummer'] . '</Filialnummer>', XSD_ANYXML);
            $parm[] = new SoapVar('<ReduNummer>' . $rueckgabewert[0]['ReduNummer'] . '</ReduNummer>', XSD_ANYXML);
            $parm[] = new SoapVar('<GueltigAb>' . $zeitstempel . '</GueltigAb>', XSD_ANYXML);
            $parm[] = new SoapVar('<Flaechengruppe>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Flaechengruppe'])) . '</Flaechengruppe>', XSD_ANYXML);

            $parm[] = new SoapVar('<Lieferant>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Lieferant'])) . '</Lieferant>', XSD_ANYXML);
            $parm[] = new SoapVar('<Mitarbeiter>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Mitarbeiter'])) . '</Mitarbeiter>', XSD_ANYXML);
            $parm[] = new SoapVar('<Abschriftenart>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Abschriftenart'])) . '</Abschriftenart>', XSD_ANYXML);
            $parm[] = new SoapVar('<Bemerkung>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Bemerkung'])) . '</Bemerkung>', XSD_ANYXML);
            $parm[] = new SoapVar('<Kategorie>' . htmlspecialchars(utf8_encode($rueckgabewert[0]['Kategorie'])) . '</Kategorie>', XSD_ANYXML);

            $parm[] = new SoapVar('</ArtikelHeader>', XSD_ANYXML);


            foreach ($rueckgabewert as $rueckgabewer) {
                $parm[] = new SoapVar('<Artikel>', XSD_ANYXML);
                $parm[] = new SoapVar('<Artikelnummer>' . $rueckgabewer['Artikelnummer'] . '</Artikelnummer>', XSD_ANYXML);
                $parm[] = new SoapVar('<Artikelbezeichnung>' . htmlspecialchars(utf8_encode(htmlentities($rueckgabewer['ArtikelBezeichnung']))) . '</Artikelbezeichnung>', XSD_ANYXML);
                $parm[] = new SoapVar('<LBStueck>' . $rueckgabewer['LBStueck'] . '</LBStueck>', XSD_ANYXML);
                $parm[] = new SoapVar('<UrsprVK>' . $rueckgabewer['UrsprVK'] . '</UrsprVK>', XSD_ANYXML);
                $parm[] = new SoapVar('<AktVK>' . $rueckgabewer['AktVK'] . '</AktVK>', XSD_ANYXML);
                $parm[] = new SoapVar('<NeuVK>' . $rueckgabewer['NeuVK'] . '</NeuVK>', XSD_ANYXML);
                $parm[] = new SoapVar('<KredFarbe>' . htmlspecialchars(utf8_encode($rueckgabewer['KredFarbe'])) . '</KredFarbe>', XSD_ANYXML);
                $parm[] = new SoapVar('<Strichcode>' . $rueckgabewer['Strichcode'] . '</Strichcode>', XSD_ANYXML);
                $parm[] = new SoapVar('<Farbe>' . htmlspecialchars(utf8_encode($rueckgabewer['Farbe'])) . '</Farbe>', XSD_ANYXML);

                $parm[] = new SoapVar('<Warengruppe>' . utf8_encode($rueckgabewer['Warengruppe']) . '</Warengruppe>', XSD_ANYXML);
                $parm[] = new SoapVar('<KredArtNr>' . htmlentities($rueckgabewer['KredArtNr']) . '</KredArtNr>', XSD_ANYXML);
                $parm[] = new SoapVar('<ModellNr>' . htmlspecialchars($rueckgabewer['ModellNr']) . '</ModellNr>', XSD_ANYXML);
                $parm[] = new SoapVar('<UmsatzStueck>' . $rueckgabewer['UmsatzStueck'] . '</UmsatzStueck>', XSD_ANYXML);
                $parm[] = new SoapVar('</Artikel>', XSD_ANYXML);
            }
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'ReduzierungsAnweisung');
            return $rueckgabewert;

        }

    }


    function GetRetoureNachEan($filiale)
    {
        $idFiliale = trim($filiale->FilialId);
        $ean = trim($filiale->EAN);
        //$ean = '4053059767994';
        $sql = "SELECT filialen.name as Filialbezeichnung ,filialen.nummer as Filialnummer,
		header.AnLagerort, body.Artikelnummer, body.Warengruppe, body.Kreditorenartikelnummer, body.Thema, body.Artikelbezeichnung,
		body.Saison, body.Marke, body.Modellnummer, body.Artikelbezeichnung, body.FarbeKreditor, body.FarbeWoehrl, body.Groesse,
		body.Menge, body.AktVK, body.UrsprungVK,
		mm.Strichcode, mm.Farbe, header.Kreditor, header.Ersteller, header.HaengeLiegeware, header.BemFuerFilialen, header.Kategorie, header.Flaechengruppe, header.GueltigAb
		FROM soap_retoureBody body
		JOIN soap_strichcode_artikelnummer_mm mm ON  body.Artikelnummer =  mm.Artikelnummer
		JOIN soap_retoureHeader header ON  header.idsoap_retoureHeader =  body.soap_retoureHeader_idsoap_retoureHeader
		JOIN soap_filialen filialen ON  filialen.idFilialen = header.soap_filialen_idFilialen where filialen.idFilialen = :idFiliale AND mm.Strichcode = :ean
		order by filialen.nummer";


        $abfrage = $this->db->prepare($sql);

        $abfrage->bindParam(':idFiliale', $idFiliale, PDO::PARAM_INT);
        $abfrage->bindParam(':ean', $ean, PDO::PARAM_STR, 13);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchObject();

        if ($rueckgabewert) {
            $rueckgabewert = new SoapVar($rueckgabewert, SOAP_ENC_OBJECT);
            return $rueckgabewert;
        } else {
            $parm = array();
            $parm[] = new SoapVar('Artikel konnte nicht gefunden werden', XSD_STRING, null, null, 'Fehler');
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
            return $rueckgabewert; //'Artikel konnte nicht gefunden werden' ;
        }


    }


    function GetUmlagerungNachEan($filiale)
    {
        $idFiliale = trim($filiale->FilialId);
        $ean = trim($filiale->EAN);
        $ean = '2000002731788';
        $idFiliale = 33;
        $sql = "SELECT filialen.name as Filialbezeichnung ,filialen.nummer as Filialnummer,
		header.AnLagerort, body.Artikelnummer, body.Warengruppe, body.Kreditorenartikelnummer, body.Thema,
		body.Saison, body.Marke, body.Modell, body.UmsatzStueck, body.KredFarbe, body.WoehrlFarbe, body.Groesse,
		body.Menge, body.AktVK, body.UrsprVK,
		mm.Strichcode, mm.Farbe, header.Umlagerungsnummer, header.Ersteller, header.Umlagerungsart, header.Bemerkung, header.Kategorie, header.Flaechengruppe, header.GueltigAb
		FROM soap_umlagerungBody body
		JOIN soap_strichcode_artikelnummer_mm mm ON  body.Artikelnummer =  mm.Artikelnummer
		JOIN soap_umlagerungHeader header ON  header.idsoap_umlagerungHeader =  body.soap_umlagerungHeader_idsoap_umlagerungHeader
		JOIN soap_filialen filialen ON  filialen.idFilialen = header.soap_filialen_idFilialen where filialen.idFilialen = :idFiliale AND mm.Strichcode = :ean
		order by filialen.nummer";


        $abfrage = $this->db->prepare($sql);

        $abfrage->bindParam(':idFiliale', $idFiliale, PDO::PARAM_INT);
        $abfrage->bindParam(':ean', $ean, PDO::PARAM_STR, 13);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchObject();

        if ($rueckgabewert) {
            $rueckgabewert = new SoapVar($rueckgabewert, SOAP_ENC_OBJECT);
            return $rueckgabewert;
        } else {
            $parm = array();
            $parm[] = new SoapVar('Artikel konnte nicht gefunden werden', XSD_STRING, null, null, 'Fehler');
            $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT);
            return $rueckgabewert; //'Artikel konnte nicht gefunden werden' ;
        }


    }


}

?>
