<?php
namespace controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use controller\UserController;
use model\CartDAO;
use model\ProductDAO;
use PDOException;
use PDO;
class CartController{
    public function add(){
        $validateSession = new UserController();
        $validateSession->validateForLoggedUser();

            if (isset($_GET["id"])){
                $cartDAO=new CartDAO();
                $productDAO = new ProductDAO();
                $quantity = $productDAO->checkQuantity($_GET["id"]);
                    $check = $cartDAO->checkIfInCart($_GET["id"] , $_SESSION["logged_user_id"]);
                    if ($check){
                        if ($check["quantity"] < $quantity["quantity"]) {
                            $cartDAO->updateQuantityOfProductInCart($_GET["id"] , $_SESSION["logged_user_id"]);
                            include_once "view/cart.php";
                        }
                        else{
                            echo "<h1>No more available Pieces</h1>";
                            include_once "view/cart.php";

                        }
                    }
                    else{
                        $cartDAO->putInCart($_GET["id"] , $_SESSION["logged_user_id"]);
                        include_once "view/cart.php";


                    }
                }
    }

    public function show(){
        if(!isset($_SESSION["logged_user_id"])){
            include_once "view/login.php";
        }else{
            $cartDAO = new CartDAO();
            $productsInCart = $cartDAO->showCart($_SESSION["logged_user_id"]);
            $totalprice = 0;
            include_once "view/cart.php";
        }
    }
    public function update(){
        $validateSession = new UserController();
        $validateSession->validateForLoggedUser();
        if (isset($_POST["updateQuantity"])) {
            try {
                $productDAO=new ProductDAO();
                $productQuantity = $productDAO->checkQuantity($_POST["productId"]);
                if ($productQuantity["quantity"] >= $_POST["quantity"]) {
                    $cartDAO=new CartDAO();
                    $cartDAO->updateCartQuantity($_POST["productId"], $_POST["quantity"] , $_SESSION["logged_user_id"]);
                    $this->show();
                } else {
                    $this->show();
                    echo "<h3>Quantity Not Available</h3>";
                }

            } catch (PDOException $e) {
                include_once "view/main.php";
                echo "Oops, error 500!";

            }
        }

    }
    public function delete(){
        $validateSession = new UserController();
        $validateSession->validateForLoggedUser();
        try{
            $cartDAO=new CartDAO();
            $cartDAO->deleteProductFromCart($_GET["productId"] , $_SESSION["logged_user_id"]);
            $this->show();
        }catch (PDOException $e){
            echo "Not Gonna Work ";
            include_once "view/main.php";


        }
    }
}


