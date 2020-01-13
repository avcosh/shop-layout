<?php
namespace Shop\interfaces;


abstract class AppClass 
{
    public function getProduct(ProductInterface $product)
    {
        return new $product();   
    }
    
    public function getCart(CartInterface $cart)
    {
        return new $cart();
    }
}
