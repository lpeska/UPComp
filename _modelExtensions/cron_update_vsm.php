<?php

//database connection
$db_server="localhost";
$db_jmeno="username";
$db_heslo="password";
$db_nazev_db="database_name";

    $db_spojeni = mysql_connect($db_server, $db_jmeno, $db_heslo) or die("Nepodaøilo se pøipojení k databázi - pravdìpodobnì se jedná o krátkodobé problémy na serveru. " . mysql_error());
    $db_vysledek = mysql_select_db($db_nazev_db, $db_spojeni) or die("Nepodaøilo se otevøení databáze - pravdìpodobnì se jedná o krátkodobé problémy na serveru. " . mysql_error());

    //nastaveni kodovani
    mysql_query("SET character_set_results=cp1250");
    mysql_query("SET character_set_connection=UTF8");
    mysql_query("SET character_set_client=cp1250");
       
     function divideToIntervals($value, $intervals, $name){
         foreach ($intervals as $key => $valueInt) {
             if($key >0){
                if($value <= $valueInt and $value > $intervals[$key-1]){
                 //current interval                 
                 return array($name.$valueInt);
                }
             }
         }
         return array();
     }

     function getTermsFromText($text){
         $text_array = preg_split("/[\s,\.]+/", $text);
         $result = array(); 
         foreach ($text_array as $key => $text_item) {   
            $text_item = trim(strtolower($text_item));
                //zde by se mohly vyhazovat stop slova
                if($text_item!=""){
                    $result[] = $text_item;
                }
                 
         }
         return $result;
     }

     /**
      * This method transforms SQL result row into an array of binary attributes and insetrs it into vsm_object_model table
      * Method needs to be updated while migrating on another domain
      * @param type $row
      */
function create_vsm_model($row){
    $query_insert_features = "INSERT INTO `vsm_object_model`(`oid`, `relevance`, `feature`) VALUES ";
    $first = 1;
    $binTerms = array();                
    //nominal and text attributes
    $binTerms = array_merge($binTerms, getTermsFromText("tp_".$row["id_typ"]));
    $binTerms = array_merge($binTerms, getTermsFromText("s_".$row["strava"]));

    //numerical attributes
    if($row["duration"]>=0){
        $binTerms = array_merge($binTerms, 
            divideToIntervals($row["delka"],array(-1,3,6,9,15,10000), "del"));
    }
    if($row["sleva"]>=0){
        $binTerms = array_merge($binTerms, 
            divideToIntervals($row["sleva"],array(-1,1,6,11,21,10000), "slev"));
    }

    foreach ($binTerms as $key => $term) {                
        if(strlen($term)>2){
            if($first){
                $first = 0;
                $query_insert_features.="(".$row["id_serial"].",1,\"".$term."\")\n"; 
            }else{
                $query_insert_features.=",(".$row["id_serial"].",1,\"".$term."\")\n"; 
            }

        }
                                          
    }
    $query_insert_features.=" ON DUPLICATE KEY UPDATE `relevance`=`relevance`+1";
   // echo nl2br($query_insert_features);    
    mysql_query("DELETE FROM `vsm_object_model` WHERE oid=".$row["id_serial"].""); 
    mysql_query($query_insert_features); 
    //echo "DELETE FROM `vsm_object_model` WHERE oid=".$row["id_serial"]."<br/>";
    //echo $query_insert_features."<br/><br/>";
    echo mysql_error();
}

function calculate_tf_idf(){
    $feature_idf = array();
    $oid_doc_lenght = array();
    $oid_feature_value = array();
    $all_docs = 0;
    
    $query_all_docs = "select count(distinct `oid`) as `oids` from `vsm_object_model` where 1 "; 
    $result = mysql_query($query_all_docs);
    while ($row = mysql_fetch_array($result)) {  
        $all_docs = $row["oids"];
    } 
    
    $query_doc_lenght = "select `oid`, count(distinct `feature`) as `features` from `vsm_object_model` where 1 group by `oid`"; 
    $result = mysql_query($query_doc_lenght);
    while ($row = mysql_fetch_array($result)) {  
        $oid_doc_lenght[$row["oid"]] = $row["features"];
    } 
    
    $query_idf = "select `feature`, sum(`relevance`) as `values` from `vsm_object_model` where 1 group by `feature`"; 
    $result = mysql_query($query_idf);
    while ($row = mysql_fetch_array($result)) {  
        $feature_idf[$row["feature"]] = $row["values"];
    }    
   // print_r($feature_idf);
    
    $query_oid_feature_val = "select *  from `vsm_object_model` where 1 "; 
    $result = mysql_query($query_oid_feature_val);
    while ($row = mysql_fetch_array($result)) {  
        $oid_feature_value[$row["oid"]][$row["feature"]] = $row["relevance"];
    } 
    
    foreach ($oid_feature_value as $oid => $features) {
        foreach ($features as $feature => $value) {
            $tf = $value/$oid_doc_lenght[$oid];
            if($feature_idf[$feature]==0){
                $feature_idf[$feature]=1;
            }
            $idf = log($all_docs/$feature_idf[$feature]);
            $tf_idf = $tf*$idf;
            $update = "update `vsm_object_model` set `relevance`=$tf_idf where `oid`=$oid and `feature`=\"$feature\" limit 1";
            //echo $update."\n<br/>";
            mysql_query($update);
            echo mysql_error();
        }
    }
    
    
}  

        


$sql_serial = "Select <considered attributes> from <object_tables>                  
";
//echo $sql_serial;




$data_serial = mysql_query($sql_serial);

while($row = mysql_fetch_array($data_serial)){
    $serialy = $row;
    create_vsm_model($serialy); 
}
calculate_tf_idf();


?>