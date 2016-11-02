<?php

/**
 * Created by PhpStorm.
 * User: FuchsA
 * Date: 08.08.2016
 * Time: 17:30
 */

include_once './../config/Config.php';
class DB
{
    private $connect = null;

    private $MSSQLpasswort = Config::MSSQLPASSWORT;
    private $MSSQLhost = Config::MSSQLHOSTPRODUKTIV;
    private $MSSQLdbname = Config::MSSQLDBNAME;
    private $MSSQLdbuser = Config::MSSQLDBUSER;

    function DB(){
        $this->connect = new PDO("dblib:host=" . $this->MSSQLhost . ";" . $this->MSSQLdbname, $this->MSSQLdbuser, $this->MSSQLpasswort);
    }

    /**
     * @return null|PDO
     */
    public function getConnect()
    {
        return $this->connect;
    }



}