<?php


namespace App;


class Connection{
    private static $host = 'localhost';
    private static $db = 'MF';
    private static $username = 'root';
    private static $password = '';

    public static function getDb(){
        try {
            $conn = new \PDO("mysql:hostname=".self::$host.";dbname=".self::$db,self::$username, self::$password);

            //echo '<p>Conexão realizada com sucesso.</p>';
            return $conn;

        } catch (\PDOException $e) {
            echo '<p>Erro: </p>' . $e->getCode();
            echo '<p>Mensagem: </p>' . $e->getMessage();
        }
    }

}