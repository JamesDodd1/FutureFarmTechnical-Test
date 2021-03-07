<?php
namespace Program;

include_once __DIR__ . '/database.php';

use PDO;
use PDOException;

class Crud
{
    private $database;

    public function __construct($databaseConnection)
    {
        $this->database = $databaseConnection;
    }


    /** Obtains data from database */
    public function select(string $sql, array $parameters = [])
    {
        // Fail if no connection established
        if (is_null($this->database)) { return null; }

        // Nothing entered
        if (is_null($sql)) { return null; }

        
        try {
            $query = $this->database->prepare($sql);
            $query->execute($parameters);

            $numOfRows = $query->rowCount();

            // Return any rows
            if ($numOfRows != 0)
                return $query->fetchAll(PDO::FETCH_OBJ);
        } 
        catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
        
        return null;
    }
}

?>
