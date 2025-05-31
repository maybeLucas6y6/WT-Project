<?php
class Database {
    private $host = "database-1.ctigssii84mr.eu-north-1.rds.amazonaws.com";
    private $port = "5432";
    private $dbname = "TW_Database";
    private $user = "postgres";
    private $password = "postgres";
    private $connection;

    public function __construct() {
        $connString = "host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password}";
        $this->connection = pg_connect($connString);

        if (!$this->connection) {
            die("Error: Unable to open database\n");
        } else {
            echo "Opened database successfully\n";
        }
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