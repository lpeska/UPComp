<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractObjectRating
 *
 * @author peska
 */
abstract class AbstractMethod{
    //put your code here
    protected $eventImportance;
    /**
     *sets importance to the specified events (implicit, explicit or aggregated)
     * @param <type> $eventArray array of eventName => eventImportance; importance is positive int
     */
    public function setEventsImportance($eventArray) {
        $this->eventImportance = $eventArray;
    }
}
?>
