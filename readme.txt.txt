UPComp is a recommending component for PHP/MySQL based e-commerce projects.
UPComp description and detailed documentation is available in 
Ladislav Peska: User preferences in the domain of web shops, Diploma Thesis, Charles University in Prague
you can connect us via peska@ksi.mff.cuni.cz

Following steps are necessary to install UPComp:
1. Upload UPComp to the server

2. Create MySql tables - run createUPCompDb.sql

3. Configurate UPComp for your domain: open UPComp/Config/config.php and set
$objectIDColumnName = name of the objects unique identifier column (e.g. „id_object“)
$objectTableName = name of the table containing all objects (e.g. „objects“)

4. Set correct MySQL connection on /UPComp/Objects/MySQLDatabase.php

5. Link UPComp to your source codes:
<?php
  require_once("./UPComp/public/UPCompCore.php");
  UPCompCore::loadCore();
?>
<head> 
<?php
UPCompCore::loadJavaScripts($objectID);
?>
</head> 
$objectID contains ID of the currently displayed object, otherwise set $objectID=0.

6. Start tracing user feedback, e.g.
<body onload="objectOpen();"> 

7. Run recommendations. See a simple sample below

<?php
$sql="select * from objects limit 10";
$attributes = "";
$userExpr = "";
$objectExpr = array(
//ObjectExpression(MethodType, MethodImportance, MethodName, MethodParameters)
new ObjectExpression("ObjectRating", "1", "Aggregated", array("noOfObjects"=>8, "implicitEventsList" => array("pageview") ) )
);
$qHandler = new ComplexQueryHandler($sql, $attributes,$userExpr, $objectExpr);
$qHandler->sendQuery();
$qResponse = $qHandler->getQueryResponse();
if( $qResponse->getQueryState() ) {
  while($qRow = $qResponse->getNextRow()) {
    print_r($qRow);
  }
}
?>

