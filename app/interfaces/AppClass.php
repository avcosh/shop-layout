<?php
namespace Shop\interfaces;
/**
 * Class defines methods for working with entities
 */

abstract class AppClass 
{
    protected function getProduct(ProductInterface $product)
    {
        return new $product();   
    }
    
    protected function getCart(CartInterface $cart)
    {
        return new $cart();
    }
}
