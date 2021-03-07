<?php
namespace Tests;

include_once __DIR__ . '/../program/database.php';

use PHPUnit\Framework\TestCase;
use Program\Database;

class DatabaseTest extends TestCase
{
    public function testConnect_IncorrectDatabaseConnection_ReturnsNothing()
    {
        $database = new Database();

        $result = $database->connect("", "", "", "");

        $this->assertNull($result);
    }


    public function testConnect_CorrectDatabaseConnection_ReturnsNothing()
    {
        $database = new Database();
        $config = include __DIR__ . "/../program/config.php";

        $result = $database->connect($config->host, $config->username, $config->password, $config->database);
        
        $this->assertNull($result);
    }


    public function testConnect_ConnectToAnotherDatabaseWhileAlreadyConnected_ReturnsNothing()
    {
        $database = new Database();
        $config = include __DIR__ . "/../program/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        
        $result = $database->connect($config->host, $config->username, $config->password, $config->database);
        
        $this->assertNull($result);
    }


    public function testDisconnect_DisconnectDatabaseConnection_ReturnsNothing()
    {
        $database = new Database();
        $config = include __DIR__ . "/../program/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);

        $result = $database->disconnect();

        $this->assertNull($result);
    }


    public function testDisconnect_DisconnectUnconnectedDatabaseConnection_ReturnsNothing()
    {
        $database = new Database();

        $result = $database->disconnect();

        $this->assertNull($result);
    }


    public function testGetConnection_RetrievesConnectedDatabaseConnection_ReturnsPdoObject()
    {
        $database = new Database();
        $config = include __DIR__ . "/../program/config.php";
        $database->connect($config->host, $config->username, $config->password, $config->database);
        
        $result = $database->getConnection();

        $this->assertIsObject($result);
    }


    public function testGetConnection_RetrievesUnconnectedDatabaseConnection_ReturnsNull()
    {
        $database = new Database();
        
        $result = $database->getConnection();

        $this->assertNull($result);
    }
}

?>
