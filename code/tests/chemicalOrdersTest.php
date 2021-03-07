<?php
namespace Tests;

include_once __DIR__ . '/../program/chemicalOrders.php';

use PHPUnit\Framework\TestCase;
use Program\ChemicalOrders;

class ChemicalOrdersTest extends TestCase
{
    public function testGetNextChemicalOrderDetails_DataRetrievedFromDatabase_ReturnsArray() {
        $chemicalOrders = new ChemicalOrders();

        $result = $chemicalOrders->getNextChemicalOrderDetails();

        $this->assertIsArray($result);
    }
}

?>