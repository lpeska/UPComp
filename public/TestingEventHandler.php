<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImplicitDataSender
 *
 * @author peska
 */
class TestingEventHandler  implements EventHandler{
    //put your code here
    private $event;

    function __construct($event){
        $this->event = $event;
    }

    /**
     * saves event to the database
     */
    function saveEvent(){
        /**
         * TODO: kontrola typu udalosti, pripadne akce svazane s typem
         */

         /* check whether we have an approved event*/
         if( in_array($this->event->getEventType(), Config::$recognizedAggregatedEvent ) ){

            $database = ComponentDatabase::get_instance();
            $implicitTable = Config::$implicitEventStorageTable;
            $sql_vsm = "select count(distinct objectID) as pocet from $implicitTable "
                    . "where userID=".$this->event->getUserID()." and eventType=\"pageview\" ";
            //echo $this->event->getSQL();
            $objects = 0;
            $d = $database->executeQuery($sql_vsm);
            $obj = $d->getResponseList();
            while( $rec = $database->getNextRow($obj) ) {
               $objects = $rec["pocet"];
            }
            //echo $sql_vsm;
            //echo $this->event->getSQL($objects) ;
            $database->executeQuery( $this->event->getSQL($objects) );

         }
    }

}
?>
