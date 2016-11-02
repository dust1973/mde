<?php
/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 08.08.2016
 * Time: 18:27
 */

class KommissionierListeResponse
{

    /** @XmlElement(name = "HerkunftsArt")*/
protected $herkunftsArt;
    /**@XmlElement(name = "HerkunftsBeleg")*/
protected $herkunftsBeleg;
    /**@XmlElement(name = "HaengeLiegeware")*/
protected $haengeLiegeware;
    /**@XmlElement(name = "UmlagerungsArt")*/
protected $umlagerungsArt;
    /**@XmlElement(name = "MengeInUmlagerungsAuftrag")*/
protected $mengeInUmlagerungsAuftrag;
    /**@XmlElement(name = "MengeAktuellerBestand")*/
protected $mengeAktuellerBestand;
    /**@XmlElement(name = "Ersteller")*/
protected $ersteller;
    /**@XmlElement(name = "VonFilialbezeichnung")*/
protected $vonFilialbezeichnung;
    /**@XmlElement(name = "VonFilialnummer")*/
protected $vonFilialnummer;
    /**@XmlElement(name = "AnFilialbezeichnung")*/
protected $anFilialbezeichnung;
    /**@XmlElement(name = "AnFilialnummer")*/
protected $anFilialnummer;
    /**@XmlElement(name = "Lieferant")*/
protected $lieferant;
    /**@XmlElement(name = "Kategorie")*/
protected $kategorie;
    /**@XmlElement(name = "Flaechengruppe")*/
protected $flaechengruppe;
    /**@XmlElement(name = "Artikelnummer")*/
protected $artikelnummer;
    /**@XmlElement(name = "Warengruppe")*/
protected $warengruppe;
    /**@XmlElement(name = "KredArtNr")*/
protected $kredArtNr;
    /**@XmlElement(name = "ModellNr")*/
protected $modellNr;
    /**@XmlElement(name = "ArtikelBezeichnung")*/
protected $artikelBezeichnung;
    /**@XmlElement(name = "KredFarbe")*/
protected $kredFarbe;
    /**@XmlElement(name = "Strichcode")*/
protected $strichcode;
    /**@XmlElement(name = "Farbe")*/
protected $farbe;
    /**@XmlElement(name = "Groesse")*/
protected $groesse;
    /**@XmlElement(name = "UmlagerungsNummer")*/
protected $umlagerungsNummer;
    /**@XmlElement(name = "Bemerkung")*/
protected $bemerkung;
    /**@XmlElement(name = "GueltigAb")*/
protected $gueltigAb;
    /**@XmlElement(name = "LieferDatum")*/
protected $lieferDatum;

    /**
     * @return mixed
     */
    public function getHerkunftsArt()
    {
        return $this->herkunftsArt;
    }

    /**
     * @param mixed $herkunftsArt
     */
    public function setHerkunftsArt($herkunftsArt)
    {
        $this->herkunftsArt = $herkunftsArt;
    }

    /**
     * @return mixed
     */
    public function getHerkunftsBeleg()
    {
        return $this->herkunftsBeleg;
    }

    /**
     * @param mixed $herkunftsBeleg
     */
    public function setHerkunftsBeleg($herkunftsBeleg)
    {
        $this->herkunftsBeleg = $herkunftsBeleg;
    }

    /**
     * @return mixed
     */
    public function getHaengeLiegeware()
    {
        return $this->haengeLiegeware;
    }

    /**
     * @param mixed $haengeLiegeware
     */
    public function setHaengeLiegeware($haengeLiegeware)
    {
        $this->haengeLiegeware = $haengeLiegeware;
    }

    /**
     * @return mixed
     */
    public function getUmlagerungsArt()
    {
        return $this->umlagerungsArt;
    }

    /**
     * @param mixed $umlagerungsArt
     */
    public function setUmlagerungsArt($umlagerungsArt)
    {
        $this->umlagerungsArt = $umlagerungsArt;
    }

    /**
     * @return mixed
     */
    public function getMengeInUmlagerungsAuftrag()
    {
        return $this->mengeInUmlagerungsAuftrag;
    }

    /**
     * @param mixed $mengeInUmlagerungsAuftrag
     */
    public function setMengeInUmlagerungsAuftrag($mengeInUmlagerungsAuftrag)
    {
        $this->mengeInUmlagerungsAuftrag = $mengeInUmlagerungsAuftrag;
    }

    /**
     * @return mixed
     */
    public function getMengeAktuellerBestand()
    {
        return $this->mengeAktuellerBestand;
    }

    /**
     * @param mixed $mengeAktuellerBestand
     */
    public function setMengeAktuellerBestand($mengeAktuellerBestand)
    {
        $this->mengeAktuellerBestand = $mengeAktuellerBestand;
    }

    /**
     * @return mixed
     */
    public function getErsteller()
    {
        return $this->ersteller;
    }

    /**
     * @param mixed $ersteller
     */
    public function setErsteller($ersteller)
    {
        $this->ersteller = $ersteller;
    }

    /**
     * @return mixed
     */
    public function getVonFilialbezeichnung()
    {
        return $this->vonFilialbezeichnung;
    }

    /**
     * @param mixed $vonFilialbezeichnung
     */
    public function setVonFilialbezeichnung($vonFilialbezeichnung)
    {
        $this->vonFilialbezeichnung = $vonFilialbezeichnung;
    }

    /**
     * @return mixed
     */
    public function getVonFilialnummer()
    {
        return $this->vonFilialnummer;
    }

    /**
     * @param mixed $vonFilialnummer
     */
    public function setVonFilialnummer($vonFilialnummer)
    {
        $this->vonFilialnummer = $vonFilialnummer;
    }

    /**
     * @return mixed
     */
    public function getAnFilialbezeichnung()
    {
        return $this->anFilialbezeichnung;
    }

    /**
     * @param mixed $anFilialbezeichnung
     */
    public function setAnFilialbezeichnung($anFilialbezeichnung)
    {
        $this->anFilialbezeichnung = $anFilialbezeichnung;
    }

    /**
     * @return mixed
     */
    public function getAnFilialnummer()
    {
        return $this->anFilialnummer;
    }

    /**
     * @param mixed $anFilialnummer
     */
    public function setAnFilialnummer($anFilialnummer)
    {
        $this->anFilialnummer = $anFilialnummer;
    }

    /**
     * @return mixed
     */
    public function getLieferant()
    {
        return $this->lieferant;
    }

    /**
     * @param mixed $lieferant
     */
    public function setLieferant($lieferant)
    {
        $this->lieferant = $lieferant;
    }

    /**
     * @return mixed
     */
    public function getKategorie()
    {
        return $this->kategorie;
    }

    /**
     * @param mixed $kategorie
     */
    public function setKategorie($kategorie)
    {
        $this->kategorie = $kategorie;
    }

    /**
     * @return mixed
     */
    public function getFlaechengruppe()
    {
        return $this->flaechengruppe;
    }

    /**
     * @param mixed $flaechengruppe
     */
    public function setFlaechengruppe($flaechengruppe)
    {
        $this->flaechengruppe = $flaechengruppe;
    }

    /**
     * @return mixed
     */
    public function getArtikelnummer()
    {
        return $this->artikelnummer;
    }

    /**
     * @param mixed $artikelnummer
     */
    public function setArtikelnummer($artikelnummer)
    {
        $this->artikelnummer = $artikelnummer;
    }

    /**
     * @return mixed
     */
    public function getWarengruppe()
    {
        return $this->warengruppe;
    }

    /**
     * @param mixed $warengruppe
     */
    public function setWarengruppe($warengruppe)
    {
        $this->warengruppe = $warengruppe;
    }

    /**
     * @return mixed
     */
    public function getKredArtNr()
    {
        return $this->kredArtNr;
    }

    /**
     * @param mixed $kredArtNr
     */
    public function setKredArtNr($kredArtNr)
    {
        $this->kredArtNr = $kredArtNr;
    }

    /**
     * @return mixed
     */
    public function getModellNr()
    {
        return $this->modellNr;
    }

    /**
     * @param mixed $modellNr
     */
    public function setModellNr($modellNr)
    {
        $this->modellNr = $modellNr;
    }

    /**
     * @return mixed
     */
    public function getArtikelBezeichnung()
    {
        return $this->artikelBezeichnung;
    }

    /**
     * @param mixed $artikelBezeichnung
     */
    public function setArtikelBezeichnung($artikelBezeichnung)
    {
        $this->artikelBezeichnung = $artikelBezeichnung;
    }

    /**
     * @return mixed
     */
    public function getKredFarbe()
    {
        return $this->kredFarbe;
    }

    /**
     * @param mixed $kredFarbe
     */
    public function setKredFarbe($kredFarbe)
    {
        $this->kredFarbe = $kredFarbe;
    }

    /**
     * @return mixed
     */
    public function getStrichcode()
    {
        return $this->strichcode;
    }

    /**
     * @param mixed $strichcode
     */
    public function setStrichcode($strichcode)
    {
        $this->strichcode = $strichcode;
    }

    /**
     * @return mixed
     */
    public function getFarbe()
    {
        return $this->farbe;
    }

    /**
     * @param mixed $farbe
     */
    public function setFarbe($farbe)
    {
        $this->farbe = $farbe;
    }

    /**
     * @return mixed
     */
    public function getGroesse()
    {
        return $this->groesse;
    }

    /**
     * @param mixed $groesse
     */
    public function setGroesse($groesse)
    {
        $this->groesse = $groesse;
    }

    /**
     * @return mixed
     */
    public function getUmlagerungsNummer()
    {
        return $this->umlagerungsNummer;
    }

    /**
     * @param mixed $umlagerungsNummer
     */
    public function setUmlagerungsNummer($umlagerungsNummer)
    {
        $this->umlagerungsNummer = $umlagerungsNummer;
    }

    /**
     * @return mixed
     */
    public function getBemerkung()
    {
        return $this->bemerkung;
    }

    /**
     * @param mixed $bemerkung
     */
    public function setBemerkung($bemerkung)
    {
        $this->bemerkung = $bemerkung;
    }

    /**
     * @return mixed
     */
    public function getGueltigAb()
    {
        return $this->gueltigAb;
    }

    /**
     * @param mixed $gueltigAb
     */
    public function setGueltigAb($gueltigAb)
    {
        $this->gueltigAb = $gueltigAb;
    }

    /**
     * @return mixed
     */
    public function getLieferDatum()
    {
        return $this->lieferDatum;
    }

    /**
     * @param mixed $lieferDatum
     */
    public function setLieferDatum($lieferDatum)
    {
        $this->lieferDatum = $lieferDatum;
    }



}