<?php

namespace App\Db;

class Conexao
{
    private static $db_host = '127.0.0.1';
    private static $db_name = 'cesar';
    private static $db_user = 'root';
    private static $db_pass = '';

    private static $instancia;

    public static function getInstancia()
    {
        if (empty(self::$instancia)) {
            try {
                self::$instancia = new \PDO(
                    "mysql:host=". self::$db_host . ";dbname=" . self::$db_name,
                    self::$db_user,
                    self::$db_pass,
                    [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
                    ]
                );
            } catch (\PDOException $exception) {
                var_dump($exception);
            }
        }

        return self::$instancia;
    }
}