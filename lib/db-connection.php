<?php
class DBConnection
{
    public static $connection;

    public static function connect()
    {
        self::connect_to_database_server();
        self::select_database();
    }

    public static function transaction($function, ...$args)
    {

        self::$connection::begin_transaction;
        $function(...$args);
        self::$connection::end_transaction;
    }

    public static function connect_to_database_server()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DBConfig::$hostname, DBConfig::$username, DBConfig::$password) or die("Unable to connect to database server");
            $GLOBALS["db_connection"] = self::$connection;
        }
    }

    public static function select_database()
    {
        self::$connection->select_db(DBConfig::$database) or die("Unable to select database");
    }

    public static function disconnect()
    {
        if (isset(self::$connection)) {
            self::$connection->close();
            self::$connection = null;
        }
    }

    public static function execute($sql_statement, ?string $types, ...$data)
    {
        if (gettype($sql_statement) === SQLStatement) {
            return $sql_statement->execute();
        } elseif (gettype($sql_statement) === string) {
            (new SQLStatement($sql_statement, $data, $types))->execute();
        }
    }
}
