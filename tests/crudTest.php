<?php
namespace Tests;

include_once __DIR__ . '/../program/crud.php';

use PHPUnit\Framework\TestCase;
use Program\Database;
use Program\Crud;

class CrudTest extends TestCase
{
    public function testSelect_DatabaseConnectionNotSet_ReturnsNull()
    {
        $databaseConnection = null;
        $crud = new Crud($databaseConnection);
        $sql = "SELECT * FROM `Field`";

        $result = $crud->select($sql);

        $this->assertNull($result);
    }
    
    
    public function testSelect_SqlSelectQueryForMultipleRows_ReturnsArray()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "SELECT * FROM `Field`";

        $result = $crud->select($sql);

        $this->assertIsArray($result);
    }


    public function testSelect_SqlSelectQueryForOneRow_ReturnsArray()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "SELECT * FROM `Field` LIMIT 1";

        $result = $crud->select($sql);

        $this->assertIsArray($result);
    }


    public function testSelect_SqlSelectQueryForNoRow_ReturnsNull()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "SELECT * FROM `Field` LIMIT 0";

        $result = $crud->select($sql);

        $this->assertNull($result);
    }
    
    
    public function testSelect_SqlSelectQueryWithParameters_ReturnsArray()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "SELECT * FROM `Field` WHERE `FieldID` = ?";
        $parameters = [1];

        $result = $crud->select($sql, $parameters);

        $this->assertIsArray($result);
    }
    
    
    /** @dataProvider incorrectNumOfParameters */
    public function testSelect_IncorrectNumOfParameters_ReturnsNull(Array $parameters)
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "SELECT * FROM `Field` WHERE `FieldID` = ?";

        $result = $crud->select($sql, $parameters);

        $this->assertNull($result);
    }


    private function incorrectNumOfParameters()
    {
        return [
            [ [] ],
            [ [1, 2] ]
        ];
    }
    
    
    public function testSelect_IncorrectSqlSelectQuery_ReturnsNull()
    {
        $database = new Database();
        $config = include __DIR__ . "/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        $crud = new Crud($database->getConnection());
        $sql = "";

        $result = $crud->select($sql);

        $this->assertNull($result);
    }
}

?>
