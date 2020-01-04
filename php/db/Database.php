<?php

require_once('cfg/cfg.php');

class Database
{
    private static $db = DB, $dbUser = DB_USER, $dbPass = DB_PASSWORD, $dbHost = DB_HOST;

    private $cartId;
    private $productNames = [];

    /**
     * Database constructor.
     * initial connection properties
     */
    public function __construct()
    {
        $this->getProductNames();
    }

    public static function create()
    {
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            exit();
        }
        /*queries*/
        $q1 = "CREATE TABLE IF NOT EXISTS `products` (
            `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
            `name` VARCHAR(50) UNIQUE NOT NULL,
            `price` DECIMAL (5,2) UNSIGNED NOT NULL)";
        $q2 = "CREATE TABLE IF NOT EXISTS `carts` (
            `id` TINYINT UNSIGNED NOT NULL,
            `product_id` TINYINT UNSIGNED NOT NULL,
            `quantity` TINYINT UNSIGNED NOT NULL,
            `amount` DECIMAL(5,2) UNSIGNED NOT NULL)
            ";
        $q3 = "CREATE TABLE IF NOT EXISTS `orders` (
            `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
            `cart_id` TINYINT UNSIGNED NOT NULL,
            `transport_id` TINYINT UNSIGNED NOT NULL,
            `amount` DECIMAL(5,2) UNSIGNED NOT NULL)
            ";
        if ($mysqli->query($q1) !== TRUE)
        {
            printf("Table products not created.<br /> $mysqli->error");
        }
        if ($mysqli->query($q2) !== TRUE)
        {
            printf("Table carts not created.<br />");
        }
        if ($mysqli->query($q3) !== TRUE)
        {
            printf("Table orders not created.<br />");
        }
        $mysqli->close();
    }

    public static function fill()
    {
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            exit();
        }
        /*query*/
        $q1 = "INSERT IGNORE INTO `products` VALUES (0, 'apple', 0.3),
            (0, 'beer', 2),
            (0, 'water', 1),
            (0, 'cheese', 3.74)
            ON DUPLICATE KEY UPDATE `id`=`id`";
        if ($mysqli->query($q1) !== TRUE)
        {
            printf("persisting into products failed.<br /> $mysqli->error");
        }
        $mysqli->close();
    }

    /**
     * @return string
     */
    public static function gainProducts()
    {
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
//            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            exit();
        }
        /*query*/
        $q1 = "SELECT * FROM `products`";
        if (!$products = $mysqli->query($q1))
        {
//            printf("select from products failed.<br /> $mysqli->error");
        }
        $mysqli->close();
        return $products->fetch_all();
    }

    public function setCart($arr)
    {
        $this->cartId = $this->getCart();
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
//            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            return 1;
        }
        $query = "INSERT INTO `carts` VALUES ";
        foreach ($arr as $k => $v)
        {
            if (is_int($v * 1) && in_array($k, $this->productNames))
            {
                $query .= "($this->cartId, (SELECT id FROM `products` WHERE `name` = '$k'), $v, (SELECT price FROM 
                `products` WHERE `name` = '$k') * $v),";
            }
        }
        $query = mb_ereg_replace('[,]?$', '', $query);
        if (!$result = $mysqli->query($query))
        {
//            printf("select from products failed.<br /> $mysqli->error");
        }

    }

    public function makeOrder($arr)
    {
        if (!array_key_exists('transport', $arr))
        {
            return 1;
        }
        switch ($arr['transport'])
        {
            case 0:
                $query = "INSERT INTO `orders` VALUES (0, $this->cartId, 0, (SELECT SUM(amount) FROM carts WHERE id = 
                    $this->cartId))";
                break;
            case 1:
                $query = "INSERT INTO `orders` VALUES (0, $this->cartId, 1, (SELECT SUM(amount) FROM carts WHERE id = 
                    $this->cartId)+5)";
                break;
            default:
                return 1;
        }
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
//            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            return 1;
        }
        if (!$result = $mysqli->query($query))
        {
//            printf("select from products failed.<br /> $mysqli->error");
        }
        return 0;
    }

    private function getCart()
    {
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
//            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            return 1;
        }
        $q1 = "SELECT id FROM `carts` ORDER BY `id` DESC LIMIT 1";
        if (!$cartId = $mysqli->query($q1))
        {
//            printf("select from products failed.<br /> $mysqli->error");
        }
        $mysqli->close();
        $result = $cartId->fetch_assoc();
        if ($result === null)
            return 1;
        else return ++$result['id'];
    }

    private function getProductNames()
    {
        $mysqli = new mysqli(self::$dbHost, self::$dbUser, self::$dbPass, self::$db);
        if ($mysqli->connect_errno)
        {
//            printf("Error while connecting to database: %s\n", $mysqli->connect_error);
            return 1;
        }
        $q1 = "SELECT name FROM `products`";
        if (!$names = $mysqli->query($q1))
        {
//            printf("select from products failed.<br /> $mysqli->error");
            return 1;
        }
        $mysqli->close();
        $names = $names->fetch_all();
        foreach ($names as $k => $val)
            array_push($this->productNames, $val[0]);
    }

}