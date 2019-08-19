<?php

require_once 'db_cfg.php';

class Database
{
    // Store the single instance of Database
    private static $m_pInstance;
    private $mysqli;

    // Private constructor to limit object instantiation to within the class
    private function __construct()
    {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            die("Не удалось подключиться к MySQL: " . $this->mysqli->connect_error);
        }
    }

    // Getter method for creating/returning the single instance of this class
    public static function getInstance()
    {
        if (!self::$m_pInstance) {
            self::$m_pInstance = new Database();
        }
        return self::$m_pInstance;
    }

    public function query($query)
    {
        $queryResult = $this->mysqli->query($query);

        if(!$queryResult)
            return false;

        return $queryResult;
    }
}
