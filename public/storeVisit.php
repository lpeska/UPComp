<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once "../public/ComponentCore.php";

//loadCore every time when computing meta preferences (PreferenceComputation)
    ComponentCore::loadCoreEvents();

    
//name of the target table
//database connection needs to be established

$tableName = "implicit_events";

if($_POST["visitID"]>0){
    $visit_name = "`visitID`,";
    $visit_val = "".$_POST["visitID"].",";
}else{
    $visit_name = "";
    $visit_val = "";
}

//create SQL code
$sql = "
insert into `".$tableName."`
     (".$visit_name." `userID`,`objectID`,`sessionID`,`pageID`,`pageType`,`imagesCount`,
         `textSizeCount`,`linksCount`,`windowSizeX`,`windowSizeY`,`pageSizeX`,`pageSizeY`,`objectsListed`,
      `startDatetime`,`endDatetime`,`timeOnPage`,`mouseClicksCount`,`pageViewsCount`,`mouseMovingTime`,
      `mouseMovingDistance`,`scrollingCount`,`scrollingTime`,`scrollingDistance`,
      `printPageCount`,`selectCount`,`selectedText`,`copyCount`,`copyText`,`clickOnPurchaseCount`,
      `purchaseCount`,`forwardingToLinkCount`,`forwardedToLink`,`logFile`) 
     VALUES ( ".$visit_val." ".$_POST["userID"].",  ".$_POST["objectID"].",".$_POST["sessionID"].",\"".$_POST["pageID"]."\", \"".$_POST["pageType"]."\",".$_POST["imagesCount"].",
              ".$_POST["textSizeCount"].",".$_POST["linksCount"].", ".$_POST["windowSizeX"].", ".$_POST["windowSizeY"].", ".$_POST["pageSizeX"].", ".$_POST["pageSizeY"].", \"".$_POST["objectsListed"]."\",
            \"".$_POST["startDatetime"]."\", \"".$_POST["endDatetime"]."\", ".$_POST["timeOnPageMiliseconds"].", ".$_POST["mouseClicksCount"].", ".$_POST["pageViewsCount"].",".$_POST["mouseMovingTime"].",
              ".$_POST["mouseMovingDistance"].",".$_POST["scrollingCount"].", ".$_POST["scrollingTime"].", ".$_POST["scrollingDistance"].",
              ".$_POST["printPageCount"].",".$_POST["selectCount"].", \"".$_POST["selectedText"]."\", ".$_POST["copyCount"].", \"".$_POST["copyText"]."\", ".$_POST["clickOnPurchaseCount"].", 
              ".$_POST["purchaseCount"].", ".$_POST["forwardingToLinkCount"].",\"".$_POST["forwardedToLink"]."\",\"".$_POST["logFile"]."\"                                                                                                                                     
         )
ON DUPLICATE KEY
UPDATE  `endDatetime`= \"".$_POST["endDatetime"]."\",
        `timeOnPage`= `timeOnPage` + VALUES(`timeOnPage`),
        `mouseClicksCount`= `mouseClicksCount` + VALUES(`mouseClicksCount`),
        `pageViewsCount`= `pageViewsCount` + VALUES(`pageViewsCount`),
        `mouseMovingTime`= `mouseMovingTime` + VALUES(`mouseMovingTime`),
        `mouseMovingDistance`= `mouseMovingDistance` + VALUES(`mouseMovingDistance`),
        `scrollingCount`= `scrollingCount` + VALUES(`scrollingCount`),
        `scrollingTime`= `scrollingTime` + VALUES(`scrollingTime`),
        `scrollingDistance`= `scrollingDistance` + VALUES(`scrollingDistance`),
        `printPageCount`= `printPageCount` + VALUES(`printPageCount`),
        `selectCount`= `selectCount` + VALUES(`selectCount`),
        `selectedText`= concat(`selectedText` , VALUES(`selectedText`)),
        `searchedText`= concat(`searchedText` , VALUES(`searchedText`)),
        `copyCount`= `copyCount` + VALUES(`copyCount`),
        `copyText`= concat(`copyText` , VALUES(`copyText`)),
        `clickOnPurchaseCount`= `clickOnPurchaseCount` + VALUES(`clickOnPurchaseCount`),
        `purchaseCount`= `purchaseCount` + VALUES(`purchaseCount`),
        `forwardingToLinkCount`= `forwardingToLinkCount` + VALUES(`forwardingToLinkCount`),
        `forwardedToLink`= concat( `forwardedToLink` , VALUES(`forwardedToLink`) ),
        `logFile`= concat(`logFile`, VALUES(`logFile`) )
";
//echo $sql;

$database = ComponentDatabase::get_instance();
$database->executeQuery( "SET character_set_client=UTF8" );
$database->executeQuery($sql) ;

            //print_r($_POST);
            //echo $sql;
            //echo mysql_error();
            if(!$_POST["visitID"]>0){
                echo mysql_insert_id();
            }else{
                echo $_POST["visitID"];
            }



?>
