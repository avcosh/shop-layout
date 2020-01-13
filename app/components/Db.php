<?php
namespace Shop\components;
use PDO;
/**
 * Database component
 */
class Db
{

/**
* Establishes a database connection
* @return \PDO Object of the PDO class for working with the database
*/
    
   public static function getConnection()
    {
        
        // Establishes a database connection
        $dsn = "mysql:host=" . HOST . ";dbname=" . DBNAME;
        $db = new PDO($dsn, USER, PASSWORD);

        // Set encoding
        $db->exec("set names utf8");

        return $db;
    }

}
