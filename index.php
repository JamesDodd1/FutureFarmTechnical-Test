<?php
namespace FutureFarm;

include_once __DIR__ . "/program/chemicalOrders.php";

use Program\ChemicalOrders;


$chemicalOrders = new ChemicalOrders();

/*
// Print returned array's details
echo "<pre>";
print_r($chemicalOrders->getNextChemicalOrderDetails());
echo "</pre>";
*/


// Print returned array's variables 
foreach ($chemicalOrders->getNextChemicalOrderDetails() as $order) {
    echo "<b> Type: </b> $order->chemical <br>
          <b> Amount: </b> $order->numToBuy Litres <br>
          <b> Cost: </b> £$order->cost <br>
          <b> Date To Buy: </b> " . $order->dateToBuy->format('Y-m-d') . " <br> <br>";
}

?>
