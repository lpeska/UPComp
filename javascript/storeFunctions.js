/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var objectOperations = 0;
var limitOperations = 15;
var limitOperations2 = 100;
var dpSent = false;
var dp2Sent = false;


/**
 *this function counts user actions on the page
 *eventually if they reach certain value, it creates xmlHttpRequest and saves deep_pageview implicit event
 * @param value: importance of the user action
 */
function objectOperation(value){
    if(!value){       
        var value=1;
    }
    objectOperations = objectOperations + value;
    if(objectOperations >= limitOperations && !dpSent && userID!=0 && objectID!=0){
        storeImplicitEvent( userID, objectID, "deep_pageview", "1");
        dpSent=true;
    }
    if(objectOperations >= limitOperations2 && !dp2Sent && userID!=0 && objectID!=0){
        storeImplicitEvent( userID, objectID, "deep_pageview", "2");
        dp2Sent=true;
    }
}

/**
 *this function  creates xmlHttpRequest and saves pageview implicit event
 */
function objectOpen(){
    if(userID!=0 && objectID!=0){
        storeImplicitEvent( userID, objectID, "pageview", "1");
    }
}

/**
 *this function  creates xmlHttpRequest and saves order implicit event and
 *object_ordered aggregated event
 */
function objectOrder(level){
    if(userID!=0 && objectID!=0){
        storeImplicitEvent( userID, objectID, "order", level);
        storeAggregatedEvent( objectID, "object_ordered", level);
        storeTestingEvent(userID,objectID, "object_ordered", 1);
    }
}

/**
 *this function  creates xmlHttpRequest and saves user_rating explicit event
 */
function objectRate(objID, rateObtained){
    if(userID!=0 && objID!=0){
        storeExplicitEvent(userID, objID, "user_rating", rateObtained);
    }
}

/**
 *this function  creates xmlHttpRequest and saves object_shown_in_list Aggregated event
 */
function objectsShownInList(objectIDs){
    if(objectIDs!=""){
        storeAggregatedEvent(objectIDs, "object_shown_in_list", "1");
    }
}

/**
 *this function  creates xmlHttpRequest and saves object_opened_from_list Aggregated event
 */
function objectOpenedFromList(objectID){
    if(objectID!=0){
        storeAggregatedEvent(objectID, "object_opened_from_list", "1");
    }
}

function objectsShownInRecomendedList(objectIDs){
    if(objectIDs!=""){
        storeTestingEvent(userID,objectIDs, "object_shown_in_list", "1","recomended");
        storeAggregatedEvent(objectIDs, "object_shown_in_list", "1");
    }
}
function objectOpenedFromRecomendedList(objectID){
    if(objectID!=0){
        storeTestingEvent(userID,objectID, "object_opened_from_list", "1","recomended");
        storeAggregatedEvent(objectID, "object_opened_from_list", "1");
    }
}

function objectsShownInRelatedList(objectIDs){
    if(objectIDs!=""){
        storeTestingEvent(userID,objectIDs, "object_shown_in_list", "1","related");
        storeAggregatedEvent(objectIDs, "object_shown_in_list", "1");
    }
}
function objectOpenedFromRelatedList(objectID){
    if(objectID!=0){
        storeTestingEvent(userID,objectID, "object_opened_from_list", "1","related");
        storeAggregatedEvent(objectID, "object_opened_from_list", "1");
    }
}

function objectsShownInDetailedSearch(objectIDs){
    if(objectIDs!=""){
        storeTestingEvent(userID,objectIDs, "object_shown_in_list", "1","detailSearch");
        storeAggregatedEvent(objectIDs, "object_shown_in_list", "1");
    }
}
function objectOpenedFromDetailedSearch(objectID){
    if(objectID!=0){
        storeTestingEvent(userID,objectID, "object_opened_from_list", "1","detailSearch");
        storeAggregatedEvent(objectID, "object_opened_from_list", "1");
    }
}

function storeImplicitEvent(userID, objectID, eventName, eventValue) {
	var paramString = "";
	paramString += "userID=" + userID;
        paramString += "&objectID=" + objectID;
        paramString += "&eventName=" + eventName;
        paramString += "&eventValue=" + eventValue;

	// send request
	send_xmlhttprequest(readyStateRoutine, 'POST', '/component/public/storeImplicitEvent.php',paramString, {"Content-Type" : "application/x-www-form-urlencoded"},objectID);
}

function storeExplicitEvent(userID, objectID, eventName, eventValue) {
	var paramString = "";
	paramString += "userID=" + userID;
        paramString += "&objectID=" + objectID;
        paramString += "&eventName=" + eventName;
        paramString += "&eventValue=" + eventValue;

	// send request
	send_xmlhttprequest(explicitEventReadyStateRoutine, 'POST', '/component/public/storeExplicitEvent.php',paramString, {"Content-Type" : "application/x-www-form-urlencoded"},objectID);
}
function storeAggregatedEvent(objectIDs, eventName, eventValue) {
	var paramString = "";
        paramString += "&objectID=" + objectIDs;
        paramString += "&eventName=" + eventName;
        paramString += "&eventValue=" + eventValue;

	// send request
	send_xmlhttprequest(readyStateRoutine, 'POST', '/component/public/storeAggregatedEvent.php',paramString, {"Content-Type" : "application/x-www-form-urlencoded"},objectIDs);
}

function storeTestingEvent(userID, objectIDs, eventName, eventValue, where) {
	var paramString = "";
        paramString += "userID=" + userID;
        paramString += "&objectID=" + objectIDs;
        paramString += "&eventName=" + eventName;
        paramString += "&eventValue=" + eventValue;
        paramString += "&where=" + where;
	// send request
	send_xmlhttprequest(readyStateRoutine2, 'POST', '/component/public/storeTesting.php',paramString, {"Content-Type" : "application/x-www-form-urlencoded"},objectIDs);
}

/**
 *This function is called after change state of any xmlHttpRequest for explicit events
 * when the state is "ready" the function changes rating_objectID innerHTML (shows averange rating of the object)
 */
function explicitEventReadyStateRoutine(xmlhttp, objectID) {
    if (xmlhttp.readyState == 4) {
        // actualization of the current web page in order of (un)succesful operation
        /*result can be:
         *"false" - in case of error while saving the event
         *"0" - unable to get the averange rating
         *"floating point number" success: averange rating of the object
         */
        var result = xmlhttp.responseText;
        var averange = Math.round(result*100);
        document.getElementById("rating_"+objectID).innerHTML = "\
            <div class=\"yellow_bar\" style=\"width:"+(Math.round((result)*65)+12)+"px;\"><img style=\"float:left;\" src=\"/img/stars.gif\" alt=\"Prùmìrné hodnocení: "+averange+"%\" title=\"Prùmìrné hodnocení: "+averange+"%\" /></div>";
        //use the result...
    }
}
function readyStateRoutine2(xmlhttp, objectID) {
	if (xmlhttp.readyState == 4) {
               // window.alert(xmlhttp.responseText);
		return true;
	}
}