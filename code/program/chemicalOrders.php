<?php
namespace Program;

include_once __DIR__ . '/crud.php';

use Datetime;

class ChemicalOrders
{
    private $crud;
    const HECTARE = 10000;

    public function __construct() 
    {
        $connection = $this->connectToDatabase();
        $this->crud = new Crud($connection);
    }

    
    private function connectToDatabase()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);

        return $database->getConnection();
    }
    

    /** Retrieves details about when and how much the next chemical purchase will be */
    public function getNextChemicalOrderDetails()
    {
        // For each chemical, the SQL query returns the chemical name, prices, calculates the 
        // total area to be sprayed and the end date of the current spray duration.
        // Any field whose chemical application duration expires before a week from today or 
        // if there is no record of that field being sprayed are returned.
        $sql = "SELECT ch.`Name`, ch.`Price`, SUM(f.`Width` * f.`Length`) AS Area, 
                    DATE_ADD(f.`Sprayed`, INTERVAL (7 * (ch.`Application` - 1)) DAY) AS WeekBeforeEnd
                FROM `Field` f
                INNER JOIN `Crop` c
                    ON f.`CropID` = c.`CropID`
                INNER JOIN `Chemical` ch
                    ON c.`ChemicalID` = ch.`ChemicalID`
                WHERE (f.`CropID`, f.`Sprayed`) IN (
                    SELECT `CropID`, MIN(`Sprayed`) AS Sprayed
                    FROM `Field`
                    GROUP BY `CropID` ASC) 
                OR DATE_ADD(f.`Sprayed`, INTERVAL (7 * (ch.`Application` - 1)) DAY) <= ?
                OR f.`Sprayed` = NULL
                GROUP BY ch.`Name` ASC";

        
        $todayDateTime = new DateTime();
        $parameters = [$todayDateTime->format('Y-m-d')];

        $results = $this->crud->select($sql, $parameters);
        

        // No results found
        if (is_null($results)) { return null; }


        $datesToOrderChemicals = [];

        foreach ($results as $row) {
            $numOfChemicalsNeeded = ceil($row->Area / self::HECTARE);
            $weekBeforeChemicalsSprayEnds = new DateTime($row->WeekBeforeEnd);

            $isChemicalBuyDateInFuture = $weekBeforeChemicalsSprayEnds > $todayDateTime;

            array_push($datesToOrderChemicals, (object) [
                "chemical" => $row->Name,
                "numToBuy" => $numOfChemicalsNeeded,
                "cost" => $numOfChemicalsNeeded * $row->Price,
                "dateToBuy" => $isChemicalBuyDateInFuture ? $weekBeforeChemicalsSprayEnds : $todayDateTime
            ]);
        }
        
        return $datesToOrderChemicals;
    }
}

?>
