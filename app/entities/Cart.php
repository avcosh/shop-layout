<?php
namespace Shop\entities;
use Shop\interfaces\CartInterface;
use Shop\components\Db;

class Cart implements CartInterface
{
    public function AddToCart($request)
    {
        $db = Db::getConnection();
        $query = "INSERT INTO `carts` VALUES ";
        foreach ($request as $key => $value)
        {
            $query .= "( , (SELECT id FROM `products` WHERE `name` = '$key'), $value, (SELECT price FROM 
            `products` WHERE `name` = '$key') * $value),";
        }
        $result = $db->prepare($query);
        $result->execute();
    }        
}
