<?php
namespace controller;
use Model\Address;
use Model\AddressDAO;
use model\CartDAO;
use model\OrderDAO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class OrderController{
    public function order()
    {

        try{
            if (isset($_POST["order"])){
                $orderedProducts = new CartDAO();
              $orderedProducts =  $orderedProducts->showCart($_SESSION["logged_user_id"]);
                OrderDAO::finishOrder($orderedProducts , $_POST["totalPrice"] , $_SESSION["logged_user_id"]);

            }
        }
        catch (PDOException $e){
          echo $e->getMessage();
        }
        $msg="Order received!";
        include_once "view/cart.php";
    }
    public function show(){
        try{
            $products= new OrderDAO();
            $products=$products->showOrders();
            include_once "view/orders.php";
        }
        catch (PDOException $e){
            echo  $e->getMessage();
        }

    }
}