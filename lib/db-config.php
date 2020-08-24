<?php
class DBConfig
{
    public static $hostname;
    public static $username;
    public static $password;
    public static $database;

    public static function load_config()
    {
        if ($url = getenv('JAWSDB_URL')) {
            $dbparts = parse_url($url);
            self::$hostname = $dbparts['host'];
            self::$username = $dbparts['user'];
            self::$password = $dbparts['pass'];
            self::$database = ltrim($dbparts['path'], '/');
        } else {
            self::$hostname = "localhost";
            self::$username = "root";
            self::$password = "";
            self::$database = "chess";
        }
    }
}
DBConfig::load_config();
