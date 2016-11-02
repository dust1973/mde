<?php


/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 08.08.2016
 * Time: 17:26
 */



/**   @WebService(
 *    serviceName = "Umlagerung",
 *    targetNamespace = "https://redurunner.zentrale-woehrl.de/",
 *    endpointInterface = "de.zentrale_woehrl.redurunner.ws.Umlagerung"
 *    )
 */

class UmlagerungImpl implements Umlagerung
{

    /**
     * @WebMethod(exclude = false)
     * @WebResult(partName = "return")
     * @param KommissionierListeRequest $umlagerungsNummer
     * @return array|SoapVar
     */


    public function getKommissionierListe($requestParameter)
    {
        $db = new DB();

        $par = new KommissionierListeRequest;
        $par ->setUmlagerungsNummer($requestParameter->umlagerungsNummer);
        $umlagerungsNummer = $par->getUmlagerungsNummer();


        $sql = "exec dbo.uspGetUmlagerungsAnweisung :umlagerungsNummer";
        $abfrage = $db->getConnect()->prepare($sql);
        $abfrage->bindParam(':umlagerungsNummer', $umlagerungsNummer, PDO::PARAM_STR);
        $abfrage->execute();
        $rueckgabewert = $abfrage->fetchAll(PDO::FETCH_ASSOC);
        if(isset($rueckgabewert)) {
            $count = count($rueckgabewert);

            if (isset($rueckgabewert[0]['ErrMsg'])) {

                $parm = array();

                switch ($rueckgabewert[0]['ErrMsg']) {
                    case -1:
                        $parm[] = new SoapVar('<return>', XSD_ANYXML);
                        $parm[] = new SoapVar('Umlagerungsnummer ist nicht vorhanden! ' . $umlagerungsNummer, XSD_STRING, null, null, 'Fehler');
                        $parm[] = new SoapVar('</return>', XSD_ANYXML);
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
                //return $rueckgabewert;
                $parm = array();


                foreach ($rueckgabewert as $rueckgabewer) {
                    $parm[] = new SoapVar('<return>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Count>' . $count . '</Count>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Umlagerungsnummer>' . $rueckgabewer['Umlagerungsnummer'] . '</Umlagerungsnummer>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Bemerkung>' . htmlspecialchars(utf8_encode(htmlentities($rueckgabewer['Bemerkung']))) . '</Bemerkung>', XSD_ANYXML);
                    $parm[] = new SoapVar('<GueltigAb>' . $rueckgabewer['GueltigAb'] . '</GueltigAb>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Lieferdatum>' . $rueckgabewer['Lieferdatum'] . '</Lieferdatum>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Herkunftsart>' . $rueckgabewer['Herkunftsart'] . '</Herkunftsart>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Herkunftsbeleg>' . $rueckgabewer['Herkunftsbeleg'] . '</Herkunftsbeleg>', XSD_ANYXML);
                    $parm[] = new SoapVar('<HaengeLiegeware>' . htmlspecialchars($rueckgabewer['haengeLiegeware']) . '</HaengeLiegeware>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Umlagerungsart>' . $rueckgabewer['Umlagerungsart'] . '</Umlagerungsart>', XSD_ANYXML);
                    $parm[] = new SoapVar('<MengeInUmlagerungsAuftrag>' . htmlspecialchars(utf8_encode($rueckgabewer['MengeInUmlagerungsAuftrag'])) . '</MengeInUmlagerungsAuftrag>', XSD_ANYXML);

                    $parm[] = new SoapVar('<MengeAktuellerBestand>' . utf8_encode($rueckgabewer['MengeAktuellerBestand']) . '</MengeAktuellerBestand>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Ersteller>' . htmlentities($rueckgabewer['Ersteller']) . '</Ersteller>', XSD_ANYXML);
                    $parm[] = new SoapVar('<VonFilialbezeichnung>' . htmlspecialchars($rueckgabewer['VonFilialbezeichnung']) . '</VonFilialbezeichnung>', XSD_ANYXML);
                    $parm[] = new SoapVar('<VonFilialnummer>' . $rueckgabewer['VonFilialnummer'] . '</VonFilialnummer>', XSD_ANYXML);

                    $parm[] = new SoapVar('<AnFilialbezeichnung>' . $rueckgabewer['AnFilialbezeichnung'] . '</AnFilialbezeichnung>', XSD_ANYXML);
                    $parm[] = new SoapVar('<AnFilialnummer>' . htmlspecialchars(utf8_encode(htmlentities($rueckgabewer['AnFilialnummer']))) . '</AnFilialnummer>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Lieferant>' . $rueckgabewer['Lieferant'] . '</Lieferant>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Kategorie>' . htmlspecialchars(utf8_encode(htmlentities($rueckgabewer['Kategorie']))) . '</Kategorie>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Flaechengruppe>' . htmlspecialchars(utf8_encode(htmlentities($rueckgabewer['Flaechengruppe']))) . '</Flaechengruppe>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Artikelnummer>' . $rueckgabewer['Artikelnummer'] . '</Artikelnummer>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Warengruppe>' . htmlspecialchars(utf8_encode($rueckgabewer['Warengruppe'])) . '</Warengruppe>', XSD_ANYXML);
                    $parm[] = new SoapVar('<KredArtNr>' . $rueckgabewer['KredArtNr'] . '</KredArtNr>', XSD_ANYXML);
                    $parm[] = new SoapVar('<ModellNr>' . htmlspecialchars(utf8_encode($rueckgabewer['ModellNr'])) . '</ModellNr>', XSD_ANYXML);

                    $parm[] = new SoapVar('<ArtikelBezeichnung>' . htmlspecialchars(utf8_encode($rueckgabewer['ArtikelBezeichnung'])). '</ArtikelBezeichnung>', XSD_ANYXML);
                    $parm[] = new SoapVar('<KredFarbe>' . htmlentities($rueckgabewer['KredFarbe']) . '</KredFarbe>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Strichcode>' . htmlspecialchars($rueckgabewer['Strichcode']) . '</Strichcode>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Farbe>' . $rueckgabewer['Farbe'] . '</Farbe>', XSD_ANYXML);

                    $parm[] = new SoapVar('<Groesse>' . htmlspecialchars($rueckgabewer['Groesse']) . '</Groesse>', XSD_ANYXML);
                    $parm[] = new SoapVar('<Fehler></Fehler>', XSD_ANYXML);
                    $parm[] = new SoapVar('</return>', XSD_ANYXML);
                }

                return new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'KommissionierListe');
            }
        }else{
            throw new SoapFault("Server","Unknown Symbol '$umlagerungsNummer'.");
        }
    }

    /**
     * @WebMethod(exclude = false)
     * @WebResult(partName = "return")
     *
     */
    public function  pingPong()
    {
        
		$parm[] = new SoapVar('<return>1</return>', XSD_ANYXML);
        $rueckgabewert = new SoapVar($parm, SOAP_ENC_OBJECT, null, null, 'Settings');
        return $rueckgabewert;
    }
}