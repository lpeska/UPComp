<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "../public/UPCompCore.php";
UPCompCore::loadCoreEvents();

if(strpos($_POST["objectID"], ",")!==false){

    $objects = explode(",", $_POST["objectID"]);
    foreach($objects as $obj){
        $ev =  new TestingEvent($_POST["userID"], $obj, $_POST["eventName"], $_POST["eventValue"], $_POST["where"]);
       // echo $ev->getSQL();
        $eHandler = new TestingEventHandler($ev);
        $eHandler->saveEvent();
    }
}else {

    $ev =  new TestingEvent($_POST["userID"], $_POST["objectID"], $_POST["eventName"], $_POST["eventValue"], $_POST["where"]);
    $eHandler = new TestingEventHandler($ev);
   // echo $ev->getSQL();
    $eHandler->saveEvent();
}

?>
