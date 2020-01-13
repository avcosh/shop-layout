<?php
namespace Shop\entities;
/*
 * Model for working with Product
 */
use Shop\components\Db;
use Shop\interfaces\ProductInterface;

class Product implements ProductInterface
{
    public $product = [];
    
    public function getProducts()
    {
        
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM products');
        $productList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productList[$i]['id'] = $row['id'];
            $productList[$i]['name'] = $row['name'];
            $productList[$i]['price'] = $row['price'];
            
            $i++;
        }
        
        $this->product = $productList;
          
    }
    
}
