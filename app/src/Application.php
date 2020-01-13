<?php
namespace Shop\src;
/**
 * Main Controller
 */

use Shop\interfaces\AppClass;

class Application extends AppClass
{
    public $product;
    public $cart;
    public $order;
    
    public function __construct($product, $cart, $order)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->order = $order;
    }
    
    public function run($url)
    {
        /*
         * define action
         */
        switch($url){
            case '':
              return $this->index();
              break;
            case 'cart':
              return $this->cart();
              break;
            case 'order':
              return $this->order();
              break;
            default:
              return $this->index();
  }    
    }
    public function index()
    {
        $product = $this->getProduct($this->product);
        $product->getProducts();        
        $productList = $product->product;
        require_once(APP . '/views/index.php');
        return true;
        
    }
    
    public function cart()
    {
        $cart = $this->getCart($this->cart);
        $cart->AddToCart($_COOKIE);
        
    }
    
    public function order()
    {
        echo "order";
    }
               
}
