<?php
namespace app\database;

use PDO;

class Connection
{
    private static $pdoInstance = null;

    public static function getConnection()
    {
        if (empty(self::$pdoInstance)) {
            self::$pdoInstance = new PDO("mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']}", $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$pdoInstance;
    }
}
