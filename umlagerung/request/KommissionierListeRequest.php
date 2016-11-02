<?php

/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 08.08.2016
 * Time: 18:22
 */
class KommissionierListeRequest
{
    /**
     * @XmlElement(name = "UmlagerungsNummer", required=true)
     */

    public $umlagerungsNummer;

    /**
     * @return string
     */
    public function getUmlagerungsNummer()
    {
        return $this->umlagerungsNummer;
    }

    /**
     * @param void $umlagerungsNummer
     */
    public function setUmlagerungsNummer($umlagerungsNummer)
    {
        $this->umlagerungsNummer = $umlagerungsNummer;
    }

}