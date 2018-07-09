<?php

namespace app;

use app\config as cfg;

class db
{
    private static $instance    = null;
    private static $dbOptions   = array(
        \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES     => true,
    );
    
    private function __construct () {}
    private function __clone () {}
    private function __wakeup () {}

    public static function getInstance () {
        if (self::$instance === null) {
            $DSN = cfg::DB_SCHEMA . ':'
                . 'host=' . cfg::DB_HOST
                . ';port=' . cfg::DB_PORT
                . ';dbname=' . cfg::DB_NAME
                . ';charset=' . cfg::DB_ENCODING;
            self::$dbOptions[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . cfg::DB_ENCODING;
            try {
                self::$instance = new \PDO($DSN, cfg::DB_USER, cfg::DB_PASSWORD, self::$dbOptions);
            } catch (\PDOException $e) {
                die('PDO connection error! '. $e->getMessage() . PHP_EOL);
            } catch (\Exception $e) {
                die('Error! '. $e->getMessage() . PHP_EOL);
            }
        }

        return self::$instance;
    }
}