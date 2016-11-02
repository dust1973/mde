<?php


/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 08.08.2016
 * Time: 17:15
 */

/**
 * @WebService(
 * name = "Umlagerung",
 * targetNamespace = "https://redurunner.zentrale-woehrl.de/")
 * @SOAPBinding(style = SOAPBinding.Style.DOCUMENT, use=SOAPBinding.Use.LITERAL)
 * interface Umlagerung
 */

    interface Umlagerung {

    /**
     * @WebMethod(exclude = false)
     * @WebResult(partName = "return")
     *
     */

    public function getKommissionierListe($umlagerungsNummer);


     /**
     * @WebMethod(exclude = false)
     * @WebResult(partName = "Pong")
     *
     */

     public function pingPong();
}