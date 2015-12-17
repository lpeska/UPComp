<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Core
 *
 * @author peska
 */
class UPCompCore {

    private static $userID;
    private static $baseDir = "./component";
    private static $baseDirEvents = "..";
    private static $componentLocation = "/component";

    /**
     * loads all necessary classes of the component
     * @param <type> $configName optional: name of the config file - if not specified, using Config.php
     */
    public static function loadCore($configName="Config.php"){
        //including config file
        require_once(UPCompCore::$baseDir."/config/".$configName);

        //including interfaces
        require_once(UPCompCore::$baseDir."/interface/UPCompDatabaseInterface.php");
        require_once(UPCompCore::$baseDir."/interface/ObjectRating.php");
        require_once(UPCompCore::$baseDir."/interface/ObjectSimilarity.php");
        require_once(UPCompCore::$baseDir."/interface/QueryHandler.php");
        require_once(UPCompCore::$baseDir."/interface/QueryToDatabaseInteraction.php");
        require_once(UPCompCore::$baseDir."/interface/UserSimilarity.php");
        require_once(UPCompCore::$baseDir."/interface/Collaborative.php");
        require_once(UPCompCore::$baseDir."/interface/EventHandler.php");
        require_once(UPCompCore::$baseDir."/interface/EventHandlerReturnedValue.php");

       //including abstract methods
        require_once(UPCompCore::$baseDir."/abstract/AbstractMethod.php");

        /**
         * !!!Including database implementation!!! change here in case of changing DB
         */
        require_once(UPCompCore::$baseDir."/objects/MySQLDatabase.php");

       //including objects
        require_once(UPCompCore::$baseDir."/objects/Attribute.php");
        require_once(UPCompCore::$baseDir."/objects/AttributeFactory.php");
        require_once(UPCompCore::$baseDir."/objects/ObjectExpression.php");
        require_once(UPCompCore::$baseDir."/objects/Error.php");
        require_once(UPCompCore::$baseDir."/objects/Query.php");
        require_once(UPCompCore::$baseDir."/objects/QueryResponse.php");
        require_once(UPCompCore::$baseDir."/objects/UserExpression.php");
        require_once(UPCompCore::$baseDir."/objects/ExtendedQueryToDatabaseInteraction.php");
        require_once(UPCompCore::$baseDir."/objects/BasicQueryToDatabaseInteraction.php");

       /**
        * including evaulating methods: change here if you want to add another method
        */
        require_once(UPCompCore::$baseDir."/methods/Aggregated.php");
        require_once(UPCompCore::$baseDir."/methods/Dummy.php");
        require_once(UPCompCore::$baseDir."/methods/Standard.php");
        require_once(UPCompCore::$baseDir."/methods/Attributes.php");
        require_once(UPCompCore::$baseDir."/methods/Randomized.php");
        require_once(UPCompCore::$baseDir."/methods/NRmse.php");
        require_once(UPCompCore::$baseDir."/methods/PearsonCorrelation.php");

        //including public methods
        require_once(UPCompCore::$baseDir."/public/BasicQueryHandler.php");
        require_once(UPCompCore::$baseDir."/public/ExtendedQueryHandler.php");
        require_once(UPCompCore::$baseDir."/public/ComplexQueryHandlerReverse.php");

        require_once(UPCompCore::$baseDir."/public/ErrorLog.php");
        require_once(UPCompCore::$baseDir."/public/ComponentInfo.php");
        require_once(UPCompCore::$baseDir."/public/UserHandler.php");
        require_once(UPCompCore::$baseDir."/public/ExplicitEventHandler.php");

        UPCompCore::createUser();
    }

/**
 * find for the userID of the existing user or creates a new one
 */
    private static function createUser() {
        $userHandler = new UserHandler();
        UPCompCore::$userID = $userHandler->getUserID();
    }

    /**
     * getter for the userID
     * @return <type> the id of the user
     */
    public static function getUserId() {
        return UPCompCore::$userID ;
    }

    /**
     * loads java scripts using for gathering User data
     * @param <type> $objectID id of the current object (i.e. showing single objects detail page) - if any
     */
    public static function loadJavaScripts($objectID="null"){
        $uid = UPCompCore::$userID;
        $basicPath = UPCompCore::$componentLocation;
        echo "
            <script  type=\"text/javascript\" language=\"javascript\">
                var userID = ".$uid." ;
                var objectID = ".$objectID.";
            </script>
        ";
        echo "
            <script type=\"text/javascript\" language=\"javascript\" src=\"".$basicPath."/javascript/storeFunctions.js\"></script>
            <script type=\"text/javascript\" language=\"javascript\" src=\"".$basicPath."/javascript/ratingHandlers.js\"></script>
            <script type=\"text/javascript\" language=\"javascript\" src=\"".$basicPath."/javascript/xmlhttp_routines.js\"></script>
        ";

    }

/**
 * load component classes necessary for saving an event
 * this method is used by the Component itself only
 * @param <type> $configName optional: name of the config file - if not specified, using Config.php
 */
    public static function loadCoreEvents($configName="Config.php"){
        //including config file
        require_once(UPCompCore::$baseDirEvents."/config/".$configName);

        //including interfaces
        require_once(UPCompCore::$baseDirEvents."/interface/UPCompDatabaseInterface.php");
        require_once(UPCompCore::$baseDirEvents."/interface/EventHandler.php");
        require_once(UPCompCore::$baseDirEvents."/interface/EventHandlerReturnedValue.php");

        /**
         * !!!Including database implementation!!! change here in case of changing DB
         */
        require_once(UPCompCore::$baseDirEvents."/objects/MySQLDatabase.php");

       //including objects
        require_once(UPCompCore::$baseDirEvents."/objects/AggregatedDataEvent.php");
        require_once(UPCompCore::$baseDirEvents."/objects/ExplicitUserDataEvent.php");
        require_once(UPCompCore::$baseDirEvents."/objects/ImplicitUserDataEvent.php");
        require_once(UPCompCore::$baseDirEvents."/objects/TestingEvent.php");
        require_once(UPCompCore::$baseDirEvents."/objects/QueryResponse.php");

        //including public methods
        require_once(UPCompCore::$baseDirEvents."/public/AggregatedEventHandler.php");
        require_once(UPCompCore::$baseDirEvents."/public/ExplicitEventHandler.php");
        require_once(UPCompCore::$baseDirEvents."/public/ImplicitEventHandler.php");
        require_once(UPCompCore::$baseDirEvents."/public/TestingEventHandler.php");
    }
}
?>
