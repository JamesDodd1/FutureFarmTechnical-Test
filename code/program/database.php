<?php
namespace Program;

use PDO;
use PDOException;

class Database
{
    private $conection;

    public function __construct()
    {
        $this->conection = null;
    }


    public function __destruct()
    {
        $this->disconnect();
    }


    /** Create connection to a database */
    public function connect(string $host, string $username, string $password, string $database) 
    {
        // Already connect to a database
        if (!is_null($this->conection)) { return; }


        $connect = "mysql:host=$host; dbname=$database; charset=utf8";
        
        try {
            $pdo = new PDO($connect, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conection = $pdo;
        } 
        catch (PDOException $error) {
            echo "Connection failed: " . $error->getMessage();
        }
    }


    /** Closes connection to the current database */
    public function disconnect()
    {
        $this->connection = null;
    }


    public function getConnection() { return $this->conection; }
}

?>
