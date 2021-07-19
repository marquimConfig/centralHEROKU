<?php


namespace App\Api\Connect;

use \PDO;
use \PDOException;

class ConnectElite
{
    /**
     * Constantes com insformações de acesso ao banco da Slave da elite Soft.
     */
     private const HOSTISP = "189.84.44.5";
     private const USERDBISP = "megalink";
     private const DBNAMEISP = "megalink";
     private const PASSWORD = "dvvyzSuk75";

    //private const HOSTISP = "127.0.0.1";
    //private const USERDBISP = "root";
    //private const DBNAMEISP = "megalink";
    //private const PASSWORD = "";

    private const OPTIONSISP = array(
        //
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        /** Toda erro deve ser tratado por Exception */
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        /** Toda retorn será tratado como Obijeto */
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        /**  Garante o mesmo nome da Tabela do banco */
        PDO::ATTR_CASE =>  PDO::CASE_NATURAL
    );
    /**
     * Static definida para apenas ser realizado uma conexão por usuario!
     */
    private static $instanceISP;


    /**
     * Instancia para realizar conexão e execução no banco;
     * @return PDO
     */
    public static function getInstanceISP(): PDO
    {
        if (empty(self::$instanceISP)){
            try {
                self::$instanceISP = new PDO(
                    "mysql:host=" . self::HOSTISP . ";dbname=" . self::DBNAMEISP,
                    self::USERDBISP,
                    self::PASSWORD,
                    self::OPTIONSISP
                );
            } catch (PDOException $exception){
                die("<h1>Erro ao conectar</h1>");
            }
        }
        return self::$instanceISP;
    }

    /**
     * Função definica para que não seja possivel ser contruidas novas seções.
     */
    final private function __construct()
    {
    }

    /**
     * Função definida para que não sejá póssivel ser clonada a Instance acima.
     */
   /* final private function __clone()
    {
    }*/

}