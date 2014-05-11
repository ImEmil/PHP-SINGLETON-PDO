<?php
interface iDatabase
{
    const charset = 'utf8';
}

class Database implements iDatabase {

    // DATABASE CONFIGURATION
    static $host    = "localhost";
    static $dbname  = "rc2";
    static $user    = "root";
    static $pass    = "";

    # Don't touch this ;D
    static $PDO_object = null;


    private static function _pObject()
    {
        if (Database::$PDO_object)
            return Database::$PDO_object;

            try
            {
                Database::$PDO_object = new PDO(sprintf("mysql:host=%s;dbname=%s;charset=%s",
                Database::$host,
                Database::$dbname,
                iDatabase::charset),
                self::$user,
                Database::$pass,
                [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            }
            catch (PDOException $e)
            {
                exit($e->getMessage());
            }

        return self::$PDO_object;
    }

    public static function __callStatic($type, $arguments)
    {
    	return call_user_func_array([Database::_pObject(), $type], $arguments);
    }
}


// How to use:

$statement = Database::prepare("INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");
$statement->execute([ "MyNameHere", "Password" ]);

