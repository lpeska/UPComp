<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 * this is UPCompDatabaseInterface interface implementation for the MySQL database
 * @author peska
 */
 class UPCompDatabase implements UPCompDatabaseInterface{
     private $db_connection;
     private $db_result;
     static private $instance;
    //put your code here

/**
 * returns instance of the class (Singleton Design Pattern)
 * @return <type>
 */
    public static function get_instance() {
   	if( !isset(self::$instance) ) {
            self::$instance = new UPCompDatabase();
    	}
	return self::$instance ;
    }

    private function __construct() {
        $this->connect();
    }
/**
 * Connecting to the database
 */
    public function connect() {

        $dbServer = "localhost"; //server adress
	$dbName = "root";		//MySQL username
	$dbPasswd = "";			//password
	$dbNameOfDatabase = "test";	//Database name

        $this->db_connection = mysql_connect($dbServer, $dbName, $dbPasswd) or die(mysql_error());
	$this->db_result = mysql_select_db($dbNameOfDatabase, $this->db_connection) or die(mysql_error());

        mysql_query("SET character_set_results=cp1250");
        mysql_query("SET character_set_connection=UTF8");
        mysql_query("SET character_set_client=cp1250");

        }
/**
 * Disconnecting from the DB
 */
    public function disconnect() {
          mysql_close($this->db_connection);
        }

/**
 * get next row from the MySQL Resource (if there is any)
 * @param <type> $resource MySQL resource
 * @return <type> array - row from the resource
 */
    public function getNextRow($resource){
        return mysql_fetch_array($resource);
    }

/**
 * executes Query, creates and returns QueryResponse class
 * @param <type> $query SQL query
 * @return QueryResponse instance of QueryResponse class
 */
    public function executeQuery($query) {
            $query = mysql_query($query, $this->db_connection);
            if( mysql_errno($this->db_connection) ){
                $error = " - ".mysql_error($this->db_connection);
                $errno = mysql_errno($this->db_connection);
                $state = 0;
            }else{
                $error = "";
                $errno = "";
                $state = 1;

            }

            return new QueryResponse($state, $errno.$error, $query);
        }
/**
 * returns last inserted ID to the database
 * @return <type> int last inserted id
 */
    public function getInsertedId(){
        return mysql_insert_id();
    }
/**
 * free Mysql resource
 * @param <type> $resuorce Mysql resource
 */
    public function freeResult($resuorce){
        if(is_resource($resource)){
            return mysql_free_result($resource);
        }else{
            return false;
        }
    }
}
?>
