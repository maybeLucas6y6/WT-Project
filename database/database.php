<?php
class Database {
    private static $instance = null;
    private $host = "database-1.ctigssii84mr.eu-north-1.rds.amazonaws.com";
    private $port = "5432";
    private $dbname = "TW_Database";
    private $user = "postgres";
    private $password = "postgres";
    private $connection;

    private function __construct() {
        $connString = "host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password}";
        $this->connection = pg_connect($connString);

        if (!$this->connection) {
            die("Error: Unable to open database\n");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }


    public function __destruct() {
        if ($this->connection) {
            pg_close($this->connection);
        }
    }
}
?>